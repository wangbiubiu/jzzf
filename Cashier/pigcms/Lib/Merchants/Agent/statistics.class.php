<?php

bpBase::loadAppClass('common', 'Agent', 0);
bpBase::loadOrg('common_page');
class statistics_controller extends common_controller
{
	private $AgentDb;
	public $aid;

	public function __construct()
	{
		parent::__construct();
		bpBase::loadOrg('checkFunc');
		$this->aid = $_SESSION['my_Cashier_Agent']['aid'];
		$checkFunc = new checkFunc();

		if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
			exit('error-4');
		}


		$checkFunc->cfdwdgfds3skgfds3szsd3idsj();
		$this->authorityControl(array('getchart', 'GetwxUserInfoFromSys', 'export_excel_zip', 'exportExcel'));
	}


	public function forSalesman () {
		if (!empty($_GET['username'])){
			$getdata['username'] = $this->clear_html($_GET['username']);
		}


		if (!empty($_GET['start']) || !empty($_GET['end'])){

			$this->isMonthAcross($_GET['start'],$_GET['end']);
		} 


		$where = !empty($_GET['username']) ? ' (`username` like "%'.$this->clear_html($_GET)['username'].'%"' .') AND ':'';
		$where.= ' `aid` = '.$this->aid;

		
		// 根据业务员分页
		$countSaler = M('cashier_salesmans')->count($where);
		$page = new Page($countSaler,4);
		$p = $page->show();

		$limitstr = $page->firstRow.','.$page->listRows;

		$getSalerSql = 'SELECT `id`,`username`,`commission`,alicommission FROM `'.$this->tablepre.'cashier_salesmans` WHERE '.$where.' ORDER BY id desc '.' LIMIT '.$limitstr;

		$salers = M('cashier_salesmans')->selectBysql($getSalerSql);
        
		$_obj = new model() ;

		//  搜索条件
		$getdata = $this->clear_html($_GET);
		$whereStr='';

		if ($getdata['start'] && $getdata['end']){
			$whereStr.=' AND paytime > '. strtotime($getdata['start']." 00:00:00") ;
			$whereStr.=' AND paytime <' .strtotime($getdata['end']." 23:59:59");
		}else{
            $whereStr.=' AND paytime < '.strtotime(date('Y:m:d 23:59:59',time()));
            $whereStr.=' AND paytime > '.strtotime(date('Y:m:d 00:00:00',time()));
		}

		$income=$num=$sum=0;
		foreach ($salers as $kk => &$vv) {

			$sql="select sum(income) as total,sum(salesmans_price) as sincome,sum(agent_price) as sumA ,pay_way,count(id) as num from ".$this->tablepre."cashier_order where mid in (select mid from ".$this->tablepre."cashier_merchants where sid = {$vv['id']}) AND `ispay` = 1".$whereStr." group by mid,pay_way ";


			$static = $_obj->selectBySql($sql);
			// p($static);
	        foreach ($static as $kkk => $vvv) {


	        	$income+=$vvv['sincome'];
	        	$sum+=$vvv['total'];
	        	$num+=$vvv['num'];

	        	if (isset($vvv['pay_way'])){
	        			
	        			$vv['static'][$vvv['pay_way']]['total'] += $vvv['total'];
	        			$vv['static'][$vvv['pay_way']]['num'] += $vvv['num'];
	        			$vv['static'][$vvv['pay_way']]['sincome'] += $vvv['sincome'];

	        			
	        	}

	        }
		}
		include $this->showTpl();
	}


	public function salerInfo () {

		//  搜索条件
		$getdata = $this->clear_html($_GET);
		if ($getdata['pay_way']) {
			$payway = ' AND pay_way="'.$getdata['pay_way'].'" ';
		}

		$user = M('cashier_salesmans')->get_one('id='.$getdata['id'],'username');
		if (!empty($getdata['start']) || !empty($getdata['end'])){
			$this->isMonthAcross($getdata['start'],$getdata['end']);
		} 

		$getSalerSql = ' SELECT `id`,`username`,`commission` FROM `'.$this->tablepre.'cashier_salesmans` WHERE `id` = '.$getdata['id'];
		$salers = M('cashier_salesmans')->selectBysql($getSalerSql);
		$_obj = new model();
		$whereStr='';

		if (!empty($getdata['start']) && !empty($getdata['end'])){
			$whereStr.='AND paytime > '. strtotime($getdata['start']." 00:00:00") ;
			$whereStr.=' AND paytime <' .strtotime($getdata['end']." 23:59:59");
		}
        else{
            $getdata['start'] = date('Y-m-d 00:00:00',  time());
            $getdata['end'] = date('Y-m-d 23:59:59',  time());
            $whereStr.='AND paytime > '. strtotime($getdata['start']) ;
            $whereStr.=' AND paytime <' .strtotime($getdata['end']);
            $getdata['start'] = date('Y-m-d',  time());
            $getdata['end'] = date('Y-m-d',  time());
        }


		$sqlListXCount = 'SELECT COUNT(id) as count FROM '.$this->tablepre. "cashier_order WHERE mid IN (SELECT mid FROM ".$this->tablepre."cashier_merchants where sid =".$_GET['id'].")  AND ispay='1' ".$whereStr.$payway;

		$res = $_obj->selectBySql($sqlListXCount);
      
		// 分页根据whereStr分页 2条sql的条件必须一样
		$page = new Page($res[0]['count'],10);
		
		$orderLimit = $page->firstRow.','.$page->listRows;
		$p = $page->show();

		// 获取订单
		$sqlList = 'SELECT id,mid,pay_way,income,paytime,refund,order_id,goods_price,goods_describe,storeid,ispay FROM '.$this->tablepre. "cashier_order WHERE mid IN (SELECT mid FROM ".$this->tablepre."cashier_merchants where sid =".$_GET['id']." ) AND `ispay`=1 ".$whereStr.$payway.' ORDER BY id desc LIMIT '.$orderLimit ;

		$orderList = $_obj->selectBySql($sqlList);

		foreach ($orderList as $ke => &$va) {

			$va['branch_name'] = M('cashier_stores')->get_var(array('id'=>$va['storeid']), $data = 'branch_name');
			$va['business_name'] = M('cashier_stores')->get_var(array('id'=>$va['storeid']), $data = 'business_name');
		}

		// 获取订单统计

		$sql="select sum(goods_price) as total,sum(income) as income,pay_way from ".$this->tablepre."cashier_order where mid in (select mid from ".$this->tablepre."cashier_merchants where sid =  ".$_GET['id'].") AND ispay='1' ".$whereStr.$payway." group by mid,pay_way ";
        
		$static = $_obj->selectBySql($sql);
		$sumIncome = 0;
		$sum = 0;
	      foreach ($static as $kkk => $vvv) {

	      	$sum+=$vvv['total'];
	      	$sumIncome+=$vvv['income'];

	      	$stc[$vvv['pay_way']]['total']+=$vvv['total']; 
	      	$stc[$vvv['pay_way']]['income']+=$vvv['income']; 
	      }
		include $this->showTpl();
	}

	// 商户统计Excel
	public function data2ExcelMerchants () {
		$obj = new model();
		$agent =M('cashier_agent')->get_var(array('aid'=>$this->aid),'uname');
		$mchs = M('cashier_merchants')->get_all('mid,username,commission,alicommission,qqcommission,mtype','',array('aid'=>$this->aid));
		// 字段
		$fields = 'mid,pay_way,sum(income) as income,sum(goods_price) as sum, count(id) as count';
		
		$list = array();
		foreach ($mchs as $k => &$v) {
			
			$whereStr = 'where ispay = 1 AND  mid ='.$v['mid'];
			$sql = 'select '.$fields.' from '.$this->tablepre.'cashier_order '.$whereStr.' AND pay_way = "weixin" ';
			$sql2 = 'select '.$fields.' from '.$this->tablepre.'cashier_order '.$whereStr.' AND pay_way = "alipay" ';
			$sql3= 'select '.$fields.' from '.$this->tablepre.'cashier_order '.$whereStr.' AND pay_way = "qq" ';
			
			$weixin = $obj->selectBySql($sql);
			$alipay = $obj->selectBySql($sql2);
			$qqpay = $obj->selectBySql($sql3);
			
			$arr = array();
			if ($weixin) {
				$arr['mid'] = $v['mid'];
				$arr['saler'] =$v['username'];
				$arr['income'] = $weixin[0]['income']?$weixin[0]['income']:0;
				$arr['count'] = $weixin[0]['count']?$weixin[0]['count']:0;
				$arr['pay_way'] = '微信支付';
				$arr['total'] = $weixin[0]['sum']?$weixin[0]['sum']:0;
				$arr['cms']  = $v['commission'];
			}else{
				$arr['mid'] = $v['mid'];
				$arr['saler'] =$v['username'];
				$arr['income'] = 0;
				$arr['count'] = 0;
				$arr['pay_way'] = '微信支付';
				$arr['total'] = 0;
				$arr['cms']  = $v['commission'];

			}
            
			$list[] =$arr;
			if($v['mtype']!=3){
    			$arr=array();
    			if ($alipay) {
    				$arr['mid'] = $v['mid'];
    				$arr['saler'] =$v['username'];
    				$arr['income'] = $alipay[0]['income']?$alipay[0]['income']:0;
    				$arr['count'] = $alipay[0]['count']?$alipay[0]['count']:0;
    				$arr['pay_way'] = '支付宝支付';
    				$arr['total'] = $alipay[0]['sum']?$alipay[0]['sum']:0;
    				$arr['cms']  = $v['alicommission'];
    			}else{
    				$arr['mid'] = $v['mid'];
    				$arr['saler'] =$v['username'];
    				$arr['income'] = '0';
    				$arr['count'] = '0';
    				$arr['pay_way'] = '支付宝';
    				$arr['total'] = '0';
    				$arr['cms']  = $v['alicommission'];
    
    			}
    			$list[] =$arr;	
			}
			if($v['mtype']==3){
    			$arr=array();
    			if ($qqpay) {
    			    $arr['mid'] = $v['mid'];
    			    $arr['saler'] =$v['username'];
    			    $arr['income'] = $qqpay[0]['income']?$qqpay[0]['income']:0;
    			    $arr['count'] = $qqpay[0]['count']?$qqpay[0]['count']:0;
    			    $arr['pay_way'] = 'qq';
    			    $arr['total'] = $qqpay[0]['sum']?$qqpay[0]['sum']:0;
    			    $arr['cms']  = $v['qqcommission'];
    			}else{
    			    $arr['mid'] = $v['mid'];
    			    $arr['saler'] =$v['username'];
    			    $arr['income'] = '0';
    			    $arr['count'] = '0';
    			    $arr['pay_way'] = 'qq';
    			    $arr['total'] = '0';
    			    $arr['cms']  = $v['qqcommission'];
    			
    			}
    			$list[] =$arr;
			}
		}


	// Excel
		$data = array();
		foreach ($list as $key => $v) {
			$data[$key]['name'] = $v['saler'];
			$data[$key]['payway'] = $v['pay_way'];
			$data[$key]['total'] = $v['total'];
			$data[$key]['count'] = $v['count'];
			$data[$key]['cms'] = $v['cms'];
			$data[$key]['income'] = $v['income'];
		}

	  $title = array('商户名称','支付方式','合计','支付笔数','当前费率','收入');
        $filename = '代理商:【'.$agent.'】下的所有业务员统计.xls';
        $this->ExportTable($data,$title,$filename);
		
	}


	public function data2ExcelSalesman() {

		// 查询数据


		$salers = M('cashier_salesmans')->get_all('id,username,commission','',array('aid'=>$this->aid));
		$obj = new model();
		$merchantsList_data1 = array();
		$merchantsList_data = array();
		foreach ($salers as $sk => $vv) {
		    //查询业务员下所有的商家id
			$merchants =$this->MerchantsID($vv['id']);
			//统计微信订单
			$sqlmer = "select pay_way,sum(goods_price) as total,sum(income) as income,count(id) as count from ".$this->tablepre."cashier_order WHERE mid in (".$merchants.") AND ispay=1 and pay_way='alipay' GROUP BY pay_way ";
			$merchantsList[$vv['id']] = $obj->selectBySql($sqlmer);
			//统计支付宝订单
			$sqlmer1 = "select pay_way,sum(goods_price) as total,sum(income) as income,count(id) as count from ".$this->tablepre."cashier_order WHERE mid in (".$merchants.") AND ispay=1 and pay_way='weixin' GROUP BY pay_way";
			$merchantsList1[$vv['id']] = $obj->selectBySql($sqlmer1);
			//支付宝
		    if(empty($merchantsList[$vv['id']])){
			    $merchantsList_data[$vv['id']]['username'] = $vv['username'];
			    $merchantsList_data[$vv['id']]['commission'] = $vv['commission'];
			    $merchantsList_data[$vv['id']]['pay_way'] = '支付宝城市';
			    $merchantsList_data[$vv['id']]['total'] = '0.00';
			    $merchantsList_data[$vv['id']]['income'] = '0.00';
			    $merchantsList_data[$vv['id']]['count'] = '0';
			}else{
			    $merchantsList_data[$vv['id']]['username'] = $vv['username'];
			    $merchantsList_data[$vv['id']]['commission'] = $vv['commission'];
			    $merchantsList_data[$vv['id']]['pay_way'] =  '支付宝城市';
			    $merchantsList_data[$vv['id']]['total']   = $merchantsList[$vv['id']][0]['total'];
			    $merchantsList_data[$vv['id']]['income']  = $merchantsList[$vv['id']][0]['income'];
			    $merchantsList_data[$vv['id']]['count']  = $merchantsList[$vv['id']][0]['count'];
			}
			//微信
			if(empty($merchantsList1[$vv['id']])){
			    $merchantsList_data1[$vv['id']]['username'] = $vv['username'];
			    $merchantsList_data1[$vv['id']]['commission'] = $vv['commission'];
			    $merchantsList_data1[$vv['id']]['pay_way'] = '微信支付';
			    $merchantsList_data1[$vv['id']]['total'] = '0.00';
			    $merchantsList_data1[$vv['id']]['income'] = '0.00';
			    $merchantsList_data1[$vv['id']]['count'] = '0';
			}else{
			    $merchantsList_data1[$vv['id']]['username'] = $vv['username'];
			    $merchantsList_data1[$vv['id']]['commission'] = $vv['commission'];
			    $merchantsList_data1[$vv['id']]['pay_way'] =  '微信支付';
			    $merchantsList_data1[$vv['id']]['total']   = $merchantsList1[$vv['id']][0]['total'];
			    $merchantsList_data1[$vv['id']]['income']  = $merchantsList1[$vv['id']][0]['income'];
			    $merchantsList_data1[$vv['id']]['count']  = $merchantsList1[$vv['id']][0]['count'];
			}
			
		}

		//重组excel数据
		$data =array();
		foreach ($merchantsList_data as $key => $v){
		    $data[] = $merchantsList_data[$key];
		    $data[] = $merchantsList_data1[$key];
		}	
        $title = array('业务员名称','当前费率','支付方式','总金额','收入','订单笔数');
        $filename = '代理商:【'.$agent['uname'].'】下的所有业务员统计.xls';

        $this->ExportTable($data,$title,$filename);

	}

	//业务员流水Excel
	public function info2Excel(){
		$getdata = $this->clear_html($_GET);
		$saler = M('cashier_salesmans')->get_var(array('id'=>$getdata['sid']),'username');
		$obj = new model();


		$fields = 'order_id,pay_way,income,paytime,goods_price,goods_describe,storeid,ispay,refund';
		$sql = 'select '.$fields.' from '.$this->tablepre.'cashier_order where mid in( select mid from '.$this->tablepre.'cashier_merchants where sid ='.$getdata['sid'].') AND ispay=1';

		$list = $obj->selectBySql($sql);
		// excel 数据组装
		$data =array();
		foreach ($list as $key => $v) {
			$data[$key]['order_id'] = '订单号：'.$v['order_id'];
			
			
			if ($v['pay_way']=='weixin'){
				$data[$key]['pay_way'] = '微信支付';
			}else{
				$data[$key]['pay_way'] = '支付宝城市';
			}
			
			
			$data[$key]['goods_price'] = $v['goods_price'];
			
			if($v['refund'] == 2){
			    $data[$key]['incomes'] = $v['goods_price'];
			}else{
			    $data[$key]['incomes'] = 0;
			}
			
			
			if($v['refund'] != 2){
			    $data[$key]['income'] = $v['income'];
			}else{
			    $data[$key]['income'] = 0;
			}
			
			
			
			
			$data[$key]['paytime'] = date('Y-m-d H:i:s',$v['paytime']);
			$data[$key]['goods_describe'] = $v['goods_describe'];
			$stores = M('cashier_stores')->get_one(array('id'=>$v['storeid']), 'branch_name,business_name');
			$data[$key]['storeid'] = $stores['branch_name'].'-'.$stores['business_name'];
			
			if($v['refund'] == '2'){
			    $data[$key]['refund'] = '已退款';
			}else if($v['refund'] != '2'){
			    $data[$key]['refund'] = '正常订单';
			}
		}

	    $title = array('订单编号','支付方式','应收金额','退款金额','实收金额','支付时间','交易类型','门店','支付状态');

        $filename = '业务员:【'.$saler.'】下的所有订单.xls';

        $this->ExportTable($data,$title,$filename);
		
	}


	// 商户流水Excel

	public function info2ExcelM () {
		$getdata = $this->clear_html($_GET);


		$merchant = M('cashier_merchants')->get_var(array('mid'=>$getdata['mid']),'username');
		$obj = new model();


		$fields = 'order_id,pay_way,income,paytime,goods_price,goods_describe,storeid,ispay,refund';

		$sql = 'select '.$fields.' from '.$this->tablepre.'cashier_order where mid = '.$getdata['mid'].' AND ispay=1';

		$list = $obj->selectBySql($sql);
		//p($list);die;
		// excel 数据组装
		$data =array();
		foreach ($list as $key => $v) {
		   $data[$key]['order_id'] = '订单号：'.$v['order_id'];
			
			
			if ($v['pay_way']=='weixin'){
				$data[$key]['pay_way'] = '微信支付';
			}else if($v['pay_way']=='alipay'){
				$data[$key]['pay_way'] = '支付宝';
			}else if($v['pay_way']=='qq'){
				$data[$key]['pay_way'] = 'qq';
			}
			
			
			$data[$key]['goods_price'] = $v['goods_price'];
			
			if($v['refund'] == 2){
			    $data[$key]['incomes'] = $v['goods_price'];
			}else{
			    $data[$key]['incomes'] = 0;
			}
			
			
			if($v['refund'] != 2){
			    $data[$key]['income'] = $v['income'];
			}else{
			    $data[$key]['income'] = 0;
			}
			
			
			
			
			$data[$key]['paytime'] = date('Y-m-d H:i:s',$v['paytime']);
			$data[$key]['goods_describe'] = $v['goods_describe'];
			$stores = M('cashier_stores')->get_one(array('id'=>$v['storeid']), 'branch_name,business_name');
			$data[$key]['storeid'] = $stores['branch_name'].'-'.$stores['business_name'];
			
			if($v['refund'] == '2'){
			    $data[$key]['refund'] = '已退款';
			}else if($v['refund'] != '2'){
			    $data[$key]['refund'] = '正常订单';
			}
			
		}

	   $title = array('订单编号','支付方式','应收金额','退款金额','实收金额','支付时间','交易类型','门店','支付状态');

        $filename = '商户:【'.$merchant.'】下的所有订单.xls';

        $this->ExportTable($data,$title,$filename);




	}

	public function MerchantsID($id){
	    if($id){
	        $sqlObj = new model();
	        $merchants_sql = "SELECT mid FROM ".$this->tablepre."cashier_merchants WHERE sid=".$id ;
	        $merchantsID =  $sqlObj->selectBySql($merchants_sql);
	        $mid = '';
	        foreach ($merchantsID as $key => $val){
	            $mid .= $val['mid'] .',';
	        }
	        $mid = substr($mid,0,strlen($mid)-1);
	        if($mid){
	            return $mid;
	        }else{
	            return false;
	        }
	    }else{
	        return false;
	    }
	     
	}


	public function isMonthAcross ($stime=0,$etime=0) {

		$stY = date('Y',strtotime($stime));

		$stM = date('m',strtotime($stime));

		$etY = date('Y',strtotime($etime));

		$etM = date('m',strtotime($etime));

		if ($stY!=$etY) {

			$this->errorTip('您的输入的时间已经跨月');

		} else if ($stM!=$etM){

			$this->errorTip('您的输入的时间已经跨月');

		}

		return array('startime'=>$stime,'endtime'=>$etime);
	}

	//获取当前代理商下的所有业务员
	public function getOwnSaler ($where='') {
		$sql = 'SELECT `id`,`username`,`commission` FROM `'.$this->tablepre.'cashier_salesmans` WHERE '.$where.' `aid` = '.$this->aid.' ORDER BY id desc';
		$salers = M('cashier_salesmans')->selectBysql($sql);
		return $salers;
	}

	// 商户统计
	public function forMerchants () {

		$getdata = $this->clear_html($_GET);

		$where['aid'] = $this->aid;
		if (isset($getdata['username'])) {
			$where['username'] = array('like',"%".$getdata['username']."%");
		}

		$pageCount = M('cashier_merchants')->count($where);

		$page = new Page($pageCount,10);
		$p = $page->show();
		$limitStr = $page->firstRow.','.$page->listRows;
		$fields = 'mid,aid,username,commission,company,alicommission,qqcommission,mtype';
		$order = '`mid` DESC';
		$merchants = M('cashier_merchants')->select($where,$fields,$limitStr,$order);

		// 进行统计
		$whereStr='';


		//检查是否跨月
		if (!empty($getdata['start'])|| !empty($getdata['end'])) {
			$this->isMonthAcross($getdata['start'],$getdata['end']);

		}


		if($getdata['start']){
            $whereStr.=" AND paytime >= '".strtotime($getdata['start']." 00:00:00")."'";
        }
        else{
            $whereStr.=" AND paytime >= '".strtotime(date("Y-m-d 00:00:00"))."'";
        }
        if($getdata['end']){
            $whereStr.=" AND paytime <= '".strtotime($getdata['end']." 23:59:59")."'";
        }
        else{
            $whereStr.=" AND paytime <= '".strtotime(date("Y-m-d 23:59:59"))."'";
        }
		$stcFied = 'id,pay_way,count(id) as num,SUM(income) AS total,SUM(agent_price) AS sincome ';

		

		$_obj = new model();
	

		$sum = array();
		foreach ($merchants as $kk => &$vv) {
			$sqlStc='';
			$sqlStc.=  'SELECT '.$stcFied;
			$sqlStc.=  ' from '.$this->tablepre.'cashier_order';
			$sqlStc.=  ' WHERE `mid` = '.$vv['mid'].' AND ispay=1 AND refund=0';
			$sqlStc.= $whereStr;
			$sqlStc.=  ' GROUP BY mid,pay_way';
			$static = $_obj->selectBySql($sqlStc);
			foreach ($static as $kkk => $vvv) {
					$sum['count']+=$vvv['num'];
					$sum['Total']+=$vvv['total'];
					$sum['Income']+=$vvv['sincome'];
					$vv['static'][$vvv['pay_way']]['total'] = $vvv['total'];
					$vv['static'][$vvv['pay_way']]['sincome']= $vvv['sincome'];
					$vv['static'][$vvv['pay_way']]['num'] = $vvv['num'];
			}	
		}

		include $this->showTpl();
	}

	
	public function merchantInfo () {
		$getdata = $this->clear_html($_GET);

		$user = M('cashier_merchants')->get_one('mid='.$getdata['mid'],'realname');
		
		$fields = 'id,sum(goods_price) as total,sum(income) as income,pay_way';
		$table = $this->tablepre.'cashier_order';
		$where = 'mid = '.$getdata['mid'].' AND ispay=1' ;
        if (!empty($getdata['start']) && !empty($getdata['end']) ){
            $this->isMonthAcross($getdata['start'],$getdata['end']);
        }
        if (!empty($getdata['start'])){
            $where .= ' AND paytime >='. strtotime($getdata['start']." 00:00:00");
        }
        else{
            $where .= ' AND paytime >='. strtotime(date("Y-m-d 00:00:00"));
        }
        if (!empty($getdata['end'])){
            $where .= ' AND paytime <= '. strtotime($getdata['end']." 23:59:59");
        }
        else{
            $where .= ' AND paytime <= '. strtotime(date("Y-m-d 23:59:59"));
        }
		if ($getdata['pay_way']) {
			$payway =  ' AND pay_way= "'.$getdata['pay_way'].'"';
		}

		$groupStr  = ' pay_way ';

		$sql = " SELECT ".$fields .' FROM '.$table.' WHERE '.$where.$payway.' GROUP BY '.$groupStr;
		$obj = new model();

		$stc = $obj->selectBySql($sql);
		$sumTotal = 0 ;
		$sumIncome = 0;

		foreach ($stc as $mk => $mv) {
			$stc[$mv['pay_way']]['total']=$mv['total'];
			$sumTotal+=$mv['total'];
			$stc[$mv['pay_way']]['income']=$mv['income'];
			$sumIncome+=$mv['income'];
		}
//         var_dump($stc);die;
		// 订单列表
		$whereStr = 'mid = ' .$getdata['mid']. '  AND ispay=1 '.$payway;
        if (!empty($getdata['start'])){
            $whereStr .= ' AND paytime >='. strtotime($getdata['start']." 00:00:00");
        }
        else{
            $whereStr .= ' AND paytime >='. strtotime(date("Y-m-d 00:00:00"));
        }
        if (!empty($getdata['end'])){
            $whereStr .= ' AND paytime <= '. strtotime($getdata['end']." 23:59:59");
        }
        else{
            $whereStr .= ' AND paytime <= '. strtotime(date("Y-m-d 23:59:59"));
        }

		$fieldstr = 'id,income,order_id,pay_way,pay_type,refund,goods_price,mid,goods_describe,storeid,paytime';

		$orderCount = M('cashier_order')->count($whereStr.$payway);
		$page = new Page ($orderCount,10);
		$p = $page->show();
		$orderLimit = $page->firstRow.','.$page->listRows;

		$orderList = M('cashier_order')->select($whereStr.$payway,$fieldstr,$orderLimit,"id DESC");
		foreach ($orderList as $mmk => &$mmv) {
			$mmv['branch_name'] = M('cashier_stores')->get_var(array('id'=>$mmv['storeid']), $data = 'branch_name');
			$mmv['business_name'] = M('cashier_stores')->get_var(array('id'=>$mmv['storeid']), $data = 'business_name');
		}
		
		$mtype=M('cashier_merchants')->get_one(array('mid'=>$_SESSION['mid']));$mtype=$mtype['mtype'];
		include $this->showTpl();
	}
}


?>
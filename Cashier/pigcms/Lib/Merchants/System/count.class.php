<?php
//总后台统计管理
bpBase::loadAppClass('common', 'System', 0);
class count_controller extends common_controller
{
    	public function __construct()
    	{
    		parent::__construct();
                    
    	}
      
        //代理商统计
        public function agent(){
            
            $getdata = $this->clear_html($_GET);
            $where = " ispay='1'";

            if (!empty($getdata['start']) || !empty($getdata['end'])){
		$this->isMonthAcross($getdata['start'],$getdata['end']);
                $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
                $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
            } else{
                $start = strtotime(date('Y-m-d',  time()));
                $end = time();
            }

            
            if (0 < $start) {
                    $where .= ' AND paytime>=' . $start; 
            }
            if (0 < $end) {
                if($getdata['end']){
                    $end+=86400;
                }
                    $where .= ' AND paytime<' . $end;
            }
            if($getdata['uname']){
                $wherestr = " uname like '%".$getdata['uname']."%'";
            }
            bpBase::loadOrg('common_page');
            $agentDb = M('cashier_agent');
            $_count = $agentDb->count($wherestr);
            $p = new Page($_count, 10);
            $pagebar = $p->show(2);
            //查出所有的代理商
            $agents = M('cashier_agent')->select($wherestr,'*',"$p->firstRow,$p->listRows",'aid asc');
            foreach($agents as $k=>$v){
                $wxsum=0;
                $wxnum=0;
                $wxincome=0;
                $qqsum=0;
                $qqnum=0;
                $qqincome=0;
                $alisum=0;
                $alinum=0;
                $aliincome=0;
                $agents[$k]['mid'] = M('cashier_merchants')->select(' aid='.$v['aid'],'mid');
                foreach ($agents[$k]['mid'] as $key=>&$val){
                    //微信支付总和
                    $wxsql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` where".$where." AND pay_way='weixin' AND mid=".$val['mid'];
                    $val['wxsum'] = M('cashier_order')->get_varBySql($wxsql,'sum');
                  
                    $wxsum+= M('cashier_order')->get_varBySql($wxsql,'sum');
                    $wxnum+= M('cashier_order')->count($where." AND pay_way='weixin' AND mid=".$val['mid']);
                    $wxincome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` where ".$where." AND pay_way='weixin' AND mid=".$val['mid'];
                    $val['wxincome'] = M('cashier_order')->get_varBySql($wxincome_sql,'sum');
                    $wxincome+= M('cashier_order')->get_varBySql($wxincome_sql,'sum');
                    //支付宝总和
                    $alisql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` where ".$where."  AND pay_way='alipay' AND mid=".$val['mid'];
                    $val['alisum'] = M('cashier_order')->get_varBySql($alisql,'sum'); 
                    $alisum+= M('cashier_order')->get_varBySql($alisql,'sum');
                    $alinum+= M('cashier_order')->count($where." AND pay_way='alipay' AND mid=".$val['mid']);
                    $aliincome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` where ".$where."  AND pay_way='alipay' AND mid=".$val['mid'];
                    $val['aliincome'] = M('cashier_order')->get_varBySql($aliincome_sql,'sum'); 
                    $aliincome+= M('cashier_order')->get_varBySql($aliincome_sql,'sum');
                    //财付通支付总和
                    $qqsql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` where".$where." AND pay_way='qq' AND mid=".$val['mid'];
                    $val['qqsum'] = M('cashier_order')->get_varBySql($qqsql,'sum');
                     
                    $qqsum+= M('cashier_order')->get_varBySql($qqsql,'sum');
                    $qqnum+= M('cashier_order')->count($where." AND pay_way='qq' AND mid=".$val['mid']);
                    $qqincome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` where ".$where." AND pay_way='qq' AND mid=".$val['mid'];
                    $val['qqincome'] = M('cashier_order')->get_varBySql($qqincome_sql,'sum');
                    $qqincome+= M('cashier_order')->get_varBySql($qqincome_sql,'sum');
                    //总金额
                   $data['sum']+= $val['wxsum']+$val['alisum']+$val['qq'];                  
                   //总收入
                   $data['income']+= $val['wxincome']+$val['aliincome']+$val['qqincome'];
                }
                
                //总笔数
                 $data['count']+= $wxnum+$alinum+$qqnum;
                 //统计的数据
                 $agents[$k]['wxsum'] = $wxsum;
                 $agents[$k]['wxnum'] = $wxnum;
                 $agents[$k]['wxincome'] = $wxincome;
                 $agents[$k]['qqsum'] = $qqsum;
                 $agents[$k]['qqnum'] = $qqnum;
                 $agents[$k]['qqincome'] = $qqincome;
                 $agents[$k]['alisum'] = $alisum;
                 $agents[$k]['alinum'] = $alinum;
                 $agents[$k]['aliincome'] = $aliincome;
                 
            }
            
            $this->assign('pagebar',$pagebar);
            $this->assign('data',$data);
            $this->assign('getdata',$getdata);
            $this->assign('agents',$agents);
            $this->display('agent');
        }
        
         //代理详情页面
        public function agentdetail(){
            //传过来的代理商id存入session
            if($_GET['aid']){
                $_SESSION['aid'] = $_GET['aid'];
            }
            $name = M('cashier_agent')->get_one('aid='.$_SESSION['aid'],'uname');
           
            $getdata = $this->clear_html($_GET);
            
            $where = " ispay='1'";
            if(!empty($getdata['start']) || !empty($getdata['end'])){
                $this->isMonthAcross($getdata['start'],$getdata['end']);
                $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
                $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
            }else{
                $start = strtotime(date('Y-m-d',  time()));
                $end = time();
            }
            
            //搜索条件
            if (0 < $start) {
                    $where .= ' AND paytime>=' . $start;
            }
            if (0 < $end) {
                    if($getdata['end']){
                        $end+=86400;
                    }
                    $where .= ' AND paytime<' . $end;
            } 
           
            //查询出所有商户
            $mer = M('cashier_merchants')->select(' aid='.$_SESSION['aid'],'username,mid');

            foreach($mer as $k=>&$v){
                $mids .= $v['mid'].',';
                if($getdata['type']=='weixin'){
                    //微信统计
                    $wxsql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='weixin' AND mid=".$v['mid'];        
                    $wxincome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='weixin' AND mid=".$v['mid'];
                    $wxsum+= M('cashier_order')->get_varBySql($wxsql,'sum')?:0;
                    $wxincome_sum+= M('cashier_order')->get_varBySql($wxincome_sql,'sum')?:0;
                }elseif($getdata['type']=='alipay'){
                    //支付宝统计
                    $alisql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='alipay' AND mid=".$v['mid'];             
                    $alicome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='alipay' AND mid=".$v['mid'];
                    $alisum+= M('cashier_order')->get_varBySql($alisql,'sum')?:0;
                    $alicome_sum+= M('cashier_order')->get_varBySql($alicome_sql,'sum')?:0;
                }elseif($getdata['type']=='qq'){
                    //qq统计
                    $qqsql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='qq' AND mid=".$v['mid'];             
                    $qqcome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='qq' AND mid=".$v['mid'];
                    $qqsum+= M('cashier_order')->get_varBySql($qqsql,'sum')?:0;
                    $qqcome_sum+= M('cashier_order')->get_varBySql($qqcome_sql,'sum')?:0;
                }else{
                    //微信统计
                    $wxsql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='weixin' AND mid=".$v['mid'];        
                    $wxincome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='weixin' AND mid=".$v['mid'];
                    $wxsum+= M('cashier_order')->get_varBySql($wxsql,'sum')?:0;
                    $wxincome_sum+= M('cashier_order')->get_varBySql($wxincome_sql,'sum')?:0;
                     //支付宝统计
                    $alisql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='alipay' AND mid=".$v['mid'];             
                    $alicome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='alipay' AND mid=".$v['mid'];
                    $alisum+= M('cashier_order')->get_varBySql($alisql,'sum')?:0;
                    $alicome_sum+= M('cashier_order')->get_varBySql($alicome_sql,'sum')?:0;
                    //qq统计
                    $qqsql = "SELECT SUM(`goods_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='qq' AND mid=".$v['mid'];
                    $qqcome_sql = "SELECT SUM(`agent_price`) as sum FROM `".$this->tablepre."cashier_order` WHERE ".$where." AND pay_way='qq' AND mid=".$v['mid'];
                    $qqsum+= M('cashier_order')->get_varBySql($qqsql,'sum')?:0;
                    $qqcome_sum+= M('cashier_order')->get_varBySql($qqcome_sql,'sum')?:0;
                }
                
            }
            //取得所有商户的id
            $mids = rtrim($mids,',');

            //分页类
            bpBase::loadOrg('common_page');
            $orderDb = M('cashier_order');
            if($getdata['type']){
                $wherestr = " AND pay_way='".$getdata['type']."'";
            }else{
                $wherestr = "";
            }
            $_count = $orderDb->count($where.$wherestr." AND mid in(".$mids.")");
            $p = new Page($_count, 10);
            $pagebar = $p->show(2);
            //查询出这个代理商下面的所有商户订单 分页显示
            
            $order_sql = "SELECT o.*,m.company,s.branch_name,s.business_name FROM `".$this->tablepre."cashier_order` as o LEFT JOIN `".$this->tablepre."cashier_merchants` as m ON o.mid=m.mid LEFT JOIN  `".$this->tablepre."cashier_stores` as s ON s.id=o.storeid WHERE ".$where.$wherestr." AND o.mid in(".$mids.") ORDER BY o.paytime desc";
            $order_sql.= " LIMIT " . $p->firstRow . ',' . $p->listRows;
            
            $order = M('cashier_order')->selectBySql($order_sql);
            foreach($order as &$v){
                $v['paytime'] = (($v['paytime'] ? date('Y-m-d H:i:s', $v['paytime']) : ''));
            }
          //  dump($order);
           //总计
            $total_sum = $wxsum+$alisum;
            $totalincome_sum = $wxincome_sum+$alicome_sum;
            $this->assign("today",date("Y-m-d"));
            $this->assign("wxsum",$wxsum);
            $this->assign("wxincome_sum",$wxincome_sum);
            $this->assign("alisum",$alisum);
            $this->assign("alicome_sum",$alicome_sum);
            $this->assign("qqsum",$qqsum);
            $this->assign("qqcome_sum",$qqcome_sum);
            $this->assign("total_sum",$total_sum);
            $this->assign("totalincome_sum",$totalincome_sum);
            $this->assign("getdata",$getdata);
            $this->assign("name",$name);
            $this->assign('order',$order);
            $this->assign('pagebar',$pagebar);
            $this->display();
        }
                
        //商户统计
        public function merchant(){
            $getdata = $this->clear_html($_GET);
            $where = " ispay='1'";
            
             if (!empty($getdata['start']) || !empty($getdata['end'])){
		$this->isMonthAcross($getdata['start'],$getdata['end']);
                 $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
                 $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
            } else{
                $start = strtotime(date('Y-m-d',  time()));
                $end = time();
            }
           
            
            if (0 < $start) {
                    $where .= ' AND paytime>=' . $start;                    
            }
            if (0 < $end) {
                    if($getdata['end']){
                        $end+=86400;
                    }
                    $where .= ' AND paytime<' . $end;                  
            }
            if($getdata['mtype']){
                $wherestr = " mtype=".$getdata['mtype'];
//                $where .= " AND mchtype=".$getdata['mtype'];
            }
            if($getdata['username']){
                if($getdata['mtype']){
                    $wherestr .= " AND username like '%".$getdata['username']."%'";
                }else{
                    $wherestr .= " username like '%".$getdata['username']."%'";
                }
                
            }
            bpBase::loadOrg('common_page');
            $merDb = M('cashier_merchants');
            $_count = $merDb->count($wherestr);
            $p = new Page($_count, 10);
            $pagebar = $p->show(2);
            $mer = M('cashier_merchants')->select($wherestr,"mid,company,commission,alicommission,qqcommission,mtype","$p->firstRow,$p->listRows");
            foreach($mer as $k=>$v){
                $wxsql = "SELECT SUM(`goods_price`) as money,SUM(`income`) as income,count(`id`) as count FROM `".$this->tablepre."cashier_order` where ".$where." AND pay_way='weixin'  AND mid=".$v['mid'];
                $mer[$k]['wxsum'] = M('cashier_merchants')->selectBySql($wxsql);
                $alisql = "SELECT SUM(`goods_price`) as money,SUM(`income`) as income,count(`id`) as count FROM `".$this->tablepre."cashier_order` where".$where." AND pay_way='alipay' AND mid=".$v['mid'];
                $mer[$k]['alisum'] = M('cashier_merchants')->selectBySql($alisql);
                $qqsql = "SELECT SUM(`goods_price`) as money,SUM(`income`) as income,count(`id`) as count FROM `".$this->tablepre."cashier_order` where".$where." AND pay_way='qq' AND mid=".$v['mid'];
                $mer[$k]['qqsum'] = M('cashier_merchants')->selectBySql($qqsql);
                
                $total+= $mer[$k]['wxsum'][0]['money']+$mer[$k]['alisum'][0]['money']+$mer[$k]['qqsum'][0]['money'];
                $income+= $mer[$k]['wxsum'][0]['income']+$mer[$k]['alisum'][0]['income']+$mer[$k]['qqsum'][0]['income'];
                $count+= $mer[$k]['wxsum'][0]['count']+$mer[$k]['alisum'][0]['count']+$mer[$k]['qqsum'][0]['count'];
            }
            $today = date("Y-m-d");
            $this -> assign("today",$today);
            $this->assign('mer',$mer);
            $this->assign('total',$total);
            $this->assign('income',$income);
            $this->assign('count',$count);
            $this->assign('getdata',$getdata);
            $this->assign("pagebar",$pagebar);
            $this->display();
        }
        
        //商户统计详情
        public function mdetail(){
             //传过来的商户id存入session
            if($_GET['mid']){
                $_SESSION['mid'] = $_GET['mid'];
            }
           $name = M('cashier_merchants')->get_one('mid='.$_SESSION['mid'],'company');
           
            $getdata = $this->clear_html($_GET);
            
            $where = " ispay='1' ";
            $wherestr = " o.ispay='1' ";

            if (!empty($getdata['start'])){
                $start = strtotime($getdata['start']." 00:00:00");
            }
            else{
                $start = strtotime(date("Y-m-d 00:00:00"));
            }
            if (!empty($getdata['end'])){
                $end = strtotime($getdata['end']." 23:59:59");
            }
            else{
                $end = strtotime(date("Y-m-d 23:59:59"));
            }


            
            //搜索条件
            if (0 < $start) {
                    $where .= ' AND paytime>=' . $start;
                    $wherestr .= ' AND o.paytime>=' . $start;
            }
            if (0 < $end) {
                if($getdata['type']){
                    $end+=86400;
                }
                    $where .= ' AND paytime<' . $end;
                    $wherestr .= ' AND o.paytime<' . $end;
            }
            
//            if($getdata['type']=='weixin'){
//                $wxsum = M('cashier_order')->select($where.' AND pay_way="weixin" AND mid='.$_SESSION['mid']," SUM(`goods_price`) as money,SUM(`income`) as income ");
//            }elseif($getdata['type']=='alipay'){
//                $alisum = M('cashier_order')->select($where.' AND pay_way="alipay" AND mid='.$_SESSION['mid']," SUM(`goods_price`) as money,SUM(`income`) as income "); 
//            }else{
                $wxsum = M('cashier_order')->select($where.' AND pay_way="weixin" AND mid='.$_SESSION['mid']," SUM(`goods_price`) as money,SUM(`income`) as income ");
                $alisum = M('cashier_order')->select($where.' AND pay_way="alipay" AND mid='.$_SESSION['mid']," SUM(`goods_price`) as money,SUM(`income`) as income ");
                $qqsum = M('cashier_order')->select($where.' AND pay_way="qq" AND mid='.$_SESSION['mid']," SUM(`goods_price`) as money,SUM(`income`) as income ");
                $total_sum = M('cashier_order')->select($where.' AND mid='.$_SESSION['mid']," SUM(`goods_price`) as money,SUM(`income`) as income ");                
          //  }
           
            //分页类
            bpBase::loadOrg('common_page');
            $orderDb = M('cashier_order');
            if($getdata['type']){
                $wherepay = " AND pay_way='".$getdata['type']."'";
            }else{
                $wherepay = "";
            }
            $_count = $orderDb->count($where.$wherepay." AND mid=".$_SESSION['mid']);
            $p = new Page($_count, 10);
            $pagebar = $p->show(2);
            //查询出这个商户下面的所有商户订单 分页显示
            $order_sql = "SELECT o.*,s.business_name,s.branch_name FROM `".$this->tablepre."cashier_order` as o LEFT JOIN  `".$this->tablepre."cashier_stores` as s ON s.id=o.storeid WHERE ".$wherestr.$wherepay." AND o.mid=".$_SESSION['mid']." ORDER BY o.paytime desc";
            $order_sql.= " LIMIT " . $p->firstRow . ',' . $p->listRows;
            $order = M('cashier_order')->selectBySql($order_sql);
             foreach($order as &$v){
                $v['paytime'] = (($v['paytime'] ? date('Y-m-d H:i:s', $v['paytime']) : ''));
            }
            $this->assign("today",date("Y-m-d"));
            $this->assign('name',$name);
            $this->assign("wxsum",$wxsum);
            $this->assign("alisum",$alisum);
            $this->assign("qqsum",$qqsum);
            $this->assign("total_sum",$total_sum);
            $this->assign('order',$order);
            $this->assign('pagebar',$pagebar);
            $this->assign('getdata',$getdata);
            $this->display();
        }
        
        
        
        //导出Excel 代理商or商户
        public function data2Excel () {
            $getdata = $this->clear_html($_GET);
            $data = array();
        
            $fields = "pay_way, sum(goods_price) as sum ,count(id) as count ,sum(income) as income ";
            if ($getdata['type'] == 'a') {
                $agent =  m('cashier_agent')->get_all('aid,uname,commission,alicommission,qqcommission');
                foreach ($agent as $ak => $av) {
                    $sqlwx = "select ".$fields."  from ".$this->tablepre."cashier_order where mid in (select mid from ".$this->tablepre."cashier_merchants where  aid = ".$av['aid'].") AND pay_way='weixin' AND ispay=1";
                    $wx = M('cashier_order')->selectBySql($sqlwx);
                     
                    $arr = array();
                    if($wx){
                         
                        $arr['name'] = $av['uname'];
                        $arr['pay_way']='微信支付';
                        $arr['sum'] = $wx[0]['sum'] ? $wx[0]['sum'] : 0;
                        $arr['count'] = $wx[0]['count']?$wx[0]['count']:0;
                        $arr['cms'] = $av['commission'];
                        $arr['income'] = $wx[0]['income']?$wx[0]['income']:0;
                    }else{
                        $arr['aid'] =  $av['aid'];
                        $arr['name'] = $av['uname'];
                        $arr['pay_way']='微信支付';
                        $arr['sum'] = 0;
                        $arr['count'] = 0;
                        $arr['cms'] = $av['commission'];
                        $arr['income'] = 0;
                         
                    }
        
                    $data[]=$arr;
                    $arr=array();
                    $sqlal = "select ".$fields."  from ".$this->tablepre."cashier_order where mid in (select mid from ".$this->tablepre."cashier_merchants where  aid = ".$av['aid'].") AND pay_way='alipay' and ispay=1 ";
                    $ali = M('cashier_order')->selectBySql($sqlal);
                    if($ali){
        
                        $arr['name'] = $av['uname'];
                        $arr['pay_way']='支付宝';
                        $arr['sum'] = $ali[0]['sum']?$ali[0]['sum']:0;
                        $arr['count'] = $ali[0]['count']?$ali[0]['count']:0;
                        $arr['cms'] = $av['alicommission'];
                        $arr['income'] = $ali[0]['income']?$ali[0]['income']:0;
                         
                    }else{
                         
                        $arr['name'] = $av['uname'];
                        $arr['pay_way']='支付宝';
                        $arr['sum'] = 0;
                        $arr['count'] = 0;
                        $arr['cms'] = $av['alicommission'];
                        $arr['income'] = 0;
        
                    }
        
                    $data[] =$arr;
                    $arr=array();
                    $sqlqq = "select ".$fields."  from ".$this->tablepre."cashier_order where mid in (select mid from ".$this->tablepre."cashier_merchants where  aid = ".$av['aid'].") AND pay_way='qq' and ispay=1 ";
                    $qq = M('cashier_order')->selectBySql($sqlqq);
                    if($qq){
                    
                        $arr['name'] = $av['uname'];
                        $arr['pay_way']='qq';
                        $arr['sum'] = $qq[0]['sum']?$qq[0]['sum']:0;
                        $arr['count'] = $qq[0]['count']?$qq[0]['count']:0;
                        $arr['cms'] = $av['qqcommission'];
                        $arr['income'] = $qq[0]['income']?$qq[0]['income']:0;
                         
                    }else{
                         
                        $arr['name'] = $av['uname'];
                        $arr['pay_way']='qq';
                        $arr['sum'] = 0;
                        $arr['count'] = 0;
                        $arr['cms'] = $av['qqcommission'];
                        $arr['income'] = 0;
                    
                    }
                    
                    $data[] =$arr;
                    $title = array('代理商名称','支付方式','支付金额(元)','交易笔数','当前费率','收入');
                    $filename = '代理商统计'.date('Y-m-d',time()).'.xls';
                }
            }
        
        
        
            if ($getdata['type']=='m'){
                 
                $merchants = M('cashier_merchants')->get_all('mid,username,commission,qqcommission,alicommission,company,mtype','');
                 
                foreach ($merchants as $mk => $mv) {
                    $sqlwx = "select ".$fields."  from ".$this->tablepre."cashier_order where mid =".$mv['mid']." AND pay_way='weixin' AND ispay=1";
                    $wx = M('cashier_order')->selectBySql($sqlwx);
                    $arr = array();
                    if($wx){
                        $arr['name'] = $mv['company'];
                        $arr['pay_way']='微信支付';
                        $arr['sum'] = $wx[0]['sum'] ? $wx[0]['sum'] : 0;
                        $arr['income'] = $wx[0]['income']?$wx[0]['income']:0;
                        $arr['cms'] = $mv['commission'];
                        $arr['count'] = $wx[0]['count']?$wx[0]['count']:0;
                    }else{
                        $arr['name'] = $mv['company'];
                        $arr['pay_way']='微信支付';
                        $arr['sum'] = 0;
                        $arr['income'] = 0;
                        $arr['cms'] = $mv['commission'];
                        $arr['count'] = 0;
                    }
        
                    $data[]=$arr;
                    if($mv['mtype']!=3)
                    {
                        $arr=array();
                        $sqlal = "select ".$fields."  from ".$this->tablepre."cashier_order where mid =".$mv['mid']." AND pay_way='alipay' and ispay=1 ";
                        $ali = M('cashier_order')->selectBySql($sqlal);
                        
                        
                        
                        if($ali){
                            $arr['name'] = $mv['company'];
                            $arr['pay_way']='支付宝';
                            $arr['sum'] = $ali[0]['sum']?$ali[0]['sum']:0;
                            $arr['income'] = $ali[0]['income']?$ali[0]['income']:0;
                            $arr['cms'] = $mv['alicommission'];
                            $arr['count'] = $ali[0]['count']?$ali[0]['count']:0;
                        }else{
                        
                            $arr['name'] = $mv['company'];
                            $arr['pay_way']='支付宝';
                            $arr['sum'] = 0;
                            $arr['count'] = 0;
                            $arr['cms'] = $mv['alicommission'];
                            $arr['income'] = 0;
                             
                        }
                        
                        $data[] =$arr;
                    }
                    if($mv['mtype']==3)
                    {
                        $arr=array();
                        $sqlqq = "select ".$fields."  from ".$this->tablepre."cashier_order where mid =".$mv['mid']." AND pay_way='qq' and ispay=1 ";
                        $qq = M('cashier_order')->selectBySql($sqlqq);
                        
                        
                        
                        if($qq){
                            $arr['name'] = $mv['company'];
                            $arr['pay_way']='qq';
                            $arr['sum'] = $qq[0]['sum']?$qq[0]['sum']:0;
                            $arr['income'] = $qq[0]['income']?$qq[0]['income']:0;
                            $arr['cms'] = $mv['qqcommission'];
                            $arr['count'] = $qq[0]['count']?$qq[0]['count']:0;
                        }else{
                        
                            $arr['name'] = $mv['company'];
                            $arr['pay_way']='qq';
                            $arr['sum'] = 0;
                            $arr['count'] = 0;
                            $arr['cms'] = $mv['qqcommission'];
                            $arr['income'] = 0;
                             
                        }
                        
                        $data[] =$arr;
                    }
        
                    $title = array('商户名称','支付方式','支付金额(元)','交易笔数','当前费率','收入');
                    $filename = '商户统计'.date('Y-m-d',time()).'.xls';
                }
                 
            }
            $this->ExportTable($data,$title,$filename);
        }
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        



        // 导出订单 商户或者代理
        public function data2ExcelDetail () {

            $getdata = $this->clear_html($_GET);
            $fields = 'mid,pay_way,goods_price,order_id,goods_describe,income,paytime,storeid,goods_name';
            $data = array();
            if ($getdata['mid']>0) {
                $merchant = M('cashier_merchants')->get_var(array('mid'=>$getdata['mid']),'company');
                $orders = M('cashier_order')->get_all($fields,'',array('mid'=>$getdata['mid'],'ispay'=>1),'');
              
                foreach ($orders as $k => $v) {
                    $data[$k]['order_id'] = '订单号:'.$v['order_id'];
                    $data[$k]['goods_price'] = $v['goods_price'];
                    $data[$k]['income'] = $v['income'];
                    $data[$k]['paytime'] = date('Y-m-d H:i:s',$v['paytime']);
                    $data[$k]['pay_way'] = $v['pay_way']=='weixin' ? '微信支付' : '支付宝城市';
                    $data[$k]['goods_describe'] = $v['goods_describe'];
                    $data[$k]['store'] = M('cashier_stores')->get_var(array('id'=>$v['storeid']),'branch_name');
                }

                $title = array('订单号','应收金额','实收金额','交易时间','交易类型','付款方式','门店');
                $filename = $merchant.':订单流水详细.xls';
            }

            if ($getdata['aid']>0) {

                $agent = M('cashier_agent')->get_var(array('aid'=>$getdata['aid']),'uname');
                $obj = new model();

                $sqlGetOrders = 'select '.$fields. ' from '.$this->tablepre.'cashier_order where mid in (select mid from '.$this->tablepre.'cashier_merchants where aid = '.$getdata['aid'].' ) AND ispay=1';
 
                $orders = $obj->selectBySql($sqlGetOrders);

                foreach ($orders as $k => $v) {
                    $data[$k]['order_id'] = '订单号:'.$v['order_id'];
                    $data[$k]['goods_price'] = $v['goods_price'];
                    $data[$k]['income'] = $v['income'];
                    $data[$k]['paytime'] = date('Y-m-d H:i:s',$v['paytime']);
                    $data[$k]['pay_way'] = $v['pay_way']=='weixin' ? '微信支付' : '支付宝城市';
                    $data[$k]['goods_describe'] = $v['goods_describe'];
                    $data[$k]['store'] = M('cashier_stores')->get_var(array('id'=>$v['storeid']),'branch_name');
                }

                $title = array('订单号','应收金额','实收金额','交易时间','交易类型','付款方式','门店');
                $filename = $agent.':订单流水详细.xls';       
            }
        $this->ExportTable($data,$title,$filename);
        }
        //判断是否跨月/跨年
        public function isMonthAcross ($stime=0,$etime=0) {

		$stY = date('Y',strtotime($stime));

		$stM = date('m',strtotime($stime));

		$etY = date('Y',strtotime($etime));

		$etM = date('m',strtotime($etime));
                
                if(!$stime){
                   $this->errorTip('请选择开始时间!'); 
                }
                if(!$etime){
                   $this->errorTip('请选择结束时间!'); 
                }
		if ($stY!=$etY) {

			$this->errorTip('您的选择的时间不能跨年');

		} else if ($stM!=$etM){

			$this->errorTip('您的选择的时间不能跨月');

		}

		
	}
	
}


?>


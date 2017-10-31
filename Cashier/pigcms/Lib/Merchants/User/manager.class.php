
<?php 
bpBase::loadAppClass('common', 'User', 0);
/**
 * 
 * @author 店长控制器
 *
 */
class manager_controller extends common_controller
{


	public function __construct()
	{
	    
		parent::__construct();
		
	}
	/**
	 * 首页
	 */
    public function index(){
        $sqlObj = new model();
        $time = date('Y-m-d',time());
        $t = strtotime($time);
        $t1 = $t-86400;
        $t2 = $t+86400;
        
        //昨日交易笔数
        $num = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND storeid='.$this->storeid;
        $number = $sqlObj->get_varBySql($num,'count');
        $sql = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND storeid='.$this->storeid;
        //昨日交易金额
        $money = $sqlObj->get_varBySql($sql,'num');
        if(!$money)$money=0;
        //今日
        $num2 = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND storeid='.$this->storeid;
        $number2 = $sqlObj->get_varBySql($num2,'count');
        $sql2 = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND storeid='.$this->storeid;
        $money2 = $sqlObj->get_varBySql($sql2,'num');
        if(!$money2)$money2=0;
        //公告
        $notice = M('cashier_notice')->select('1=1','*','10','id desc');
        if($this -> isMobile()){
            include $this->showTpl("indexwap");
        }
        else{
            include $this->showTpl();
        }
    }
    
    
    
    /**
     *  店长统计
     */
    
    public function ShopownerCount(){
        $getdata = $this->clear_html($_GET);
		$whereStr = 'ordr.ispay="1" AND ordr.storeid=' . $this->storeid;


        
		
		$wherecStr .= 'ispay="1" AND storeid=' . $this->storeid;
		if(!empty($getdata['start']) || !empty($getdata['end'])){
			$start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
			$end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
			$_SESSION['SHTimeStart']=$getdata['start'];
			$_SESSION['SHTimeEnd']=$getdata['end'];
		}elseif(!empty($_GET['page']) && (!empty($_SESSION['SHTimeStart']) || !empty($_SESSION['SHTimeEnd']))){
			$getdata['start']=$_SESSION['SHTimeStart'];
			$getdata['end']=$_SESSION['SHTimeEnd'];
			$start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
            $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
		}else{
			$start = strtotime(date('Y-m-d',  time()));
            $end = time();
			$getdata['start']=$_SESSION['SHTimeStart']=date("Y-m-d",$start);
			$getdata['end']=$_SESSION['SHTimeEnd']=date("Y-m-d",$end);
			$_SESSION['SHTimeStart']=date("Y-m-d",$start);
			$_SESSION['SHTimeEnd']=date("Y-m-d",$end);
		}

        if(!empty($getdata['type'])){
            $wherecStr .= " AND pay_way ='" . $getdata['type']."'";
            $whereStr .= " AND pay_way ='". $getdata['type']."'";
        }
        /*
        if (!empty($getdata['pay_way'])) {

            $strPayWay = ' AND pay_way="'.$getdata['pay_way'] .'" ';
			$_SESSION['SHType']=$getdata['pay_way'];
            $wherecStr .= $strPayWay;
            $whereStr .= $strPayWay;
        }elseif(!empty($_GET['page']) && !empty($_SESSION['SHType'])){
			$strPayWay = ' AND pay_way="'.$_SESSION['SHType'] .'" ';
			$getdata['pay_way']=$_SESSION['SHType'];
			$wherecStr .= $strPayWay;
            $whereStr .= $strPayWay;
		}else{
			$_SESSION['SHType']=null;
		}*/
		
		
        if (0 < $start) {
                $wherecStr .= ' AND paytime>=' . $start;
                $whereStr .= ' AND ordr.paytime>=' . $start;
        }
        if (0 < $end) {
                $end+=86400;
                $wherecStr .= ' AND paytime<' . $end;
                $whereStr .= ' AND ordr.paytime<' . $end;
        }
        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_order');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);



        //分页
        $_count = $orderDb->count($wherecStr);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        //查询数据
        $sqlStr = 'SELECT ordr.*,e.username FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_employee AS e ON ordr.eid=e.eid where '.$whereStr ;
        if (!empty($getdata['type'])) {
            $sqlStr .= " AND ordr.pay_way = '".$getdata['type']."'";
        }
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        //echo $sqlStr;exit;
        $sqlObj = new model();
        $neworder = $sqlObj->selectBySql($sqlStr);
        //统计
        //微信统计
        $sql1 = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order as ordr where '.$whereStr .' AND ordr.pay_way="weixin"';
        $weixin = $sqlObj->get_varBySql($sql1,'count');
        $income_sql = "SELECT SUM(`income`) as count FROM ".$tablepre.'cashier_order as ordr where '.$whereStr .' AND ordr.pay_way="weixin"';
        $weixin_income = $sqlObj->get_varBySql($income_sql,'count')?:0;
        if(!$weixin){$weixin = 0;}
        $sql2 = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order as ordr where '.$whereStr .' AND ordr.pay_way="alipay"';
        $alipay = $sqlObj->get_varBySql($sql2,'count');
        $income_sql2 = "SELECT SUM(`income`) as count FROM ".$tablepre.'cashier_order as ordr where '.$whereStr .' AND ordr.pay_way="alipay"';
        $alipay_income = $sqlObj->get_varBySql($income_sql2,'count')?:0;
        if(!$alipay){ $alipay = 0;}
        $sql3 = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order as ordr where '.$whereStr;
        $total = $sqlObj->get_varBySql($sql3,'count');
        $income_sql3 = "SELECT SUM(`income`) as count FROM ".$tablepre.'cashier_order as ordr where '.$whereStr;
        $total_income = $sqlObj->get_varBySql($income_sql3,'count');
        if(!$total){$total = 0;}
        if($this -> isMobile()){
            include $this->showTpl("ShopownerCountwap");
        }
        else{
            include $this->showTpl();
        }
    }
    
    
    /**
     * 收银员统计
     */
    
    public function CashierCount(){
        
        $getdata = $this->clear_html($_GET);
		$whereStr = 'ispay="1"';
		$wherecStr = 'ispay="1" AND storeid=' . $this->storeid;
        //搜索门店
        if($getdata['username']){
            $where = " AND username like '%".$getdata['username']."%'";
        }
        
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
        if(empty($start)){
            $start = strtotime(date("Y-m-d 00:00:00"));
            $whereStr .= ' AND paytime>=' . $start;
        }
        else{
            $whereStr .= ' AND paytime>=' . $start;
        }
        if(empty($end)){
            $end = strtotime(date("Y-m-d 23:59:59"));
            $whereStr .= ' AND paytime<' . $end;
        }
        else{
            $end+=86400;
            $whereStr .= ' AND paytime<' . $end;
        }
        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_employee');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);
        $sqlObj = new model();
        $_count = $orderDb->count("storeid= ". $this->storeid . " AND mid=".$this->mid.$where);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $sql = 'SELECT * FROM '.$tablepre.'cashier_employee WHERE level<>1 AND storeid='. $this->storeid.$where;
        $sql = $sql . ' ORDER BY eid DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        $store = $sqlObj->selectBySql($sql);
        //微信统计
        foreach($store as $k =>&$v){
            //微信统计
            $wxsumsql = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="weixin" AND eid='.$v['eid'];
            $v['wxtotal_price'] = $sqlObj->get_varBySql($wxsumsql,'count')?:0;
            
            
            $wxnumsql = "SELECT count(*) as num FROM ".$tablepre.'cashier_order where '.$whereStr.' AND pay_way="weixin" AND eid='.$v['eid'];
            $v['wxcount'] = $sqlObj->get_varBySql($wxnumsql,'num');
            
            $wxincomesql = "SELECT SUM(`income`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="weixin" AND  eid='.$v['eid'];
            $v['wxincome'] = $sqlObj->get_varBySql($wxincomesql,'count')?:0;
            
            //支付宝统计
            $alisumsql = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="alipay" AND  eid='.$v['eid'];
            $v['alitotal_price'] = $sqlObj->get_varBySql($alisumsql,'count')?:0;
            $alinumsql = "SELECT count(*) as num FROM ".$tablepre.'cashier_order where '.$whereStr.' AND pay_way="alipay" AND eid='.$v['eid'];
            $v['alicount'] = $sqlObj->get_varBySql($alinumsql,'num');
            $aliincomesql = "SELECT SUM(`income`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="alipay"  AND eid='.$v['eid'];
            $v['aliincome'] = $sqlObj->get_varBySql($aliincomesql,'count')?:0;
            //总金额.总笔数.实收金额
            $sum+=$v['wxtotal_price']+$v['alitotal_price'];
            $num+=$v['wxcount']+$v['alicount'];
            $income+=$v['wxincome']+ $v['aliincome'];
            unset($v);
        }
        if($this -> isMobile()){
            include $this->showTpl("CashierCountWap");
        }
        else{
            include $this->showTpl();
        }
    }
    
    /**
     * 员工统计详情
     */
	public function StaffCount(){
        $getdata = $this->clear_html($_GET);
        if($_GET['id']){
            $this->eismid($_GET['id']);
            $_SESSION['storeid'] = $_GET['id'];
        }
        
        
        $whereStr = 'ordr.ispay="1" AND ordr.eid='.$_SESSION['storeid'];
        $wherecStr = 'ispay="1" AND eid='.$_SESSION['storeid'];
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));

        if (empty($start)) {
            $start = strtotime(date("Y-m-d 00:00:00",time()));
        }
        $wherecStr .= ' AND paytime>=' . $start;
        $whereStr .= ' AND ordr.paytime>=' . $start;
        if (empty($end)) {
            $end = strtotime(date("Y-m-d 23:59:59",time()));
        }
        else{
            $end+=86400;
        }
        $wherecStr .= ' AND paytime<' . $end;
        $whereStr .= ' AND ordr.paytime<' . $end;
        if (!empty($getdata['pay_way'])) {
        
            $whereStr .= ' AND pay_way="'.$getdata['pay_way'] .'" ';
           
        }
        
        
        
        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_order');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);
        
         
        $_count = $orderDb->count($wherecStr);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $sqlStr = 'SELECT ordr.*,e.username FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_employee AS e ON ordr.eid=e.eid where '.$whereStr ;
        if (!empty($getdata['type'])) {
            $sqlStr .= " AND ordr.pay_way = '".$getdata['type']."'";
        }
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
        $sqlObj = new model();
        $neworder = $sqlObj->selectBySql($sqlStr);
        //统计
        //微信统计
        $sql1 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM ".$tablepre.'cashier_order as ordr where '.$whereStr .' AND ordr.pay_way="weixin"';
        $weixin = $sqlObj->selectBySql($sql1);
        $weixin[0]['count']?$weixin['count']=$weixin[0]['count']:$weixin['count']=0;
        $weixin[0]['income']?$weixin['income']=$weixin[0]['income']:$weixin['income']=0;
        $sql2 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM ".$tablepre.'cashier_order as ordr where '.$whereStr .' AND ordr.pay_way="alipay"';
        $alipay = $sqlObj->selectBySql($sql2);
        $alipay[0]['count']?$alipay['count']=$alipay[0]['count']:$alipay['count']=0;
        $alipay[0]['income']?$alipay['income']=$alipay[0]['income']:$alipay['income']=0;
        
        $sql3 = "SELECT SUM(`goods_price`) as count,SUM(`income`) as income FROM ".$tablepre.'cashier_order as ordr where '.$whereStr;
        $total = $sqlObj->selectBySql($sql3);
        
        $total[0]['count']?$total['count']=$total[0]['count']:$total['count']=0;
        $total[0]['income']?$total['income']=$total[0]['income']:$total['income']=0;
        $neworder = $this->ProcssOdata($neworder, $this->mid);

        if($this -> isMobile()){
            $stor = M("cashier_employee") -> get_one("eid=".$_SESSION['storeid'],"*");
            $storname = $stor['username'];
            include $this->showTpl("StaffCountWap");
        }
        else{
            include $this->showTpl();
        }
	}
	
	
	
	/**
	 * 收银员列表
	 */
	public function StaffManagement(){
	    $getdata = $this->clear_html($_POST);
	    if($getdata['username']){
	        $where = " AND username like '%".$getdata['username']."%'";
	    }
	    $employee = M('cashier_employee')->select('storeid='.$this->storeid.' AND level<>1'.$where,'eid,username,phone');
	    include $this->showTpl();
	}
	
	
	/**
	 * 添加店员
	 */
	
	public function ClerkAdd(){
        if(IS_POST){
            //数据验证
            $data = $this->clear_html($_POST);
            $pwd = $data['password'];
            $password = trim($data['password']);
            $password1 = trim($data['password1']);
            if (empty($password)) {
                $this->errorTip('密码不能为空！');
                exit();
            }
            if ($password != $password1) {
                $this->errorTip('两次输入的密码不一致！');
                exit();
            }
            if(empty($data['username'])){
                $this->errorTip('昵称不能为空!');
                exit();
            }
            
            
            if(empty($data['phone'])){
                $this->errorTip('手机号码不能为空!');
                exit();
            }
            
            if (!preg_match("/^1[34578]\d{9}$/", $data['phone'])) {
                $this->errorTip('手机号码格式不正确！', $_SERVER['HTTP_REFERER']);
                exit;
            }
            
            
            if(empty($data['account'])){
                $this->errorTip('用户名不能为空！');
                exit();
            }
            $employee_account = M('cashier_employee')->get_one(array('account'=>$data['account']));
            if($employee_account){
                $this->errorTip('用户名已被注册！');
                exit();
            }
            if($data['jurisdiction']){
                if(empty($data['qrcodeid'])){
                    $this->errorTip('收款二维码不能为空！');
                    exit();
                }else{
                    //查询二维码是否有效
                    $qrcode = M('cashier_qrcode')->get_one(array('qrcode_id'=>$data['qrcodeid']));
                    if(!$qrcode){
                        $this->errorTip('请输入有效的收款二维码ID!');
                        exit();
                    }
                    //判断收款二维码是否被绑定
                    if(!empty($qrcode['mid']) && !empty($qrcode['storesid']) && !empty($qrcode['eid']) && ($qrcode['status'] == '1')){
                        $this->errorTip('该收款二维码已被绑定!');
                        exit();
                    }
                    //拼装绑定二维码数据
                    $bindingcode['mid'] = $this->employer['mid'];
                    $bindingcode['storesid'] = $this->employer['storeid'];
                    $bindingcode['status'] = 1;
                }
            }
            $salt = mt_rand(111111,999999);
            $newpwdstr = $this->toPassword($password, $salt);
            $employee_data['mid'] = $this->employer['mid'];
            $employee_data['username'] = $data['username'];
            $employee_data['account'] = $data['account'];
            $employee_data['password'] = $newpwdstr;
            $employee_data['salt'] = $salt;
            $employee_data['phone'] = $data['phone'];
            $employee_data['storeid'] = $this->employer['storeid'];
            if($data['jurisdiction']){
                $employee_data['is_receivables'] = 1;
            }
            $id = M('cashier_employee')->insert($employee_data,true);
            if($id){
                if($bindingcode){
                    $bindingcode['eid'] = $id;
                    $code_update = M('cashier_qrcode')->update($bindingcode,array('qrcode_id'=>$data['qrcodeid']));
                    if(!$code_update){
                        $this->errorTip('支付二维码绑定失败!');
                        exit();
                    }
                }
                $url = $this->SiteUrl.'/index.php';
                bpBase::loadOrg('Email');
                $email = new Email();
                $subject = "重庆云极付有限公司平台商户员工注册成功通知";//设置邮箱标题
                $address = $data['account'];//需要发送的邮箱地址
                $content = <<<ETC
                 <div style="width: 80%; background: #FFFFFF;">
        			<h1 style="font-weight: normal; text-align: center; width: 100%; border-bottom: 1px solid #F3F3F3;">欢迎注册云极付商户平台</h1>
        			<div style="padding: 0 30px;">账号注册成功<a style="text-decoration: none; margin-left:150px; display: inline-block; width: 80px; height: 30px; background: #007AFF; color: #FFFFFF; border-radius: 5px; text-align: center; line-height: 30px; margin-top: 10px;" href=" $url ">立即登录</a></div>
        			<p style="padding: 0 30px;">我们已向你的邮箱 $address 发送邮件,登录密码: $pwd </p>
        		</div>
ETC;
                $res = $email->send_email($address,$subject,$content);
                $this->successTip('添加成功');
            }else{
                $this->errorTip('添加员工失败!');
                exit();
            }
        }
        
	    include $this->showTpl();
	}
	
	
	/**
	 * 修改员工性息
	 */
	public function ClerkUpdate(){
	    if(IS_POST){
	        $datas = $this->clear_html($_POST);
	           
	        if(empty($datas['username'])){
	            $this->errorTip('昵称不能为空!');
	            exit();
	        }
	        if(empty($datas['phone'])){
	            $this->errorTip('手机号码不能为空!');
	            exit();
	        }
	        
	        if (!preg_match("/^1[34578]\d{9}$/", $datas['phone'])) {
	            $this->errorTip('手机号码格式不正确！', $_SERVER['HTTP_REFERER']);
	            exit;
	        }
	        
	        //验证用户是否修改密码
	        if($datas['ispwd']){
	            if($datas['password'] && $datas['password1']){
	                if($datas['password'] != $datas['password1']){
	                    $this->errorTip('两次密码输入不一致！');
	                    exit();
	                }
	                //生成密码
	                $salt = mt_rand(111111,999999);
	                $newpwdstr = $this->toPassword($datas['password'],$salt);
	            }else{
	                $this->errorTip('密码不能为空！');
	                exit();
	            }
	        }
	        //入库
	        if($newpwdstr){ 
	            $employee_data['password'] = $newpwdstr;
	            $employee_data['salt'] = $salt;
	        }
	        $employee_data['username'] = $datas['username'];
	        $employee_data['phone'] = $datas['phone'];
	        
	        $update =M('cashier_employee')->update($employee_data,array('eid'=>$datas['id']));
	        if($update){
	            $this->successTip('编辑员工成功');
	        }else{
	            $this->errorTip('编辑员工失败！');
	            exit();
	        }
	    }else{
	        $data = $this->clear_html($_GET);
	        $this->eismid($data['id']);
	        //查询员工信息
	        $employee = M('cashier_employee')->get_one(array('eid'=>$data['id']));
	        //查询绑定支付二维码ID
	        $qrcode = M('cashier_qrcode')->get_one(array('eid'=>$employee['eid']),'qrcode_id');
	        include $this->showTpl();
	    }
	}
	
	/**
	 * 店长统计导出excel
	 */
	
	public function exportExcelwner(){
	    if(IS_POST){
	        $db_config = loadConfig('db');
	        $tablepre = $db_config['default']['tablepre'];
			if(!empty($_SESSION['SHTimeStart']) || !empty($_SESSION['SHTimeEnd'])){
                $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
                $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
				if (0 < $start) {
					$whereStr .= ' AND ordr.paytime>=' . $start;
				}
				if (0 < $end) {
					if($_SESSION['SHTimeEnd']){
						$end+=86400;
					}
					$whereStr .= ' AND ordr.paytime<' . $end;
				}
            }else{
                $whereStr='';
            }
			if(!empty($_SESSION['SHType'])){
				$whereStr .= " AND pay_way='". $_SESSION['SHType']."'";
			}else{
				$whereStr .= "";
			}
	        //查询条件
	        $whereStr = ' ordr.ispay="1" AND ordr.storeid=' . $this->storeid .$whereStr;
			
	        //拼装sql
	        $sqlStr = 'SELECT ordr.*,s.* FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_stores AS s ON ordr.storeid=s.id where '.$whereStr ;
	        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC';
	        $sqlObj = new model();
	        $neworder = $sqlObj->selectBySql($sqlStr);
	        //拼装导出excel数据
	        $data = array();
	        foreach ($neworder as $key => $val){
	            $data[$key]['id']           = $val['id'];//id
	            $data[$key]['order_id']     = '订单号：'.$val['order_id'];//交易单号
	            $data[$key]['goods_price']  = $val['goods_price'];//应收金额
	            //退款金额
	            if($val['refund'] == '2'){
	                $data[$key]['refund'] = $val['goods_price'];
	            }else{
	                $data[$key]['refund'] = '0.00';
	            }
	            //实收金额
	            if($val['refund'] == '2'){
	                $data[$key]['receipts'] = '0.00';
	            }else{
	                $data[$key]['receipts'] = $val['goods_price'];
	              
	            }
	            $data[$key]['paytime']      = date('Y-m-d H:i:s',$val['paytime']);//交易时间
	            //交易类型
	            if($val['pay_way'] == 'weixin'){
	                $data[$key]['pay_way'] = '微信支付';
	            }else if($val['pay_way'] == 'alipay'){
	                $data[$key]['pay_way'] = '支付宝城市';
	            }
	            $data[$key]['goods_describe']  = $val['goods_describe'];//付款方式
	            $data[$key]['branch_name']     = $val['branch_name'];//门店
	            if($val['refund'] == '2'){
	                $data[$key]['type'] = '已退款';
	            }else{
	                $data[$key]['type'] = '正常订单';
	            }
	        } 
	        $title = array('序号','交易单号','应收金额','退款金额','实收金额','交易时间','交易类型','付款方式','门店','退款状态');
	        $filename = '店长:【'.$this->employer['username'].'】下的所有交易订单.xls';
	        $this->ExportTable($data,$title,$filename);
	    }
	    
	}
	
	
	/**
	 * 收银员统计导出execl
	 */
	public function CashierCountExecl(){
	    if(IS_POST){
	        $sqlObj = new model();
	        $whereStr = 'ispay="1"';
	        $wherecStr = 'ispay="1" AND storeid=' . $this->storeid;
	        $orderDb = M('cashier_stores');
	        $db_config = loadConfig('db');
	        $tablepre = $db_config['default']['tablepre'];
	        $sql = 'SELECT * FROM '.$tablepre.'cashier_employee WHERE level<>1 AND storeid='. $this->storeid.$where;
	        $sql = $sql . ' ORDER BY eid DESC';
	        $store = $sqlObj->selectBySql($sql);
	        //微信统计
	        $i = 0;
	        foreach($store as $k =>&$v){
	            //微信统计
	            $data[$i]['username'] = $v['username'];
	            $data[$i]['pay'] = '微信支付';
	            $wxsumsql = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="weixin" AND eid='.$v['eid'];
	            $data[$i]['total_price'] = $sqlObj->get_varBySql($wxsumsql,'count')?:0;
	            $wxnumsql = "SELECT count(*) as num FROM ".$tablepre.'cashier_order where '.$whereStr.' AND pay_way="weixin" AND eid='.$v['eid'];
	            $data[$i]['count'] = $sqlObj->get_varBySql($wxnumsql,'num');
	            
	            //支付宝统计
	            $i++;
	            $data[$i]['username'] = $v['username'];
	            $data[$i]['pay'] = '支付宝城市';
	            $alisumsql = "SELECT SUM(`goods_price`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="alipay" AND  eid='.$v['eid'];
	            $data[$i]['total_price'] = $sqlObj->get_varBySql($alisumsql,'count')?:0;
	            $aliincomesql = "SELECT SUM(`income`) as count FROM ".$tablepre.'cashier_order  where '.$whereStr .' AND pay_way="alipay"  AND eid='.$v['eid'];
	            $data[$i]['count'] = $sqlObj->get_varBySql($aliincomesql,'count')?:0;
	            $i++;
	       }
	       $title = array('收银员名称','支付方式','支付金额','交易笔数');
	       $filename = '店长:【'.$this->employer['username'].'】下的所有收银员订单统计.xls';
	       $this->ExportTable($data,$title,$filename);
	   }  
	
    }
    
    
    /**
     * 店员统计订单详情导出excel
     */
    public function StaffCountExcel(){
        if(IS_POST){
            $db_config = loadConfig('db');
            $tablepre = $db_config['default']['tablepre'];
            //查询条件
            $whereStr = 'ordr.ispay="1" AND  ordr.storeid=' .$this->storeid .' AND eid='.$_POST['eid'];
            //拼装sql
            $sqlStr = 'SELECT ordr.*,s.branch_name FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_stores AS s ON ordr.storeid=s.id where '.$whereStr ;
            $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC';
            $sqlObj = new model();
            $neworder = $sqlObj->selectBySql($sqlStr);
          
            //拼装导出excel数据
            $data = array();
            foreach ($neworder as $key => $val){
                $data[$key]['id']           = $val['id'];//id
                $data[$key]['order_id']     = '订单号：'.$val['order_id'];//交易单号
                $data[$key]['goods_price']  = $val['goods_price'];//应收金额
                //退款金额
                if($val['refund'] == '2'){
                    $data[$key]['refund'] = $val['goods_price'];
                }else{
                    $data[$key]['refund'] = '0.00';
                }
                //实收金额
                if($val['refund'] == '2'){
                    $data[$key]['receipts'] = '0.00';
                }else{
                    $data[$key]['receipts'] = $val['income'];
                     
                }
                $data[$key]['paytime']      = date('Y-m-d H:i:s',$val['paytime']);//交易时间
                //交易类型
                if($val['pay_way'] == 'weixin'){
                    $data[$key]['pay_way'] = '微信支付';
                }else if($val['pay_way'] == 'alipay'){
                    $data[$key]['pay_way'] = '支付宝城市';
                }
                $data[$key]['goods_describe']  = $val['goods_describe'];//付款方式
                $data[$key]['branch_name']     = $val['branch_name'];//门店
                if($val['refund'] == '2'){
                    $data[$key]['type'] = '已退款';
                }else{
                    $data[$key]['type'] = '正常订单';
                }
            }
            $employee = M('cashier_employee')->get_one(array('eid'=>$_POST['eid']),'username');
            $title = array('序号','交易单号','应收金额','退款金额','实收金额','交易时间','交易类型','付款方式','门店','退款状态');
            $filename = '收银员:【'.$employee['username'].'】下的所有交易订单.xls';
            $this->ExportTable($data,$title,$filename);
        }
    }
    
    
    
    /**
     * 首页公告详情
     */
    
    public function notice(){
        $row = M('cashier_notice')->get_one(array('id'=>$_GET['id']));
        
        include $this->showTpl();
    }


    //判断是否为手机
    function isMobile()
    {
        // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
        if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        {
            return true;
        }
        // 如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
        if (isset ($_SERVER['HTTP_VIA']))
        {
            // 找不到为flase,否则为true
            return stristr($_SERVER['HTTP_VIA'], "wap") ? true : false;
        }
        // 脑残法，判断手机发送的客户端标志,兼容性有待提高
        if (isset ($_SERVER['HTTP_USER_AGENT']))
        {
            $clientkeywords = array ('nokia',
                'sony',
                'ericsson',
                'mot',
                'samsung',
                'htc',
                'sgh',
                'lg',
                'sharp',
                'sie-',
                'philips',
                'panasonic',
                'alcatel',
                'lenovo',
                'iphone',
                'ipod',
                'blackberry',
                'meizu',
                'android',
                'netfront',
                'symbian',
                'ucweb',
                'windowsce',
                'palm',
                'operamini',
                'operamobi',
                'openwave',
                'nexusone',
                'cldc',
                'midp',
                'wap',
                'mobile'
            );
            // 从HTTP_USER_AGENT中查找手机浏览器的关键字
            if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT'])))
            {
                return true;
            }
        }
        // 协议法，因为有可能不准确，放到最后判断
        if (isset ($_SERVER['HTTP_ACCEPT']))
        {
            // 如果只支持wml并且不支持html那一定是移动设备
            // 如果支持wml和html但是wml在html之前则是移动设备
            if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') !== false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html'))))
            {
                return true;
            }
        }
        return false;
    }
}

?>
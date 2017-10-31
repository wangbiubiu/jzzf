 
<?php
bpBase::loadAppClass('common', 'User', 0);
/**
 * 
 * @author 收银员
 *
 */
class staff_controller extends common_controller
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
        $num = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where ispay='1' AND refund='0' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND eid='.$this->eid;
        
        $number = $sqlObj->get_varBySql($num,'count');
        $sql = "SELECT SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND refund='0' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND eid='.$this->eid;
        //昨日交易金额
        
        $money = $sqlObj->get_varBySql($sql,'num');
        
        if(!$money)$money=0;
        //今日
        $num2 = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where ispay='1' AND refund='0' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND eid='.$this->eid;
        $number2 = $sqlObj->get_varBySql($num2,'count');
        $sql2 = "SELECT SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND refund='0' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND eid='.$this->eid;
        $money2 = $sqlObj->get_varBySql($sql2,'num');
        if(!$money2)$money2=0;
        $notice = M('cashier_notice')->select('1=1','*','10','id desc');
        if($this -> isMobile()){
            include $this->showTpl("indexwap");
        }
        else{
            include $this->showTpl();
        }
    }
    
    // 我的流水
    public function myOrders () {
        $getdata = $this->clear_html($_GET);
        $whereStr = 'ordr.ispay="1" AND ordr.eid=' . $this->eid;
        $wherecStr = 'ispay="1" AND eid=' . $this->eid;
        if(!empty($getdata['type'])){
            $whereStr .= " AND pay_way = '".$getdata['type']."'";
            $wherecStr .= " AND pay_way = '".$getdata['type']."'";
        }
        /*if (!empty($getdata['pay_way'])) {
			$_SESSION['SHType']=$getdata['pay_way'];
            $strPayWay = ' AND pay_way="'.$getdata['pay_way'] .'" ';
            $wherecStr .= $strPayWay;
            $whereStr .= $strPayWay;
        }elseif(!empty($_GET['page']) && !empty($_SESSION['SHType'])){
			 $strPayWay = ' AND pay_way="'.$_SESSION['SHType'] .'" ';
			 $wherecStr .= $strPayWay;
            $whereStr .= $strPayWay;
			$getdata['pay_way']=$_SESSION['SHType'];
		}else{
			$wherepay = "";
            $_SESSION['SHType']=null;
		}*/


        if(!empty($getdata['start'])) {
            $start = strtotime($getdata['start']."00:00:00");
        }
        else{
            $start = strtotime(date("Y-m-d 00:00:00"));
        }
        if(!empty($getdata['end'])) {
            $end = strtotime($getdata['end']." 23:59:59");
        }
        else{
            $end = strtotime(date("Y-m-d 23:59:59"));
        }

        $wherecStr .= ' AND paytime>=' . $start;
        $whereStr .= ' AND ordr.paytime>=' . $start;
        $wherecStr .= ' AND paytime<' . $end;
        $whereStr .= ' AND ordr.paytime<' . $end;
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
        $sqlStr = 'SELECT ordr.*,e.branch_name FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_stores AS e ON ordr.storeid=e.id where '.$whereStr ;  
        if(!empty($getdata['type'])){
            $sqlStr .= " AND pay_way = '".$getdata['type']."'";
        }
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;


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
            include $this->showTpl("myOrdersWap");
        }
        else{
            include $this->showTpl();
        }
    }

    // 设置
    public function setMyself() {


        if (!empty($_GET)) {
            $getdata = $this->clear_html($_GET);
        }

        if($this -> isMobile()){
            include $this->showTpl("setMyselfWap");
        }
        else{
            include $this->showTpl();
        }

    }
    
        /**
     * 用户修改密码
     * 
     */
    
    public function doModifyPwd()
    {
        $password = trim($_POST['password']);
        $repassword = trim($_POST['repassword']);
  
        if (empty($password)) {
            $this->errorTip('新密码不能为空！');
            exit();
        }
    
    
        if ($password != $repassword) {
            $this->errorTip('两次输入的密码不一致！');
            exit();
        }
    
        $newpwdstr = $this->toPassword($password, $this->merchant['salt']);
        $updatedata = array('password' => $newpwdstr, 'mfypwd' => 1);
    
    
        $flage = M('cashier_merchants')->update($updatedata, array('mid' => $this->merchant['mid']));
    
        if ($flage) {
            $this->successTip('修改成功，请重新登录！', '/merchants.php?m=User&c=index&a=logout');
            exit();
        }
        else {
            $this->errorTip('密码修改失败！');
            exit();
        }
    }
    
    
    
    
    
    /**
     * 账户设置
     */
    public function ModifyPwd()
    {
            if(IS_POST){
                $data = $this->clear_html($_POST);
                if($data['company']==""){
                    $this->errorTip('商户名不能为空',$_SERVER['HTTP_REFERER']);
                }
                if($data['realname']==""){
                    $this->errorTip('联系人不能为空',$_SERVER['HTTP_REFERER']);
                }
                if($data['phone']==""){
                    $this->errorTip('电话不能为空',$_SERVER['HTTP_REFERER']);
                }
                if($data['address']==""){
                    $this->errorTip('地址不能为空',$_SERVER['HTTP_REFERER']);
                }
                $result = M('cashier_merchants')->update($data,'mid='.$this->mid);
                if($result){
                    $this->dexit(array('code'=>1));
                }else{
                    $this->dexit(array('code'=>0));
                }
                
            }else{
                 //查询数据
                $merchants = M('cashier_merchants')->get_one(array('mid'=>$this->merchant['mid']));
        include $this->showTpl();
            }
       
    }
    //支付
    public function payment () {

        $mid = M('cashier_employee')->get_var(array('eid'=>$this->eid),'mid');
        $wx_user = M('cashier_payconfig')->getwxuserConf($mid);
        bpBase::loadOrg('wxCardPack');
        $wxCardPack = new wxCardPack($wx_user,  $mid);
        $cashier_payconfig = M('cashier_payconfig')->get_one(array('mid'=>$mid),'*');
        	
        $cashier_merchants = M('cashier_merchants')->get_one(array('mid'=>$mid),'mtype');
        
       /*  if(!($cashier_merchants['mtype'] == '1' && $cashier_payconfig['pfpaymid'] == '1')){
            $this->errorTip('当前商户未配置支付信息！！', $_SERVER['HTTP_REFERER']);
            exit;
        } */
 
        $access_token = $wxCardPack->getToken();
        $signdata = $wxCardPack->getSgin($access_token);
        $type = ((isset($_GET['type']) ? intval($_GET['type']) : 1));
        $type = (($type == 2 ? $type : 1));
        include $this->showTpl();
    }


    public function orderLists()
    {
               
        $getdata = $this->clear_html($_GET);
        $cfr = ((isset($getdata['cfr']) ? intval($getdata['cfr']) : 0));
        $whereStr = 'ordr.ispay="1"';
        $wherecStr = 'ispay="1" AND mid=' . $this->mid;

        switch ($cfr) {
        case 1:
            $wherecStr .= ' AND comefrom in(0,4)';
            $whereStr .= ' AND ordr.comefrom in(0,4)';
            break;

        case 2:
            $wherecStr .= ' AND comefrom ="0"';
            $whereStr .= ' AND ordr.comefrom ="0"';
            break;

        case 3:
            $wherecStr .= ' AND comefrom =4';
            $whereStr .= ' AND ordr.comefrom =4';
            break;

        case 4:
            $wherecStr .= ' AND comefrom in(1,2,3)';
            $whereStr .= ' AND ordr.comefrom in(1,2,3)';
            break;
                    default :
            
            $pty = ((isset($getdata['pty']) ? $getdata['pty'] : ''));
            if (($pty == 'weixin') || ($pty == 'alipay')) {
                $wherecStr .= ' AND pay_way="' . $pty . '"';
                $whereStr .= ' AND ordr.pay_way="' . $pty . '"';
            }


            $sid = ((isset($getdata['sid']) ? intval($getdata['sid']) : 0));

            if ((0 < $sid) && !0 < $this->storeid) {
                $wherecStr .= ' AND storeid=' . $sid;
                $whereStr .= ' AND ordr.storeid=' . $sid;
            }


            $eid = ((isset($getdata['eid']) ? intval($getdata['eid']) : 0));

            if (0 < $eid) {
                $wherecStr .= ' AND eid=' . $eid;
                $whereStr .= ' AND ordr.eid=' . $eid;
            }


            $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
            $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));

            if (0 < $start) {
                $wherecStr .= ' AND paytime>=' . $start;
                $whereStr .= ' AND ordr.paytime>=' . $start;
            }


            if (0 < $end) {
                $wherecStr .= ' AND paytime<=' . $end;
                $whereStr .= ' AND ordr.paytime<=' . $end;
            }


            bpBase::loadOrg('common_page');
            $orderDb = M('cashier_order');
            $db_config = loadConfig('db');
            $tablepre = $db_config['default']['tablepre'];
            unset($db_config);

            if (0 < $this->storeid) {
                $wherecStr .= ' AND storeid=' . $this->storeid;
            }
                        

            $_count = $orderDb->count($wherecStr);
            $p = new Page($_count, 20);
            $pagebar = $p->show(2);
            //$sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid;
            $sqlStr = 'SELECT DISTINCT ordr.id,ordr.*,cf.nickname,s.branch_name FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_fans AS cf ON ordr.openid=cf.openid   LEFT JOIN '.$tablepre.'cashier_stores  AS s ON ordr.storeid=s.id  where ordr.mid=' . $this->mid . '  AND cf.mid=' . $this->mid;
                        
                        
                        
            if (0 < $this->storeid) {
                $sqlStr = $sqlStr . ' AND ordr.storeid=' . $this->storeid;
            }

            
            $sqlStr = $sqlStr . ' AND ' . $whereStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
            //$sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
            $sqlObj = new model();
            $neworder = $sqlObj->selectBySql($sqlStr);
            $neworder = $this->ProcssOdata($neworder, $this->mid);
           
            if (0 < $this->storeid) {
                $allStore = $this->getStoreByid($this->storeid, $this->mid);
            }
             else {
                $allStore = $this->getAllStore($this->mid);
            }

            $allEmployee = $this->getAllEmployee($this->mid, false, $this->storeid);
                        break;
        }
                include $this->showTpl();
    }

    // 卡券核销 
    /*     * ******核销卡券页面******** */

    public function consumeCard() {
        $mid = M('cashier_employee')->get_var(array('eid'=>$this->eid),'mid');
        $wx_user = M('cashier_payconfig')->getwxuserConf($mid);
        bpBase::loadOrg('wxCardPack');
         $wxCardPack = new wxCardPack($wx_user,  $mid);
        if (IS_POST) {
            $vcode = trim($_POST['auth_code']);
            if (!empty($vcode)) {
                $vcode = str_replace('-', '', $vcode);
                $wxcoupon_receiveDb = M('cashier_wxcoupon_receive');
                $receiveinfo = $wxcoupon_receiveDb->get_one(array('cardcode' => $vcode, 'outerid' => $this->mid, 'consumesource' => 'LOCAL'), '*');
                $wxcouponDb = M('cashier_wxcoupon');
                if (!empty($receiveinfo) && strpos($receiveinfo['cardid'], 'ocalCardid_')) {
                    $tempcardid = explode('_', $receiveinfo['cardid']);
                    $wxcouponID = $tempcardid['1'];
                    if ($this->storeid > 0) {
                        $tmpstore = M('cashier_stores')->get_one(array('mid' => $this->mid, 'id' => $this->storeid), 'id,mid,poi_id,business_name,branch_name,address');
                        if (!empty($tmpstore)) {
                            $db_config = loadConfig('db');
                            $tablepre = $db_config['default']['tablepre'];
                            $sqlStr = 'SELECT id,mid,poi_ids,card_type FROM ' . $tablepre . 'cashier_wxcoupon where id=' . $wxcouponID . ' AND mid=' . $this->mid . ' AND (poi_ids like "%' . $tmpstore['poi_id'] . '%"  OR  store_ids like "%' . $this->storeid . '%")';
                            $sqlObj = new model();
                            $tmps = $sqlObj->selectBySql($sqlStr);
                            if (empty($tmps)) {
                                $this->dexit(array('error' => 1, 'msg' => '此卡券不属于你的门店，你没权限核销'));
                                exit();
                            }
                        }
                    }
                    $updateData = array('status' => 1, 'outerid' => $this->mid, 'consumetime' => time());
                    if ($this->storeid > 0) {
                        $updateData['storeid'] = $this->storeid;
                        $updateData['eid'] = $this->eid;
                    }
                    $wxcoupon_receiveDb->update($updateData, array('id' => $receiveinfo['id'], 'cardcode' => $vcode));
                    $wxcouponTmp = $wxcouponDb->get_one(array('id' => $wxcouponID, 'mid' => $this->mid, 'card_id' => 'localCard_id'), '*');
                    $consumenum = $wxcouponTmp['consumenum'] + 1;
                    $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wxcouponTmp['id']));
                    $this->dexit(array('error' => 0, 'msg' => '核销成功！'));
                    exit();
                }
                unset($receiveinfo);
                $rets = $this->wxCardPack->wxCardQueryCode($this->access_token, '{"code":"' . $vcode . '"}');
                if (isset($rets['card'])) {

                    $card_id = trim($rets['card']['card_id']);
                    $begin_time = trim($rets['card']['begin_time']);
                    $end_time = trim($rets['card']['end_time']);
                    $receiveinfo = $wxcoupon_receiveDb->get_one(array('openid' => $rets['openid'], 'cardcode' => $vcode, 'cardid' => $card_id), '*');
                    if ($this->storeid > 0) {
                        $tmpstore = M('cashier_stores')->get_one(array('mid' => $this->mid, 'id' => $this->storeid), 'id,mid,poi_id,business_name,branch_name,address');
                        if ($tmpstore && $tmpstore['poi_id']) {
                            $db_config = loadConfig('db');
                            $tablepre = $db_config['default']['tablepre'];
                            $sqlStr = 'SELECT id,mid,poi_ids,card_type FROM ' . $tablepre . 'cashier_wxcoupon where mid=' . $this->mid . ' AND poi_ids like "%' . $tmpstore['poi_id'] . '%" AND card_id="' . $card_id . '"';
                            $sqlObj = new model();
                            $tmps = $sqlObj->selectBySql($sqlStr);
                            if (empty($tmps)) {
                                $this->dexit(array('error' => 1, 'msg' => '此卡券不属于你的门店，你没权限核销'));
                                exit();
                            }
                        }
                    }
                    if (($rets['can_consume'] == 1) && ($receiveinfo['status'] == 0) && ($receiveinfo['isdel'] == 0)) {
                        $vrets = $this->wxCardPack->wxCardConsume($this->access_token, '{"code":"' . $vcode . '","card_id":"' . $card_id . '"}');
                        if (!empty($vrets) && isset($vrets['card']) && ($vrets['errcode'] == 0)) {
                            $updateData = array('status' => 1, 'outerid' => $this->mid, 'consumetime' => time());
                            if ($this->storeid > 0) {
                                $updateData['storeid'] = $this->storeid;
                                $updateData['eid'] = $this->eid;
                            }
                            $wxcoupon_receiveDb->update($updateData, array('id' => $receiveinfo['id'], 'cardcode' => $vcode));
                            $wxcouponTmp = $wxcouponDb->get_one(array('card_id' => $card_id, 'mid' => $this->mid), '*');
                            $consumenum = $wxcouponTmp['consumenum'] + 1;
                            $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wxcouponTmp['id']));
                            $this->dexit(array('error' => 0, 'msg' => '核销成功！'));
                        } elseif (isset($vrets['errmsg'])) {
                            $this->dexit(array('error' => 1, 'msg' => $vrets['errcode'] . '：' . $vrets['errmsg']));
                        }
                    } else {
                        $this->dexit(array('error' => 1, 'msg' => '此核销码不可以再核销！'));
                    }
                } elseif ($rets['errcode'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $rets['errcode'] . '：' . $rets['errmsg']));
                }
            }
        } else {
            $signdata = $wxCardPack->getSgin($this->access_token);
            include $this->showTpl();
        }
    }

    /**
     *  店长统计
     */

    public function ShopownerCount(){
        $getdata = $this->clear_html($_POST);
		$whereStr = 'ordr.ispay="1" AND ordr.eid=' . $this->eid;
		
		$wherecStr = 'ispay="1" AND eid=' . $this->eid;
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
        
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
        $sqlStr = 'SELECT ordr.*,s.branch_name FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_stores AS s ON ordr.eid=s.id where '.$whereStr ;           
        $sqlStr = $sqlStr . ' ORDER BY ordr.paytime DESC,ordr.id DESC LIMIT ' . $p->firstRow . ',' . $p->listRows;
       
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
        include $this->showTpl();
    }
    
    
    /**
     * 收银员统计
     */
    
    public function CashierCount(){
        $getdata = $this->clear_html($_POST);
		$whereStr = 'ispay="1"';
		$wherecStr = 'ispay="1" AND eid=' . $this->eid;
        //搜索门店
        if($getdata['username']){
            $where = " AND username like '%".$getdata['username']."%'";
        }
        
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
        
        if (0 < $start) {
                $whereStr .= ' AND paytime>=' . $start;
        }
        
        
        if (0 < $end) {
                $end+=86400;
                $whereStr .= ' AND paytime<' . $end;  
        }
        bpBase::loadOrg('common_page');
        $orderDb = M('cashier_stores');
        $db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
        unset($db_config);
        $sqlObj = new model();
        $_count = $orderDb->count("isshow='1' AND mid=".$this->mid.$where);
        $p = new Page($_count, 10);
        $pagebar = $p->show(2);
        $sql = 'SELECT * FROM '.$tablepre.'cashier_employee WHERE level<>1 AND eid='. $this->eid.$where;
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
        
		include $this->showTpl();
    }

    public function data2Excel() {
		$db_config = loadConfig('db');
        $tablepre = $db_config['default']['tablepre'];
		if(!empty($_SESSION['SHTimeStart']) || !empty($_SESSION['SHTimeEnd'])){
             $start = ((isset($_SESSION['SHTimeStart']) ? strtotime($_SESSION['SHTimeStart']) : 0));
             $end = ((isset($_SESSION['SHTimeEnd']) ? strtotime($_SESSION['SHTimeEnd']) : 0));
			if (0 < $start) {
				$whereStr .= ' AND paytime>=' . $start;
			}
			if (0 < $end) {
				if($_SESSION['SHTimeEnd']){
					$end+=86400;
				}
				$whereStr .= ' AND paytime<' . $end;
			}
         }else{
             $whereStr='';
         }
		 
		 if(!empty($_SESSION['SHType'])){
            $whereStr .= " AND pay_way='". $_SESSION['SHType']."'";
         }else{
            $whereStr .= "";
        }
		 
        //$orders = M('cashier_order')->get_all('id,paytime,goods_price,pay_way,goods_describe,income,eid,order_id,storeid','',array('ispay'=>1,'eid'=>$this->eid));
		$sql="SELECT id,paytime,goods_price,pay_way,goods_describe,income,eid,order_id,storeid FROM {$tablepre}cashier_order WHERE ispay=1 and eid={$this->eid}".$whereStr;
		$sqlObj = new model(); 
		$orders=$sqlObj->selectBySql($sql);
		
		$data = array();
        foreach ($orders as $k => $v) {
            $data[$k]['order_id'] = '订单号'.$v['order_id'];
            $data[$k]['goods_price'] = $v['goods_price'];
            $data[$k]['income'] = $v['goods_price'];
            $data[$k]['paytime'] = date('Y-m-d H:i:s',$v['paytime']);
            $data[$k]['pay_way'] = $v['pay_way']=='weixin' ? '微信支付' : '支付宝城市';
            $data[$k]['goods_describe'] = $v['goods_describe'];
            $data[$k]['store'] = M('cashier_stores')->get_var(array('id'=>$v['storeid']),'branch_name');
        }                 
        $title = array('交易单号','应收金额','实收金额','交易时间','交易类型','付款方式','门店');
        $filename = '收银员订单表'.date('Ymd-His').'.xls';
        $this->ExportTable($data,$title,$filename);
    }

    // 更新记录
    public function noticeList () {

        $getdata = $this->clear_html($_GET);

        $notice =  M('cashier_notice')->get_one(array('id'=>$getdata['id']),'*');

        include $this->showTpl();
    }


    
    /**
     * 员工统计详情
     */
	public function StaffCount(){
        $getdata = $this->clear_html($_GET);
        if($_GET['id']){
            $_SESSION['eid'] = $_GET['id'];
        }
        $whereStr = 'ordr.ispay="1" AND ordr.eid='.$_SESSION['eid'];
        $wherecStr = 'ispay="1" AND eid='.$_SESSION['eid'];
        $start = ((isset($getdata['start']) ? strtotime($getdata['start']) : 0));
        $end = ((isset($getdata['end']) ? strtotime($getdata['end']) : 0));
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
        
         
        $_count = $orderDb->count($wherecStr);
        $p = new Page($_count, 2);
        $pagebar = $p->show(2);
        $sqlStr = 'SELECT ordr.*,e.username FROM ' . $tablepre . 'cashier_order as ordr LEFT JOIN ' . $tablepre . 'cashier_employee AS e ON ordr.eid=e.eid where '.$whereStr ;
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
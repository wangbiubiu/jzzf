
<?php
bpBase::loadAppClass('common', 'Salesman', 0);
class index_controller extends common_controller
{


	public function __construct()
	{
		parent::__construct();
	}
	
    /*
     * 首页
     */
	public function index()
	{
	    $sqlObj = new model();
	    $time = date('Y-m-d',time());
	    $t = strtotime($time);
	    $t1 = $t-86400;
	    $t2 = $t+86400;
	   
	    //查询当前业务员下所有商家
	    $mid = $this->MerchantsID($this->salesmans['id']);
	    if(!$mid){
	        $mid = 0;
	    }
	    //昨日交易笔数
	    $num = "SELECT count(id) as count FROM ".$this->tablepre."cashier_order where `paytime` < ". $t ." AND `paytime`>=".$t1.' AND mid IN('.$mid.') AND ispay=1';
	    $number = $sqlObj->get_varBySql($num,'count');
	    $sql = "SELECT SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where `paytime` < ". $t ." AND `paytime`>=".$t1.' AND mid IN('.$mid.') AND ispay=1';
	    //昨日交易金额
	    $money = $sqlObj->get_varBySql($sql,'num');
	    if(!$money)$money=0;
	    //今日
	    $num2 = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND mid IN('.$mid.') AND ispay=1';
	    $number2 = $sqlObj->get_varBySql($num2,'count');
	    $sql2 = "SELECT SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND mid IN('.$mid.') AND ispay=1';
	    $money2 = $sqlObj->get_varBySql($sql2,'num');
	    if(!$money2)$money2=0;
	    //累计交易笔数
	    $transactionSql ="SELECT count(id) as count,SUM(`goods_price`) as num FROM ".$this->tablepre."cashier_order where mid IN(".$mid.") AND ispay=1";
	    $transactionCount = $sqlObj->selectBySql($transactionSql);
	    //统计商户数量;
	    $merchants_count_sql = "SELECT count(*) as count FROM ".$this->tablepre."cashier_merchants WHERE sid=".$this->salesmans['id'];
	    $merchants_count_num = $sqlObj->get_varBySql($merchants_count_sql,'count');
	    //统计商户下的所有门店
	    $employee_count_sql = "SELECT count(*) as count FROM ".$this->tablepre."cashier_employee WHERE mid IN (".$mid.")";
	    $employee_count_num = $sqlObj->get_varBySql($employee_count_sql,'count');
		include $this->showTpl();
	}
	
        
    public function sindex()
	{
	    
		include $this->showTpl();
	}
	
	public function goPigCms()
	{
		if (!empty($this->merchant['thirduserid']) && ($this->merchant['source'] == 1) && !0 < $this->eid) {
			$code = json_encode(array('mid' => $this->mid, 'mktime' => time(), 'ptoken' => $this->merchant['thirduserid']));
			$codeStr = Encryptioncode($code, 'ENCODE');
			$codeStr = base64_encode($codeStr);
			Header('Location:' . $this->SiteUrl . '/index.php?m=Salesman&a=cashierBack&token=' . $this->merchant['thirduserid'] . '&lgcode=' . $codeStr);
			exit();
	}


		$this->errorTip('登录出错');
		exit();
	}

//	public function ModifyPwd()
//	{
//		$phone = '';
//
//		if ($this->merchant['phone']) {
//			$phone = str_replace(substr($this->merchant['phone'], 3, 4), '****', $this->merchant['phone']);
//		}
//
//
//		$sms_config = loadConfig('sms');
//		include $this->showTpl();
//	}

	public function doModifyPwd()
	{
		$oldpwd = trim($_POST['oldpwd']);
		$newpwd = trim($_POST['newpwd']);
		$new2pwd = trim($_POST['new2pwd']);
		$code = trim($_POST['code']);
		$phone = trim($_POST['phone']);
		$sms_config = loadConfig('sms');
                
		if ($this->merchant['phone'] && $sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
			$session = $_SESSION['change_password_phone'][$this->merchant['phone']];
			if (!$session && ($session[0] == $code) && (($_SERVER['REQUEST_TIME'] - $session[1]) < 1800)) {
				$this->errorTip('手机验证有误！');
				exit();
			}

		}


		if (empty($oldpwd)) {
			$this->errorTip('旧密码不能为空！');
			exit();
		}


		if (empty($newpwd)) {
			$this->errorTip('新密码不能为空！');
			exit();
		}


		if ($newpwd != $new2pwd) {
			$this->errorTip('两次输入的密码不一致！');
			exit();
		}


		$oldpwd = $this->toPassword($oldpwd, $this->merchant['salt']);

		if ($oldpwd != $this->merchant['password']) {
			$this->errorTip('旧密码不对！');
			exit();
		}


		$newpwdstr = $this->toPassword($newpwd, $this->merchant['salt']);
		$updatedata = array('password' => $newpwdstr, 'mfypwd' => 1);

		if (!empty($phone) && (strpos($phone, '**') === false)) {
			$updatedata['phone'] = $phone;
		}


		$flage = M('cashier_merchants')->update($updatedata, array('mid' => $this->merchant['mid']));

		if ($flage) {
			$_SESSION['change_password_phone'][$this->merchant['phone']] = '';
			$this->successTip('修改成功，请重新登录！', '/merchants.php?m=User&c=index&a=logout');
			exit();
		}
		 else {
			$this->errorTip('密码修改失败！');
			exit();
		}
	}

	public function logout()
	{
		$_SESSION['my_Cashier_Merchant'] = NULL;
		unset($_SESSION['my_Cashier_Merchant']);
		$_SESSION['my_Cashier_Employer'] = NULL;
		unset($_SESSION['my_Cashier_Employer']);
		$_SESSION['wxshoplist'] = NULL;
		unset($_SESSION['wxshoplist']);
		header('Location:?m=Index&c=login&a=salesmansLogin');
	}

	public function getCode()
	{
		$mobile = $this->merchant['phone'];
		$_SESSION['change_password_phone'][$mobile] = '';
		$string = '0123456789';
		$count = strlen($string) - 1;
		$rand_num = '';
		$i = 0;

		while ($i < 6) {
			$rand_num .= $string[mt_rand(0, $count)];
			++$i;
		}

		$_SESSION['change_password_phone'][$mobile] = array($rand_num, $_SERVER['REQUEST_TIME']);
		bpBase::loadOrg('Sms');
		$return_status = Sms::sendSms($this->merchant['mid'], '您的验证码是：' . $rand_num . '。 此验证码30分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！', $mobile);

		if (($return_status == 0) && (strlen($return_status) == 1)) {
			exit(json_encode(array('error' => 0)));
		}
		 else if ($return_status == NULL) {
			exit(json_encode(array('error' => 1, 'info' => '没有购买')));
		}
		 else {
			exit(json_encode(array('error' => 1, 'info' => '短信发送失败,请稍后再试' . $return_status)));
		}
	}
}


?>
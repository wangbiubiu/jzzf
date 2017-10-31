<?php

bpBase::loadAppClass('common', 'Agent', 0);
class index_controller extends common_controller
{

	public $Merchants;
	public $aid;

	public function __construct()
	{
		parent::__construct();
		
		$this->Merchants=M('cashier_merchants');
		$this->aid = $_SESSION['my_Cashier_Agent']['aid'];

	}

	public function index()
	{

		
		$merchantNum = $this->Merchants->count('aid='.$this->aid);


		$storeNum = M('cashier_stores')->count(' mid in (select mid from '.$this->tablepre.'cashier_merchants where aid ='.$this->aid.')');

		// 全部
		$whereAll = ' AND paytime>'.strtotime(date('Y-m',time()));

		$AllDeal = $this->staticSql($whereAll);


		//今天
		$whereTodoy = ' AND paytime>'.strtotime(date('Y-m-d',time()));
		$TodayDeal = $this->staticSql($whereTodoy);

				
		//昨天
		$st = strtotime(date('Y-m-d',time()-3600*24));
		$et = strtotime(date('Y-m-d',time()));
		$whereLastDay = 'AND paytime >'.$st.'  AND paytime < '.$et;
		$LastDayDeal = $this->staticSql($whereLastDay);

		// 系统公告

		$notice = M('cashier_notice')->select('1=1','*','10','id desc');

		include $this->showTpl();
	}

	public function staticSql ($where='') {
		$obj = new model(); 
		$sql = 'select count(id) as num,sum(income) as sum from '.$this->tablepre.'cashier_order where mid in (select mid from '.$this->tablepre.'cashier_merchants where aid = '.$this->aid.') and ispay=1 '.$where;
		$result =  $obj->selectBySql($sql);

		return $result[0];
	}


#-------------------------------------下面是以前的代码---------------------------------------------------------------------#
	public function goPigCms()
	{
		if (!empty($this->merchant['thirduserid']) && ($this->merchant['source'] == 1) && !0 < $this->eid) {
			$code = json_encode(array('mid' => $this->mid, 'mktime' => time(), 'ptoken' => $this->merchant['thirduserid']));
			$codeStr = Encryptioncode($code, 'ENCODE');
			$codeStr = base64_encode($codeStr);
			Header('Location:' . $this->SiteUrl . '/index.php?m=Agent&a=cashierBack&token=' . $this->merchant['thirduserid'] . '&lgcode=' . $codeStr);
			exit();
		}


		$this->errorTip('登录出错');
		exit();
	}

	public function ModifyPwd()
	{
		$phone = '';

		if ($this->merchant['phone']) {
			$phone = str_replace(substr($this->merchant['phone'], 3, 4), '****', $this->merchant['phone']);
		}


		$sms_config = loadConfig('sms');
		include $this->showTpl();
	}

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


	public function SetAccount () {

		if (!IS_POST){
			$agenter = M('cashier_agent')->get_one(array('aid'=>$this->aid),'aid,uname,password,salt,account');
			
		}else{


			$postdata = $this->clear_html($_POST);

			$agent = M('cashier_agent')->get_one(array('aid'=>$postdata['aid']) ,'*');

			if (!$agent) {
				$this->errorTip('账户错误!');exit();

			}
			$set['uname'] = $postdata['uname'];
		
			if (isset($postdata['setPw'])&&$postdata['setPw']=='on') {

				if ($agent['password'] !=$this->toPassword($postdata['oldpwd'],$agent['salt'])){
					$this->errorTip('旧密码不正确');exit();

				} 
		


				if (trim($postdata['newpwd'])=='') {

					$this->errorTip('新密码不能为空！');exit();
				}

				$set['password'] = trim($this->toPassword($postdata['newpwd'],$agent['salt']));

			}	

			
			if (M('cashier_agent')->update($set,array('aid'=>$agent['aid']))) {

				$agenter = M('cashier_agent')->get_one(array('aid'=>$this->aid),'aid,uname,password,salt,account');

			}
			
		}

		include $this->showTpl();

	}


	public function logout()
	{
		$_SESSION['my_Cashier_Agent'] = NULL;
		unset($_SESSION['my_Cashier_Agent']);
		$_SESSION['my_Cashier_Salesman'] = NULL;
		unset($_SESSION['my_Cashier_Salesman']);
		$_SESSION['wxshoplist'] = NULL;
		unset($_SESSION['wxshoplist']);
		header('Location:?m=Index&c=login&a=agentLogin');
	}

	public function getCode()
	{
		$mobile = $this->agent['phone'];
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
		$return_status = Sms::sendSms($this->agent['aid'], '您的验证码是：' . $rand_num . '。 此验证码30分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！', $mobile);

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


	public function notice () {
		$notice = M('cashier_notice')->select(array('id'=>$_GET['nid']),'*');
		$notice = $notice[0];
		include $this->showTpl();
	}
}


?>
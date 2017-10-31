<?php

bpBase::loadAppClass('common', 'User', 0);

class modify_controller extends common_controller
{


	public function __construct()
	{
		parent::__construct();
		$this->employee = M('cashier_employee');
		$this->eid = (int)$_SESSION['my_Cashier_Employer']['eid'];
	}

	public function setPwd () {
		$user = $this->employee->get_one(array('eid' =>$this->eid),'eid,phone');
		include $this->showTpl();

	}

	public function setElo () {
		$user = $this->employee->get_one(array('eid' =>$this->eid),'eid,phone,storeid');
		$emloyees = $this->employee->select(array('storeid'=>$user['storeid']),'*');
        include $this->showTpl();
	}


	public function setConf () {

		
		include $this->showTpl();
	}

	public function  doSetPwd() {
		

		$oldpwd = trim($_POST['oldpwd']);
		$newpwd = trim($_POST['newpwd']);
		$new2pwd = trim($_POST['new2pwd']);
		//$code = trim($_POST['code']);
		$phone = trim($_POST['phone']);
		$sms_config = loadConfig('sms');

		

		$user = $this->employee->get_one(array('eid' =>$this->eid),'eid,phone,salt,password');

		if ($user['phone'] && $sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
			$session = $_SESSION['change_password_phone'][$user['phone']];
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


		$oldpwd = $this->toPassword($oldpwd, $user['salt']);

		if ($oldpwd != $user['password']) {
			$this->errorTip('旧密码不对！');
			exit();
		}


		$newpwdstr = $this->toPassword($newpwd, $user['salt']);
		$updatedata = array('password' => $newpwdstr);

		if (!empty($phone) && (strpos($phone, '**') === false)) {
			$updatedata['phone'] = $phone;
		}

		$flage = $this->employee->update($updatedata, array('eid' => $user['eid']));

		if ($flage) {
			$_SESSION['change_password_phone'][$this->merchant['phone']] = '';
			$this->successTip('修改成功，请重新登录！', '/merchants.php?m=User&c=index&a=logout');
			exit();
		}
		 else {
			$this->errorTip('密码修改失败！');
			exit();
		}
		// echo '<pre>';
		// print_r ($updatedata);
		// echo '</pre>';die;
		// die;

	}


	

	



}


?>
<?php

bpBase::loadAppClass('base', '', 0);

class login_controller extends base_controller
{
	public $merchants;
	public $employees;	
	public $agent;
	public $salesmans;
    public $model;

	public function __construct()
	{
		parent::__construct();
        $this->agent = M('cashier_agent');
		$this->salesmans = M('cashier_salesmans');
		$this->merchants = M('cashier_merchants');
		$this->employee = M('cashier_employee');
		$this->model = new model();
		$session_storage = getSessionStorageType();
		bpBase::loadSysClass($session_storage);
	}

	public function index()
	{
		$ltyp = ((isset($_GET['ltyp']) ? intval($_GET['ltyp']) : 0));
		$sms_config = loadConfig('sms');
		include $this->showTpl();
	}
	
	/**
	 *  代理商登录
	 */
	public function agentLogin(){

	    $ltyp = ((isset($_GET['ltyp']) ? intval($_GET['ltyp']) : 0));
	    $sms_config = loadConfig('sms');
	    include $this->showTpl();
	}
	
	
	
	/**
	 * 业务员登录
	 */
	public function salesmansLogin(){
	    $ltyp = ((isset($_GET['ltyp']) ? intval($_GET['ltyp']) : 0));
	    $sms_config = loadConfig('sms');
	    include $this->showTpl();
	}
	
	

//	public function register()
//	{
//		$sms_config = loadConfig('sms');
//
//		include $this->showTpl();
//	}

	public function signin()
	{

		if (IS_POST) {
    
			$data = $this->clear_html($_POST);
                        
			if ($data['flag']) {

				// 代理销售
				if ($data['type'] == 'merchant') {
				   
					$user = $this->agent->get_one(array('account' => $data['username']));
				}
				 else if ($data['type'] == 'employee') {
				     
                    $user = $this->salesmans->get_one(array('account' => $data['username']));
				}
			}else{
				// 商家 店员
				if ($data['type'] == 'merchant') {
					$user = $this->merchants->get_one(array('username' => $data['username']));
				}
				 else if ($data['type'] == 'employee') {
				     
					$user = $this->employee->get_one(array('account' => $data['username']));
				}
				
			}

			if (!$user) {
				$this->errorTip('用户名不存在！', $_SERVER['HTTP_REFERER']);
				exit();
			}


			$sms_config = loadConfig('sms');
			if ($user['phone'] && $sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
				$session = $_SESSION['login_phone'][$user['phone']];
				if (!$session && ($session[0] == $data['code']) && (($_SERVER['REQUEST_TIME'] - $session[1]) < 1800)) {
					$this->errorTip('手机验证有误！');
					exit();
				}

			}


			if ($this->toPassword($data['password'], $user['salt']) != $user['password']) {
				$this->errorTip('密码错误！', $_SERVER['HTTP_REFERER']);
				exit();
			}


			if ($user['status'] == 0) {
				$this->errorTip('您的账户正在审核中，不可登录使用！', $_SERVER['HTTP_REFERER'], 7);
				exit();
			}
			 else if ($user['status'] == 2) {
				$this->errorTip('您的账户暂时被禁止登录，请联系管理员处理！', $_SERVER['HTTP_REFERER'], 7);
				exit();
			}


			$_SESSION['my_Cashier_Employer'] = NULL;
			$_SESSION['my_Cashier_Merchant'] = NULL;
			$_SESSION['my_Cashier_Agent'] = NULL;
			$_SESSION['my_Cashier_Salesman'] = NULL;

			unset($_SESSION['my_Cashier_Employer']);
			unset($_SESSION['my_Cashier_Merchant']);
			unset($_SESSION['my_Cashier_Agent']);
			unset($_SESSION['my_Cashier_Salesman']);

			
			if($data['flag']){
			    
			    if ($data['type'] == 'merchant') {
			        
			        $_SESSION['my_Cashier_Agent']['aid'] = $user['aid'];

                   
			    }else if ($data['type'] == 'employee') {
			        
			        $_SESSION['my_Cashier_Salesman']['sid'] = $user['id'];
			        
			        
			    }  

			}else{


			    if ($data['type'] == 'merchant') {
			        
			        $_SESSION['my_Cashier_Merchant']['mid'] = $user['mid'];
			    }else if ($data['type'] == 'employee') {
			        $_SESSION['my_Cashier_Employer']['eid'] = $user['eid'];
			        $_SESSION['E_LEVEL'] = $user['level'];
			       
			    }        
			}
            
           
			$_SESSION['login_phone'][$user['phone']] = '';
			if($data['flag']){
			    if ($data['type'] == 'merchant') {
			        $this->successTip('登录成功！', '/merchants.php?m=Agent&c=index&a=index');
			    }else if ($data['type'] == 'employee') {
			        $this->successTip('登录成功！', '/merchants.php?m=Salesman&c=index&a=index');
			    }
			}else{
			    if ($data['type'] == 'merchant') {
			        //把登录者的账号记住有用
                    $_SESSION['USERNAME']=$data['username'];
			        $this->successTip('登录成功！', '/merchants.php?m=User&c=index&a=index');
			    }else if ($data['type'] == 'employee') {
			        $this->successTip('登录成功！', '/merchants.php?m=User&c=index&a=index');
			    } 
			}
			exit();
		}
}


	public function signed()
	{
		if (IS_POST) {
			$data = $this->clear_html($_POST);
                       
			$session = $_SESSION['register_phone'][$data['phone']];
			$sms_config = loadConfig('sms');
			if ($sms_config && isset($sms_config['sms_key']) && !empty($sms_config['sms_key'])) {
				if (!$session && ($session[0] == $data['code']) && (($_SERVER['REQUEST_TIME'] - $session[1]) < 1800)) {
					$this->errorTip('手机验证有误！');
					exit();
				}

			}


			unset($data['code']);
			$merchants = $this->merchants->get_one('username=\'' . $data['username'] . '\' OR company=\'' . $data['company'] . '\'');

			if ($merchants) {
				if ($merchants['username'] == $data['username']) {
					$this->errorTip('用户名已存在！', $_SERVER['HTTP_REFERER']);
					exit();
				}
				 else if ($merchants['company'] == $data['company']) {
					$this->errorTip('商户名已存在！', $_SERVER['HTTP_REFERER']);
					exit();
				}

			}


			if ($data['agree'] != 1) {
				$this->errorTip('请先同意使用条款！', $_SERVER['HTTP_REFERER']);
				exit();
			}


			unset($data['agree']);
			$_SESSION['my_Cashier_Merchant'] = NULL;
			$data['salt'] = mt_rand(111111, 999999);
			$data['password'] = $this->toPassword($data['password'], $data['salt']);
			$data['lastLoginTime'] = $data['regTime'] = SYS_TIME;
			$data['lastLoginIp'] = $data['regIp'] = ip2long(ip());
                        $data['mtype'] = 1;
                       
			$sysadmin = loadConfig('sysadmin');
                        
			if (!empty($sysadmin) && isset($sysadmin['isregcheck']) && ($sysadmin['isregcheck'] == 1)) {
				$data['status'] = 0;
			}


			if ($vo = $this->merchants->insert($data, 1)) {
				$session_storage = getSessionStorageType();
				bpBase::loadSysClass($session_storage);
				$payconfigDb = M('cashier_payconfig');
				$configData = serialize(array(
                                'weixin' => array('appid' => '', 'appSecret' => '', 'isOpen' => 1)
                                ));
				$inserData = array('mid' => $vo, 'isOpen' => 1, 'configData' => $configData, 'pfpaymid' => '0','proxymid'=>1);
				$payconfigDb->insert($inserData, 1);
				$_SESSION['register_phone'][$data['phone']] = '';

				if (!empty($sysadmin) && isset($sysadmin['isregcheck']) && ($sysadmin['isregcheck'] == 1)) {
					$this->successTip('您已经注册成功！请等待管理员审核，账号审核通过后才能正常的登录本收银系统！', '/merchants.php?m=Index&c=login&a=index', 15);
					exit();
				}
				 else {
					$_SESSION['my_Cashier_Merchant']['mid'] = $vo;
					$this->successTip('注册成功！', '/merchants.php?m=User&c=index&a=index');
					exit();
				}
			}
			 else {
				$this->errorTip('注册失败！', $_SERVER['HTTP_REFERER']);
				exit();
			}
		}

	}



	public function getCode()
	{
		$type = ((isset($_POST['type']) ? htmlspecialchars($_POST['type']) : ''));

		if ($type == 'login') {
			$username = ((isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''));
			$atype = ((isset($_POST['atype']) ? htmlspecialchars($_POST['atype']) : 'merchant'));

			if ($atype == 'merchant') {
				$merchant = $this->merchants->get_one('username=\'' . $username . '\'');
			}
			 else {
				$merchant = $this->employee->get_one(array('account' => $username));
			}

			if (empty($merchant)) {
				exit(json_encode(array('error' => 1, 'info' => '请您填写您正确的账号')));
			}


			$mobile = $merchant['phone'];

			if (empty($mobile)) {
				exit(json_encode(array('error' => 1, 'info' => '您该账号还没有绑定手机号，请无视验证，直接点击登录！为了您的账号安全，我们强烈要求您登录后，在修改密码的地方绑定您的手机号！')));
			}

		}
		 else if ($type == 'register') {
			$phone = ((isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''));

			if (empty($phone)) {
				exit(json_encode(array('error' => 1, 'info' => '请您填写您的手机号')));
			}


			$mobile = $phone;
		}


		$_SESSION[$type . '_phone'][$mobile] = '';
		$string = '0123456789';
		$count = strlen($string) - 1;
		$rand_num = '';
		$i = 0;

		while ($i < 6) {
			$rand_num .= $string[mt_rand(0, $count)];
			++$i;
		}

		$_SESSION[$type . '_phone'][$mobile] = array($rand_num, $_SERVER['REQUEST_TIME']);
		bpBase::loadOrg('Sms');
		$return_status = Sms::sendSms($merchant['mid'], '您的验证码是：' . $rand_num . '。 此验证码30分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！', $mobile);

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
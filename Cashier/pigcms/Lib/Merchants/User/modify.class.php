
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


	// 密码设置页面
	public function setPwd () {
		$user = $this->employee->get_one(array('eid' =>$this->eid),'eid,phone');
        if($this -> isMobile()){
            include $this->showTpl("setPwdWap");
        }
        else{
            include $this->showTpl();
        }

	}


	// 员工设置页面
	public function setElo () {
        $employees = $this->employee->select(array('storeid'=>$this->storeid),'username,phone,eid,storeid');
        $authority = $this->authorityList('Merchants/User');
        include $this->showTpl();
	}


	// 权限列表
	private function authorityList($data = '') {
        $authority = loadConfig('authority');
        $info = explode('/', $data);
        $result = $this->dataOut($authority, $info);
        unset($result['Des']);
        return $result;
    }
    
    private function dataOut($data, $goal) {
        foreach ($goal as $key => $val) {
            $data = $data[$goal[$key]];
        }
        return $data;
    }
    // 检查账户是否存在
    public function checkAccount () {
    	if (IS_POST) {
            $data = $this->clear_html($_POST);
            if ($this->employee->get_one(array('account' => $data['account']), 'eid,account')) {
                echo json_encode(array('status' => 0, 'msg' => '登录账号已存在'));
            } else {
                echo json_encode(array('status' => 1, 'msg' => '验证成功'));
            }
        }
    }


    // 添加
    public function employersAdd () {
    	if (IS_POST) {
            
            $data = $this->clear_html($_POST);
           
            if ($data['password'] != $data['confirm']) {
                $this->errorTip('两次输入密码不一致！', $_SERVER['HTTP_REFERER']);
                exit;
            }

            $data['mid'] = $this->mid;
            $data['salt'] = mt_rand(111111, 999999);
            $data['password'] = md5(md5($data['password'] . '_' . $data['salt']) . $data['salt']);
            $data['authority'] = !empty($data['authority']) ? implode(',', $data['authority']) : '';
            $data['storeid'] = $this->storeid;
            unset($data['confirm']);
            if ($this->employee->insert($data, 1)) {
                $this->successTip('添加员工账号成功！', $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip('添加员工账号失败！', $_SERVER['HTTP_REFERER']);
                exit;
            }
        }

    }

    // 删除全部
    public function employersDelAll() {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_delAll($this->employee, $data['id']);
            if ($return['status'] == '1') {
                $this->successTip($return['msg'], $_SERVER['HTTP_REFERER']);
                exit;
            } else {
                $this->errorTip($return['msg'], $_SERVER['HTTP_REFERER']);
                exit;
            }
        }
    }

	public function setConf () {

		
		include $this->showTpl();
	}


	public function employersDel() {
		
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $return = $this->_del($this->employee, $data['eid']);
            exit(json_encode($return));
        }
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
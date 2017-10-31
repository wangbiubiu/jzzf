
<?php
bpBase::loadAppClass('common', 'User', 0);
class index_controller extends common_controller
{


    public function __construct()
    {

        parent::__construct();

    }

    public function index()
    {
        
        if($this->merchant && empty($this->employer)){
            $_SESSION['USERNAME']=$this->merchant['username'];
            header('Location:merchants.php?m=User&c=index&a=sindex');
            exit();
        }else if(isset($this->employer) && $this->employer['level'] == '1'){
            header('Location:merchants.php?m=User&c=manager&a=index');
            exit();
        }else{
            header('Location:merchants.php?m=User&c=staff&a=index');
            exit();
        }
        //include $this->showTpl();
    }

    public function sindex()
    {
        
        $sqlObj = new model();
        $time = date('Y-m-d',time());
        $t = strtotime($time);
        $t1 = $t-86400;
        $t2 = $t+86400;
        //昨日交易笔数
        $num = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND mid='.$this->mid;
        $number = $sqlObj->get_varBySql($num,'count');
        $sql = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t ." AND `paytime`>=".$t1.' AND mid='.$this->mid;
        //昨日交易金额
        $money = $sqlObj->get_varBySql($sql,'num');
        if(!$money)$money=0;
        //今日
        $num2 = "SELECT count(*) as count FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND mid='.$this->mid;
        $number2 = $sqlObj->get_varBySql($num2,'count');
        $sql2 = "SELECT SUM(`income`) as num FROM ".$this->tablepre."cashier_order where ispay='1' AND `paytime` < ". $t2 ." AND `paytime`>=".$t.' AND mid='.$this->mid;
        $money2 = $sqlObj->get_varBySql($sql2,'num');
        if(!$money2)$money2=0;

        //系统公告
        $notice = M('cashier_notice')->select('','*','10',' id desc');
        //获取用户类型
        $mer = M("cashier_merchants") -> get_one("mid=".$this->mid,"mtype,sub_merchant");
        $mtype = $mer['mtype'];
        $sub_merchant = $mer['sub_merchant'];
        if($this->isMobile()){
            include $this->showTpl("sindexwap");
        }
        else{
            include $this->showTpl();
        }
    }

    public function notice(){

        $id = isset($_GET['id'])?intval($_GET['id']):0;
        $row = M('cashier_notice')->get_one(array('id'=>$id));
        $row['addtime'] = date('Y-m-d',$row['addtime']);
        $row['content'] = htmlspecialchars_decode($row['content']);

        include $this->showTpl();
    }
    public function goPigCms()
    {
        if (!empty($this->merchant['thirduserid']) && ($this->merchant['source'] == 1) && !0 < $this->eid) {
            $code = json_encode(array('mid' => $this->mid, 'mktime' => time(), 'ptoken' => $this->merchant['thirduserid']));
            $codeStr = Encryptioncode($code, 'ENCODE');
            $codeStr = base64_encode($codeStr);
            Header('Location:' . $this->SiteUrl . '/index.php?m=Users&a=cashierBack&token=' . $this->merchant['thirduserid'] . '&lgcode=' . $codeStr);
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
        header('Location:?m=Index&c=login&a=index');
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
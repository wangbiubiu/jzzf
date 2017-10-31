<?php
bpBase::loadAppClass('common', 'Agent', 0);
bpBase::loadOrg('common_page');

class merchant_controller extends common_controller
{

    public $pigcms_static = '';

    protected $aid;
    public $payConfigDb;
    public $agent;

    public function __construct()
    {
        parent::__construct();
        $this->payConfigDb = M('cashier_payconfig');
        $this->aid = $_SESSION['my_Cashier_Agent']['aid'];
        $this->agent = M('agent');
    }

    // 代理商>商户中心
    public function index()
    {
        if (IS_POST) {
            $getdata = $this->clear_html($_POST);
            if (!empty($getdata['username'])) {
                $where['username'] = array(
                    'LIKE',
                    '%' . $getdata['username'] . '%'
                );
            }
        }

        $where['aid'] = $this->aid;
        $count = M('cashier_merchants')->count($where);
        $page = new Page($count, 10);
        $p = $page->show(2);
        $limit = $page->firstRow . ',' . $page->listRows;

        $merchants = M('cashier_merchants')->select($where, 'sub_merchant,mid,mchid,username,mtype,realname,company,phone,sid,regTime,isopenwxpay,isopenalipay,mtype', $limit, 'mid desc');
        foreach ($merchants as $k => &$v) {
            $payconfig = M("cashier_payconfig") -> get_one(array("mid"=>$v['mid']),"*");
            if ($payconfig['configData']) {
                $payConfig = unserialize(htmlspecialchars_decode($payconfig['configData'], ENT_QUOTES));
//                dump($payConfig);
                $v['fromSaler'] = M('cashier_salesmans')->get_one('id=' . $v['sid'], 'username')['username'];
                if ($v['mtype'] == "1") {
                    $state1 = M('cashier_regist')->get_one("mid='" . $v['mid'] . "' AND contactor <> ''", 'status');//微信状态
                    $state2 = $state1;//支付宝状态
                    if ($state1['status'] != 2 || empty($state1)) {
                        $merchants[$k]['isopenwxpay'] = 0;
                        $merchants[$k]['isopenalipay'] = 0;
                    }
                    else{
                        if(empty($payConfig['weixin']['mchid'])){
                            $merchants[$k]['isopenwxpay'] = 0;
                        }
                        else{
                            $merchants[$k]['isopenwxpay'] = 1;
                        }
                        if(empty($payConfig['alipay']['appauthtoken'])){
                            $merchants[$k]['isopenalipay'] = 0;
                        }
                        else{
                            $merchants[$k]['isopenalipay'] = 1;
                        }
                    }
                } else {
                    $state1 = M('cashier_regist')->get_one("mid='" . $v['mid'] . "' AND wechat <> ''", 'status');//微信状态
                    $state2 = M('cashier_regist')->get_one("mid='" . $v['mid'] . "' AND alipay <> ''", 'status');//支付宝状态
                    if ($state1['status'] != 2 || empty($state1)) {
                        $merchants[$k]['isopenwxpay'] = 0;
                    }
                    else{
                        if(empty($payConfig['weixin']['mchid'])){
                            $merchants[$k]['isopenwxpay'] = 0;
                        }
                        else{
                            $merchants[$k]['isopenwxpay'] = 1;
                        }
                    }
                    if ($state2['status'] != 2 || empty($state2)) {
                        $merchants[$k]['isopenalipay'] = 0;
                    }
                    else{
                        if(empty($payConfig['alipay']['appID'])){
                            $merchants[$k]['isopenalipay'] = 0;
                        }
                        else{
                            $merchants[$k]['isopenalipay'] = 1;
                        }
                    }
                }
            }
            else{
                $merchants[$k]['isopenwxpay'] = 0;
                $merchants[$k]['isopenalipay'] = 0;
            }
        }
        include $this->showTpl();
    }

    // 创建商家
    public function createMerchant()
    {

        if (IS_POST) {

            $data = $this->clear_html($_POST);


            $pwd = $data['password'];
            if (empty($data['mid'])) {
                if (!isset($data['mtype']) || $data['mtype'] == '') {
                    $this->errorTip('请选择商户类型', $_SERVER['HTTP_REFERER']);
                    exit();
                }
                if (M('cashier_merchants')->get_one(array(
                    'username' => $data['username']
                ), 'mid')
                ) {

                    $this->errorTip('账户名称已存在', $_SERVER['HTTP_REFERER']);
                    exit();
                }
                $makeMerchant['regIp'] = ip();
                $makeMerchant['regTime'] = time();
            } else {
                $midTmp = M('cashier_merchants')->get_one(array('username' => $data['username']), 'mid');
                if($midTmp['mid'] != $data['mid']){
                    $this->errorTip('账户名称已存在2', $_SERVER['HTTP_REFERER']);
                    exit();
                }
                if($data['mtype'] == 2 or $data['mtype'] == 3){
                    $data['commission'] = $data['commission2'];
                    $data['alicommission'] = $data['alicommission2'];
                }
            }
            $makeMerchant['username'] = $data['username'];

            if (!isMobile($data['phone'])) {
                $this->errorTip('不是有效的手机号码', $_SERVER['HTTP_REFERER']);
                exit();
            }
            $makeMerchant['phone'] = $data['phone'];

            if (!empty($data['tel']) && !empty($data['telPrefix'])) {

                $makeMerchant['tel'] = $data['telPrefix'] . '-' . $data['tel'];
            }

            if (!empty($data['password'])) {

                if ($data['password'] != $data['password2']) {
                    $this->errorTip('两次密码不相同', $_SERVER['HTTP_REFERER']);
                    exit();
                }
                $makeMerchant['salt'] = mt_rand(111111, 999999);
                $makeMerchant['password'] = $this->toPassword($data['password'], $makeMerchant['salt']);
            } else {

                if (!empty($data['changePwd']) || empty($data['mid'])) {

                    $this->errorTip('请填写密码', $_SERVER['HTTP_REFERER']);
                    exit();
                }
            }

            $makeMerchant['aid'] = $this->aid;

            if (empty($data['realname'])) {
                $this->errorTip('请填写联系人', $_SERVER['HTTP_REFERER']);
            }

            //地址


            $makeMerchant['address'] = $data['detailAddress'];

            if ($data['provinceinfo']) {

                $makeMerchant['fulladdress'] .= $data['provinceinfo'];

                if ($data['cityinfo']) {
                    $makeMerchant['fulladdress'] .= $data['cityinfo'];

                    if ($data['districtinfo']) {
                        $makeMerchant['fulladdress'] .= $data['districtinfo'];

                    }
                }


                $makeMerchant['fulladdress'] .= $data['detailAddress'];

            }


            // 地址
            $makeMerchant['city'] = $_POST['city'];
            $makeMerchant['province'] = $_POST['province'];
            $makeMerchant['area'] = $_POST['area'];


            $makeMerchant['sid'] = $data['saler'];
            if ($data['mtype'] == 2 or $data['mtype'] == 3) {
                $data['commission'] = $data['commission_an'];
                $data['alicommission'] = $data['commission_an'];
            } else if ($data['mtype'] == 1) {
                $data['sub_merchant'] = 1;
            }

            if (!empty($data['mid'])) {

            } else {//添加时候判断
                if (empty($data['commission'])) {
                   // $this->errorTip('请填写微信支付费率');
                }
                if (empty($data['alicommission'])) {
                   // $this->errorTip('请填写支付宝费率');
                }
            }


            //判断微信费率
            if (empty($data['commission'])) {
               // $this->errorTip('请填写微信支付费率');
            }
            $makeMerchant['commission'] = $data['commission'] / 100;

            /* // 检查费率是否超过极限值
            $rate =  M('cashier_wxrebate')->get_var(array('type'=>1),'rebate');

            if ( $rate >= $makeMerchant['commission']) {
                $this->errorTip('微信费率超出了平台的极限');
            }
            */


            //判断支付宝
            if (empty($data['alicommission'])) {
               // $this->errorTip('请填写支付宝支付费率');
            }
            $makeMerchant['alicommission'] = $data['alicommission'] / 100;

            /*  // 检查费率是否超过极限值
             $rateali =  M('cashier_wxrebate')->get_var(array('type'=>2),'rebate');
             if ( $rateali >= $makeMerchant['alicommission']) {
                 $this->errorTip('支付宝费率超出了平台的极限');
             } */

            $makeMerchant['realname'] = $data['realname'];
            $makeMerchant['company'] = $data['company'];
            $makeMerchant['mchid'] = rand(10000000, 99999999);
            $makeMerchant['sub_merchant'] = $data['sub_merchant'];
            $makeMerchant['mtype'] = $data['mtype'];
            if (empty($data['mid'])) {
                $vo = M('cashier_merchants')->insert($makeMerchant, true);
                if ($vo) {
                    $configData = serialize(array('weixin' => array('appid' => '', 'appSecret' => '')));
                    if ($makeMerchant['mtype'] == '1') {
                        $inserData = array('mid' => $vo, 'isOpen' => 1, 'configData' => $configData, 'pfpaymid' => '0', 'proxymid' => 1);
                    } else if ($makeMerchant['mtype'] == '2') {
                        $inserData = array('mid' => $vo, 'isOpen' => 1, 'configData' => $configData, 'pfpaymid' => '1');
                    }else if ($makeMerchant['mtype'] == '3') {
                        $inserData = array('mid' => $vo, 'isOpen' => 1, 'configData' => $configData, 'pfpaymid' => '1', 'proxymid' => 2);
                    }
                    $payconfigDb = M('cashier_payconfig');
                    $payconfigDb->insert($inserData, 1);
                    $url = $this->SiteUrl . '/index.php';
                    bpBase::loadOrg('Email');
                    $email = new Email();
                    $subject = "重庆云极付有限公司平台商户注册成功通知";//设置邮箱标题
                    $address = $data['username'];//需要发送的邮箱地址
                    $content = <<<ETC
                 <div style="width: 80%; background: #FFFFFF;">
                    <h1 style="font-weight: normal; text-align: center; width: 100%; border-bottom: 1px solid #F3F3F3;">欢迎注册云极付商户平台</h1>
                    <div style="padding: 0 30px;">账号注册成功<span>登录地址：$url </span></div>
                    <p style="padding: 0 30px;">我们已向你的邮箱 $address 发送邮件,登录密码: $pwd </p>
                </div>
ETC;
                    $res = $email->send_email($address, $subject, $content);
                    $this->successTip('添加商户账号成功', '?m=Agent&c=merchant&a=index');
                    exit();
                }
            } else {
                if (M('cashier_merchants')->update($makeMerchant, array(
                    'mid' => $data['mid']
                ))
                ) {
                    $this->successTip('账户保存成功', '?m=Agent&c=merchant&a=index');
                    exit();
                }
            }
        } else {

            $salers = M('cashier_salesmans')->select('aid=' . $this->aid, 'id,aid,username');
            $districts = M('cashier_district')->select(array(
                'fid' => '0'
            ), '*', '', 'id ASC');
            //查询微信费率配置
            $cashier_wxrebate_wx = M('cashier_wxrebate')->get_one(array('type' => 1, 'is_pay' => 2, '`key`' => 'aclear'), 'rebate');
            $cashier_wxrebate_wx = explode(',', $cashier_wxrebate_wx['rebate']);
            //查询支付宝费率配置
            $cashier_wxrebate_ali = M('cashier_wxrebate')->get_one(array('type' => 2, 'is_pay' => 2, '`key`' => "aclear"), 'rebate');
            $cashier_wxrebate_ali = explode(',', $cashier_wxrebate_ali['rebate']);
            $cashier_wxrebate_an = M('cashier_wxrebate')->get_one(array('type' => 1, 'is_pay' => 2, '`key`' => 'an'), 'rebate');
            $cashier_wxrebate_an = explode(',', $cashier_wxrebate_an['rebate']);
            //查询金海哲费率配置
            $cashier_wxrebate_jhzwx = M('cashier_wxrebate')->get_one(array('type' => 1, 'is_pay' => 2, '`key`' => "jhz"), 'rebate');
            $cashier_wxrebate_jhzwx = explode(',', $cashier_wxrebate_jhzwx['rebate']);
            $cashier_wxrebate_jhzqq = M('cashier_wxrebate')->get_one(array('type' => 3, 'is_pay' => 2, '`key`' => 'jhz'), 'rebate');
            $cashier_wxrebate_jhzqq = explode(',', $cashier_wxrebate_jhzqq['rebate']);

        }

        include $this->showTpl();
    }



//    public function editM

    /* * ******获取城市或区域信息******* */
    public function GetDistrict()
    {
        $districtid = isset($_POST['districtid']) ? trim($_POST['districtid']) : 0;
        if ($districtid > 0) {
            $districts = M('cashier_district')->select(array(
                'fid' => $districtid
            ), '*', '', 'id ASC');
            $this->dexit(array(
                'error' => 0,
                'data' => !empty($districts) ? $districts : ''
            ));
        }
        $this->dexit(array(
            'error' => 1,
            'data' => ''
        ));
    }

    // 代理商>删除商户
    public function delMerchant()
    {
        if (IS_POST) {
            $data = $this->clear_html($_POST);
            $id = $data['mid'];
            $mer = M('cashier_merchants')->get_one(array('mid' => $id));

            //查询该商户是否存在已支付订单
            $order = M('cashier_order')->select(array('mid' => $id, 'ispay' => 1));
            if (!empty($order)) {
                $this->dexit(array('errcode' => 0, 'errmsg' => '该商户下存在订单，删除失败!'));
            }

            if (empty($mer)) {
                $this->dexit(array('errcode' => 0, 'errmsg' => '商户不存在!'));
            }

            $return = M('cashier_merchants')->delete(array('mid' => $id));
            if ($return) {
                //删除商户下所有店铺
                $stores = M('cashier_stores')->delete(array('mid' => $id));
                //删除商户下所有员工
                $employee = M('cashier_employee')->delete(array('mid' => $id));
                //删除商户下所有进件信息
                $regist = M('cashier_regist')->delete(array('mid' => $id));
                //解除该商户下绑定二维码
                $data['mid'] = 0;
                $data['storesid'] = 0;
                $data['eid'] = 0;
                $data['status'] = 0;
                $qrcode = M('cashier_qrcode')->update($data, array('mid' => $id));
                $this->dexit(array('errcode' => 1, 'errmsg' => '删除商户成功!'));
            } else {
                $this->dexit(array('errcode' => 0, 'errmsg' => '删除商户失败!'));
            }

        }
    }

    // 代理商>商户信息
    public function setMerchant()
    {
        if (IS_POST) {
//            $data = $this->clear_html($_POST);
            die;
        } else {

            if (empty($_GET['mid']))
                $this->errorTip('账号异常出错');
            $salers = M('cashier_salesmans')->select(array(
                'aid' => $this->aid
            ), 'id,aid,username');
            $where['mid'] = $_GET['mid'];
            $merchant = M('cashier_merchants')->get_one($where, 'sub_merchant,username,mid,company,phone,commission,alicommission,tel,aid,mtype,sid,address,realname,province,city,area');
            $merchant['commission'] *= 100;
            $merchant['alicommission'] *= 100;
            $merchant['commission'] = strval($merchant['commission']);
            $merchant['alicommission'] = strval($merchant['alicommission']);
            $call = explode('-', $merchant['tel']);
            $merchant['telPrefix'] = $call[0];
            $merchant['tel'] = $call[1];
            $merchant['saler'] = M('cashier_salesmans')->get_one(array(
                'id' => $merchant['sid']
            ), 'username');
            $mid = $_GET['mid'];
            $merchant['fullprovice'] = $this->getFullName($merchant['province']);
            $merchant['fullcity'] = $this->getFullName($merchant['city']);
            $merchant['fullarea'] = $this->getFullName($merchant['area']);
            $district = M('cashier_district');


            $merchants_data = M('cashier_merchants')->get_one(array('mid' => $mid), '*');
            //市
            $districts_city = $district->select(array('fid' => intval($merchants_data['province'])), '*', '', 'id ASC');

            //区
            $districts_area = $district->select(array('fid' => $merchants_data['city']), '*', '', 'id ASC');

            $districts = $district->select(array('fid' => '0'), '*', '', 'id ASC');
            //查询微信费率配置
            $cashier_wxrebate_wx = M('cashier_wxrebate')->get_one(array('type' => 1, 'is_pay' => 2), 'rebate');
            $cashier_wxrebate_wx = explode(',', $cashier_wxrebate_wx['rebate']);
            //查询支付宝费率配置
            $cashier_wxrebate_ali = M('cashier_wxrebate')->get_one(array('type' => 2, 'is_pay' => 2), 'rebate');
            $cashier_wxrebate_ali = explode(',', $cashier_wxrebate_ali['rebate']);

            $cashier_wxrebate_an = M('cashier_wxrebate')->get_one(array('type' => 1, 'is_pay' => 2, '`key`' => 'an'), 'rebate');
            $cashier_wxrebate_an = explode(',', $cashier_wxrebate_an['rebate']);
            $_SESSION['mid'] = $_GET['mid'];
        }

        include $this->showTpl();
    }

    public function getFullName($id = 0)
    {
        if (!isset($id)) $id = 0;
        $name = M('cashier_district')->get_one(array('id' => $id), 'fullname');
        return $name['fullname'];
    }

    // 代理商>商户信息管理
    public function mngMerchant()
    {
        if (empty($_GET['mid'])) {
            $this->errorTip('账号异常出错');
        }


//        $this -> assign("wechatstatus",$wechatstatus);
//        $this -> assign("alipaystatus",$alipaystatus);
        //$status = $status ? $status : 0;//不存在的时候
        $where['mid'] = $_GET['mid'];
        $merchant = M('cashier_merchants')->get_one($where, '*');
        if($merchant['mtype'] == 1){
            $wechat = M('cashier_regist')->get_one("mid='".$_GET['mid']."' AND contactor <> ''", '*');
            $alipay = M('cashier_regist')->get_one("mid='".$_GET['mid']."' AND contactor <> ''", '*');
        }
        else{
            $wechat = M('cashier_regist')->get_one("mid='".$_GET['mid']."' AND wechat <> ''", '*');
            $alipay = M('cashier_regist')->get_one("mid='".$_GET['mid']."' AND alipay <> ''", '*');
        }
        $merchant['saler'] = M('cashier_salesmans')->get_one(array(
            'id' => $merchant['sid']
        ), 'username');

        $merchant['storeNum'] = M('cashier_stores')->count(array(
            'mid' => $merchant['mid']
        ));
//        $wechat = M("")
        include $this->showTpl();
    }

    public function SinParamsToString($params)
    {
        $sign_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key => $val) {
            if ($key == 'signature') {
                continue;
            }
            $sign_str .= sprintf("%s=%s&", $key, $val);
        }
        return substr($sign_str, 0, strlen($sign_str) - 1);
    }

    public function sign($data)
    {
        //读取私钥文件
        //注意所放文件路径
        $priKey = file_get_contents('../pem/850500053991253_prv.pem');

        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);

        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($data, $sign, $res);

        //释放资源
        openssl_free_key($res);

        return base64_encode($sign);
    }

    public function arrayToString($params)
    {
        $sign_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key => $val) {

            $sign_str .= sprintf("%s=%s&", $key, $val);
        }
        return substr($sign_str, 0, strlen($sign_str) - 1);

    }

    public function curlRequest($url, $data = null)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //curl_setopt($ch,CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        $outPut = curl_exec($ch);
        $aStatus = curl_getinfo($ch);
        curl_close($ch);
        if (intval($aStatus['http_code']) == 200) {
            return $outPut;
        } else {
            return false;
        }

    }
    //20170601修改
    public function cmbc_pieces()
    {
        $where['mid'] = $_GET['mid'];
        if (IS_POST) {
            $order_no = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 15);
            $arrHashCode = array(
                "requestNo" => $order_no,
                "version" => "V1.0",
                "transId" => "17",
                "merNo" => "850500053991253",
                "applyType" => "BANKSP",
                "applyCont" => json_encode($_POST)
            );
            if($_POST['chnlType'] == "WEIXIN"){
                $_POST['authPaydir'] = "https://pay.yunjifu.net/Cashier/pay/wxpay/";//默认支付的路径
                $_POST['weiXinChannelId']='30204483';//微信渠道号
                $_POST['bankAppId']=$_POST['bankAcceptAppid'];//子商户公众号ID
            }
            $post_data['wechat'] = addslashes(json_encode($_POST,JSON_UNESCAPED_SLASHES));//提交的数据
            $post_data['status'] = 0;//待初审
            $post_data['mid'] = $_GET['mid'];//商户ID
            $post_data['company'] = $_POST['aliasName'];//商家简称
            $post_data['phone'] = $_POST['contactPhone'];//联系电话
//            $post_data['realname'] = $_POST['contactName'];//联系人
            $count = M('cashier_regist')->get_one("mid = '".$_GET['mid']."' AND wechat <> ''", "*");
            if(empty($count)){
                $vo = M('cashier_regist')->insert($post_data, 1);
                if($vo){
                    $this->successTip('进件成功', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
                }
                else{
                    $this->errorTip('进件失败', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
                }
            }
            else{
                if($count['status'] == 1){
                    $this->errorTip('当前状态不能进行修改！', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
                }
                else{
                    $vo = M("cashier_regist") -> update($post_data,"mid = '".$_GET['mid']."' AND wechat <> ''");
                    if($vo){
                        $this->successTip('修改成功', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
                    }
                    else{
                        $this->errorTip('修改失败', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
                    }
                }
            }
            exit;
            $url = "https://gzwkzftest.cmbc.com.cn/payment-gate-web/gateway/api/backTransReq";
            $arrHashCode['signature'] = urlencode($this->sign($this->SinParamsToString($arrHashCode)));
            $post_data = $this->arrayToString($arrHashCode);
            $url .= '?' . $post_data;
            $string = $this->curlRequest($url);
            $arr = explode('&', $string);
            $str = $arr['5'];
            $code = str_replace('respCode=', '', $str);
            if ($code == 'P000') {
                $this->successTip('进件成功', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
            } else {
                $str = $arr['5'];
                //print_r($arr);die;
                $code = str_replace('respDesc=', '', $str);
                $this->errorTip($code);
            }
        } else {
            $merchant = M('cashier_merchants')->get_one($where, 'sub_merchant');
            $vo = M('cashier_regist')->get_one("mid = '".$_GET['mid']."' AND wechat <> ''", "*");
            $wechat = json_decode($vo['wechat'],true);
            $merchant['mid'] = $_GET['mid'];
            $category = M("cashier_wechat_category")-> select("id>0");
            $appid = "wx51b85efb4a2b5c58";//云极付APPID
            include $this->showTpl();
        }

    }

    public function cmbc_alipay()
    {
        $where['mid'] = $_GET['mid'];
        if (IS_POST) {
            $order_no = date('Ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 15);
            $_POST['chnlType'] = 'ALIPAY';
            unset($_POST['remark']);
//            dump($_POST);die;
            $arrHashCode = array(
                "requestNo" => $order_no,
                "version" => "V1.0",
                "transId" => "17",
                "merNo" => "850500053991253",
                "applyType" => "BANKSP",
                "applyCont" => json_encode($_POST)
            );
            $post_data['alipay'] = addslashes(json_encode($_POST,JSON_UNESCAPED_SLASHES));//提交的数据
            $post_data['status'] = 0;//待初审
            $post_data['mid'] = $_GET['mid'];//商户ID
            $post_data['company'] = $_POST['aliasName'];//商家简称
            $post_data['phone'] = $_POST['contactPhone'];//联系电话
//            $post_data['realname'] = $_POST['contactName'];//联系人
            $count = M('cashier_regist')->get_one("mid = '".$_GET['mid']."' AND alipay <> ''", "*");
            if(empty($count)){
                $vo = M('cashier_regist')->insert($post_data, 1);
                if($vo){
                    $this->successTip('进件成功', '?m=Agent&c=alipieces&a=grant&mid=' . $_GET['mid']);
                }
                else{
                    $this->errorTip('进件失败', '?m=Agent&c=alipieces&a=grant&mid=' . $_GET['mid']);
                }
            }
            else{
                if($count['status'] == 1){
                    $this->errorTip('当前状态不能进行修改！', '?m=Agent&c=alipieces&a=grant&mid=' . $_GET['mid']);
                }
                else{
                    $vo = M("cashier_regist") -> update($post_data,"mid = '".$_GET['mid']."' AND alipay <> ''");
                    if($vo){
                        $this->successTip('修改成功', '?m=Agent&c=alipieces&a=grant&mid=' . $_GET['mid']);
                    }
                    else{
                        $this->errorTip('修改失败', '?m=Agent&c=alipieces&a=grant&mid=' . $_GET['mid']);
                    }
                }
            }
            exit;
            $url = "https://gzwkzftest.cmbc.com.cn/payment-gate-web/gateway/api/backTransReq";
//             var_dump($_POST);
//             $data = $this->getSignString($arrHashCode);
//             var_dump($data);
//            $sign = $this->sign($data);

            $arrHashCode['signature'] = urlencode($this->sign($this->SinParamsToString($arrHashCode)));
            $post_data = $this->arrayToString($arrHashCode);
            $url .= '?' . $post_data;
            $string = $this->curlRequest($url);
            $resultData = [];
            parse_str($string, $resultData);
            if ($resultData['respCode'] === 'P000') {
                $this->successTip('进件成功', '?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid']);
            } else {
                $this->errorTip($resultData['respDesc']);
            }
//            var_dump(parse_ur)
//            var_dump($string);die;
        }
    }

    // 代理商>配置支付
    protected function getSignString($data)
    {
        ksort($data);
        $string = '';
        foreach ($data as $key => $val) {
            if (trim($val) == '') {
                unset($data[$key]);
            } else {
                $string .= sprintf('%s=%s&', $key, $val);
            }
        }
        return trim($string, '&');
    }

    public function config()
    {
        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
        }
        $mid = $getdata['mid'];
        $payConfig = $this->payConfigDb->get_one(array('mid' => $getdata['mid']), '*');
//        $rer['msg']=$payConfig;
//        dump($rer);exit;
        //查询商户进件信息
        $cashier_regist = M('cashier_regist')->get_one(array('mid' => $getdata['mid']), 'status');


        if ($payConfig) {
            if ($payConfig['configData']) {
                $payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                if (!isset($payConfig['configData']['weixin']))
                    $payConfig['configData']['weixin'] = array();
                if (!isset($payConfig['configData']['alipay']))
                    $payConfig['configData']['alipay'] = array();
            } else {
                $payConfig['configData'] = array('weixin' => array(), 'alipay' => array());
            }
        }


        if (IS_POST) {
            $data = $this->clear_html($_POST['data']);

            $dataType = array_keys($data);
            $dataType = $dataType[0];
            $pmid = $data[$dataType]['mid'];
//            $ee['msg']=serialize($data);
//            echo json_encode($ee);exit;
            unset($data[$dataType]['mid']);
            //查询商户进件信息
            $payConfig = M('cashier_payconfig')->get_one(array('mid' => $pmid), '*');

            if ($payConfig) {
                if ($payConfig['configData']) {
                    $payConfig['configData'] = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                    if (!isset($payConfig['configData']['weixin']))
                        $payConfig['configData']['weixin'] = array();
                    if (!isset($payConfig['configData']['alipay']))
                        $payConfig['configData']['alipay'] = array();
                } else {
                    $payConfig['configData'] = array('weixin' => array(), 'alipay' => array());
                }
            }

            if ($payConfig) {

                // $dataType = array_keys($data);

                // $dataType = $dataType[0];

                if (isset($payConfig['configData'][$dataType])) {
                    $configData = array_merge($payConfig['configData'][$dataType], $data[$dataType]);

                } else {
                    $configData = $data[$dataType];
                }
                $payConfig['configData'][$dataType] = $configData;

                $tmppayConfig = array();
                isset($payConfig['configData']['weixin']) && $tmppayConfig['weixin'] = $payConfig['configData']['weixin'];
                isset($payConfig['configData']['alipay']) && $tmppayConfig['alipay'] = $payConfig['configData']['alipay'];
                $payConfig['configData'] = $tmppayConfig;
                $ee['msg']=serialize($payConfig['configData']);
//                echo json_encode($ee);exit();
//                unset($tmppayConfig);
                $payConfig['configData'] = serialize($payConfig['configData']);
                $payConfig['wxsubmchid'] = $data['weixin']['mchid'];
                $vo = M('cashier_payconfig')->update($payConfig, "mid=" . $pmid);

            } else {
                $payConfig = array('mid' => $pmid, 'isOpen' => 1, 'configData' => serialize($data), 'wxsubmchid' => $data['weixin']['mchid']);
                $vo = M('cashier_payconfig')->insert($payConfig, 1);
            }
            if ($vo) {

                // 修改商户表 是否开启
                if ($dataType == 'weixin') {
                    M('cashier_merchants')->update(array('isopenwxpay' => 1), 'mid=' . $pmid);
                } elseif ($dataType == 'alipay') {
                    M('cashier_merchants')->update(array('isopenalipay' => 1), 'mid=' . $pmid);
                }

                $return['status'] = 1;
                $return['msg'] = '支付配置修改成功';
            } else {
                $return['status'] = 0;
                $return['msg'] = '支付配置修改失败';
            }
            delCacheByMid($pmid);
            echo json_encode($return);
            exit;
        }
        $mer = M('cashier_merchants')->get_one('mid='.$mid,'mtype');
        $mtype = $mer['mtype'];
        if($mtype == 1){
            $state1 = M('cashier_regist')->get_one("mid='$mid' AND contactor <> ''",'status');//微信状态
            $state2 = $state1;//支付宝状态
        }
        else{
            $state1 = M('cashier_regist')->get_one("mid='$mid' AND wechat <> ''",'status');//微信状态
            $state2 = M('cashier_regist')->get_one("mid='$mid' AND alipay <> ''",'status');//支付宝状态
        }
        include $this->showTpl();
    }

    public function pem_upload()
    {
        if (IS_POST) {
            if (!empty($_FILES)) {


                $return = $this->oldUploadFile('pem', $_GET['mid']);

                if ($return['error'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $return['data']));
                } else {
                    $filesinfo = $return['data']['0'];
                    $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
                }
            }
            $this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
        }
    }


    //进件
    public function go2Regeist()
    {
        if (!IS_POST) {
            $where['mid'] = $_GET['mid'];
            $merchant = M('cashier_merchants')->get_one($where, '*');
            if ($merchant['sub_merchant'] == 1 && $merchant['mtype'] != 1) {
                $url = 'https://' . $_SERVER['HTTP_HOST'] . '/merchants.php?m=Agent&c=merchant&a=cmbc_pieces&mid=' . $_GET['mid'];
                header('location:' . $url);
                die;
            }
        }
        if (IS_POST) {
            $postdata = $this->clear_html($_POST);
            if (!$postdata['mid']) {
                $this->errorTip('不存在的商户');
            }
            $saveData['mid'] = $postdata['mid'];

            if (trim($postdata['contactor']) == '') {

                $this->errorTip('联系人不能为空');
            }
            $saveData['contactor'] = $postdata['contactor'];

            if (!preg_match("/^1[345678]\d{9}$/", $postdata['tel'])) {

                $this->errorTip('不是有效的手机号');
            }
            $saveData['tel'] = $postdata['tel'];

            if (!preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $postdata['email'])) {
                $this->errorTip('邮箱格式不对');
            }
            $saveData['email'] = $postdata['email'];

            if ($postdata['shortname'] == '') {

                $this->errorTip('公司简称不能为空');
            }
            $saveData['shortname'] = $postdata['shortname'];

            if (empty($postdata['tradelevel1'])) {
                $this->errorTip('请选择行业');
            }
            $saveData['mclevel1'] = $postdata['tradelevel1'];
            $arr1 = $this->getRegData($saveData['mclevel1']);
            $saveData['level1'] = $arr1['name'];

            if (empty($postdata['tradelevel2'])) {
                $this->errorTip('请选择主体');
            }
            $saveData['mclevel2'] = $postdata['tradelevel2'];
            $arr2 = $this->getRegData($saveData['mclevel2']);
            $saveData['level2'] = $arr2['name'];
            $saveData['mclevel3'] = $postdata['tradelevel3'];
            $arr3 = $this->getRegData($saveData['mclevel3']);


            $saveData['level3'] = $arr3['name'];
            $saveData['rates'] = $arr3['rate'];
            $saveData['cycle'] = $arr3['settlement'];

            if (!empty($postdata['website'])) {
                $saveData['website'] = $postdata['website'];
            }


            if (!empty($postdata['phone'])) {
                $saveData['phone'] = $postdata['phone'];
            }


            //《建设用地规划许可证》
            if ($postdata['constructLeanIDList']) {

                $saveData['constructLeanID'] = json_encode($postdata['constructLeanIDList']);
            }
            // 《建设工程规划许可证》
            if ($postdata['constructLeanList']) {
                $saveData['constructLean'] = json_encode($postdata['constructLeanList']);
            }

            // 《建筑工程开工许可证》
            if ($postdata['cunstructIDList']) {
                $saveData['cunstructID'] = json_encode($postdata['cunstructIDList']);
            }

            // 《国有土地使用证》
            if ($postdata['landUseIdList']) {
                $saveData['landUseId'] = json_encode($postdata['landUseIdList']);
            }

            // 《商品房预售许可证》
            if ($postdata['allowIDList']) {
                $saveData['allowID'] = json_encode($postdata['allowIDList']);
            }

            // 《法人登记证书》
            if ($postdata['contactList']) {

                $saveData['contact'] = json_encode($postdata['contactList']);
            }


            // 《组织机构代码证》
            if ($postdata['groupIDList']) {
                $saveData['groupID'] = json_encode($postdata['groupIDList']);
            }

            // 特殊资质
            if ($postdata['specialList']) {
                $saveData['special'] = json_encode($postdata['specialList']);
            }


            // 商品售卖简述
            if ($postdata['dealdesc']) {
                $saveData['dealdesc'] = $postdata['dealdesc'];
            }

            // 补充材料
            if ($postdata['annuxesList']) {
                $saveData['annexs'] = json_encode($postdata['annuxesList']);
            }
            //判断  添加
            // 判断是不是提交过
            $check = M('cashier_regist')->get_one(array('mid' => $postdata['mid'],"contactor"=>array("neq","")), '*');

            if ($check) {

                //修改

                $result = M('cashier_regist')->update($saveData, array('id' => $postdata['id']));
                //修改成功跳转
                if ($result) {
                    $res = M('cashier_regist')->get_one(array('mid' => $saveData['mid']), '*');

                    if (!isset($res['company']) || !isset($res['bank'])) {
                        header('location:?m=Agent&c=merchant&a=regMerchantInfo&mid=' . $saveData['mid']);
                    } else {
                        header('location:?m=Agent&c=merchant&a=showReg&mid=' . $saveData['mid']);
                        exit();
                    }


                }

            } else {//添加

                $result = M('cashier_regist')->insert($saveData, true);
            }

            if ($result) {
                header('location:?m=Agent&c=merchant&a=regMerchantInfo&mid=' . $saveData['mid']);
            }
            $this->successTip('数据保存成功');
        }
        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
            if($merchant['mtype'] == "1"){//特约
                $status = M('cashier_regist')->get_var(array('mid' => $getdata['mid'],'contactor'=>array("neq","")), 'status');
            }
            else{//银行
                $status = M('cashier_regist')->get_var(array('mid' => $getdata['mid'],'weixin'=>array("neq"=>'')), 'status');
            }
            $list = M('cashier_pieces')->get_all('name,id', '', array('fid' => 0));
            if ($status) {
                $status = isset($status) ? $status : 0;
            }

            //判断是否为修改
            if (isset($getdata['type'])) {
                $reg = M('cashier_regist')->get_one(array('mid' => $getdata['mid']), '*');
                //补充材料图片
                if ($reg['annexs']) {
                    $reg['annexs'] = json_decode($reg['annexs'], true);
                }
                //特殊资质
                if ($reg['special']) {
                    $reg['special'] = json_decode($reg['special'], true);
                }
                //组织机构代码证
                if ($reg['groupID']) {
                    $reg['groupID'] = json_decode($reg['groupID'], true);
                }
                //法人登记证书
                if ($reg['contact']) {
                    $reg['contact'] = json_decode($reg['contact'], true);
                }
                //商品房预售许可证
                if ($reg['allowID']) {
                    $reg['allowID'] = json_decode($reg['allowID'], true);
                }
                //国有土地使用证
                if ($reg['landUseId']) {
                    $reg['landUseId'] = json_decode($reg['landUseId'], true);
                }
                //建筑工程开工许可证
                if ($reg['cunstructID']) {
                    $reg['cunstructID'] = json_decode($reg['cunstructID'], true);
                }
                //建设工程规划许可证
                if ($reg['constructLean']) {
                    $reg['constructLean'] = json_decode($reg['constructLean'], true);
                }
                //建设用地规划许可证
                if ($reg['constructLeanID']) {
                    $reg['constructLeanID'] = json_decode($reg['constructLeanID'], true);
                }
                //查询行政表
                $pieces_one = M('cashier_pieces')->select(array('fid' => 0), '*');//查询一级
                $pieces_two = M('cashier_pieces')->select(array('fid' => $reg['mclevel1']), '*');//查询二级
                $pieces_three = M('cashier_pieces')->select(array('fid' => $reg['mclevel2']), '*');//查询三级
                //查询显示内容
                $reg_list = M('cashier_pieces')->get_one(array('id' => $reg['mclevel3']), '*');
            } else {
                if (($status == '1' || $status == '2' || $status == '0' || $status == '3' || $status == '4') && (isset($status))) {
                    header('location:?m=Agent&c=merchant&a=showReg&mid=' . $getdata['mid']);
                    exit;
                }
            }
            include $this->showTpl();
        }


    }


    public function getRegData($id)
    {
        $arr = M('cashier_pieces')->get_one(array('id' => $id), '*');
        return $arr;
    }


    public function regMerchantInfo()
    {

        if (IS_POST) {
            $postdata = $this->clear_html($_POST);

            if (empty($postdata['mid'])) {
                $this->errorTip('不存在的商户');
            }

            $saveData['mid'] = $postdata['mid'];
            if (empty($postdata['company'])) {
                $this->errorTip('请填写商户名称');
            }
            $saveData['company'] = $postdata['company'];

            if (empty($postdata['address'])) {
                $this->errorTip('请填写注册地址');
            }
            $saveData['address'] = $postdata['address'];

            if (empty($postdata['icence'])) {
                $this->errorTip('请填写营业执照注册号');
            }
            $saveData['icence'] = $postdata['icence'];

            if (empty($postdata['mcarea'])) {
                $this->errorTip('请填写经营范围');
            }
            $saveData['mcarea'] = $postdata['mcarea'];

            if (empty($postdata['starttime'])) {
                $this->errorTip('缺少营业期限开始时间');
            }


            $saveData['starttime'] = $postdata['starttime'];

            if (empty($postdata['perd'])) {
                if (empty($postdata['endtime'])) {
                    $this->errorTip('缺少营业期限结束时间');
                }
                $saveData['endtime'] = $postdata['endtime'];
            } else {
                $saveData['endtime'] = '长期';
            }
            if (!$_GET['type']) {

            }
            if (empty($postdata['licencephotoList'])) {
                $this->errorTip('请上传营业执照');
            }
            $saveData['licencephotoList'] = json_encode($postdata['licencephotoList']);


            if (empty($postdata['occode'])) {
                $this->errorTip('请填写组织机构代码');
            }
            $saveData['occode'] = $postdata['occode'];


            if (empty($postdata['validatestart'])) {
                $this->errorTip('请填写开始时间');
            }
            $saveData['validatestart'] = $postdata['validatestart'];


            if (empty($postdata['validate'])) {
                if (empty($postdata['validateend'])) {
                    $this->errorTip('请填写结束时间');
                }
                $saveData['validateend'] = $postdata['validateend'];
            } else {
                $saveData['validateend'] = '长期';
            }

            if (empty($postdata['occodephotoList'])) {
                $this->errorTip('上传组织证件');
            }
            $saveData['occodephotoList'] = json_encode($postdata['occodephotoList']);


            if (empty($postdata['idtype'])) {
                $this->errorTip('请填写经办人');
            }
            $saveData['idtype'] = $postdata['idtype'];


            if (empty($postdata['idname'])) {
                $this->errorTip('请填写证件持有人姓名');
            }
            $saveData['idname'] = $postdata['idname'];


            if (empty($postdata['idcard'])) {
                $this->errorTip('请填写身份证');
            }
            $saveData['idcard'] = $postdata['idcard'];

            if (empty($postdata['idphotoAList'])) {
                $this->errorTip('请上传身份证正面');
            }
            $saveData['idphotoAList'] = json_encode($postdata['idphotoAList']);

            if (empty($postdata['idphotoBList'])) {
                $this->errorTip('请上传身份证反面');
            }
            $saveData['idphotoBList'] = json_encode($postdata['idphotoBList']);


            if (empty($postdata['idstart'])) {
                $this->errorTip('身份证号码有效期不完整');
            }
            $saveData['idstart'] = $postdata['idstart'];

            if (empty($postdata['idlong'])) {
                if (empty($postdata['idend'])) {
                    $this->errorTip('身份证号码有效期不完整');
                }
                $saveData['idend'] = $postdata['idend'];

            } else {
                $saveData['idend'] = '长期';
            }
            if (empty($postdata['idnum'])) {
                $this->errorTip('请填写身份证');
            }

            $saveData['idnum'] = $postdata['idnum'];


            $result = M('cashier_regist')->update($saveData, array('mid' => $postdata['mid']));

            if ($result) {
                if ($postdata['type']) {
                    header('location:?m=Agent&c=merchant&a=showReg&mid=' . $saveData['mid']);
                    exit();
                } else {
                    header('location:?m=Agent&c=merchant&a=examine&mid=' . $saveData['mid']);
                }

            }


        } else if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
            $this->check($getdata['mid']);
            if ($getdata['type']) {
                $reg = M('cashier_regist')->get_one(array('mid' => $getdata['mid']), '*');
                if ($reg['annexs']) {
                    $reg['annexs'] = json_decode($reg['annexs'], true);
                }
                //特殊资质
                if ($reg['special']) {
                    $reg['special'] = json_decode($reg['special'], true);
                }
                //组织机构代码证
                if ($reg['groupID']) {
                    $reg['groupID'] = json_decode($reg['groupID'], true);
                }
                //法人登记证书
                if ($reg['contact']) {
                    $reg['contact'] = json_decode($reg['contact'], true);
                }
                //商品房预售许可证
                if ($reg['allowID']) {
                    $reg['allowID'] = json_decode($reg['allowID'], true);
                }
                //国有土地使用证
                if ($reg['landUseId']) {
                    $reg['landUseId'] = json_decode($reg['landUseId'], true);
                }
                //建筑工程开工许可证
                if ($reg['cunstructID']) {
                    $reg['cunstructID'] = json_decode($reg['cunstructID'], true);
                }
                //建设工程规划许可证
                if ($reg['constructLean']) {
                    $reg['constructLean'] = json_decode($reg['constructLean'], true);
                }
                //建设用地规划许可证
                if ($reg['constructLeanID']) {
                    $reg['constructLeanID'] = json_decode($reg['constructLeanID'], true);
                }

                if ($reg['licencephotoList']) {
                    $reg['licencephotoList'] = json_decode($reg['licencephotoList'], true);
                }
                if ($reg['occodephotoList']) {
                    $reg['occodephotoList'] = json_decode($reg['occodephotoList'], true);
                }

                if ($reg['idphotoAList']) {
                    $reg['idphotoAList'] = json_decode($reg['idphotoAList'], true);
                }
                if ($reg['idphotoBList']) {
                    $reg['idphotoBList'] = json_decode($reg['idphotoBList'], true);
                }
            }
            include $this->showTpl();
        }


    }


    // 检测是否直接等过去
    public function check($mid)
    {

        $exist = M('cashier_regist')->get_one(array('mid' => $mid));

        if (!$exist) {
            $this->errorTip('', '?m=Agent&c=merchant&a=go2Regeist&mid=' . $mid);
        }

    }

    public function examine()
    {

        if (IS_POST) {
            $postdata = $this->clear_html($_POST);
            $saveData['mid'] = $postdata['mid'];

            // 账户类型

            if (empty($postdata['accountType'])) {

                $this->errorTip('请填写银行账户类型');

            }
            $saveData['accountType'] = $postdata['accountType'];

            // 账户名
            if (empty($postdata['account'])) {

                $this->errorTip('请填写账户名称');
            }
            $saveData['account'] = $postdata['account'];

            // 开户银行
            if (empty($postdata['bank'])) {
                $this->errorTip('请填写开户银行');
            }
            $saveData['bank'] = $postdata['bank'];

            //  账户城市
            if (empty($postdata['bankaddress'])) {
                $this->errorTip('请填写账户名称');
            }

            $saveData['bankaddress'] = $postdata['bankaddress'];
            //  银行账号
            if (empty($postdata['accountid'])) {

                $this->errorTip('请填写银行账号');

            }
            $saveData['accountid'] = $postdata['accountid'];

            //  银行开户支行
            if (empty($postdata['bank_branch'])) {

                $this->errorTip('请填写银行开户支行');

            }
            $saveData['bank_branch'] = $postdata['bank_branch'];

            if (!$postdata['type']) {
                $saveData['status'] = 0;
            }
            $result = M('cashier_regist')->update($saveData, array('mid' => $postdata['mid']));
            if ($result) {
                if ($postdata['type']) {
                    header('location:?m=Agent&c=merchant&a=showReg&mid=' . $saveData['mid']);
                    exit();
                } else {
                    header('location:?m=Agent&c=merchant&a=showReg&mid=' . $saveData['mid']);
                    exit();
                }

            }
        }

        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
            $rinfo = M('cashier_regist')->get_one(array('mid' => $getdata['mid']), 'mclevel1,company,contactor');
            $accountType = $rinfo['mclevel1'] == 2 ? '个人账户' : '对公账户';
            $account = $rinfo['mclevel1'] == 2 ? $rinfo['contactor'] : $rinfo['company'];

            if ($_GET['type']) {
                $reg = M('cashier_regist')->get_one(array('mid' => $getdata['mid']), '*');
            }

            $this->check($getdata['mid']);
        }
        include $this->showTpl();

    }

    public function back2reg()
    {

        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);

            $this->check($getdata['mid']);

            $merchant = M('cashier_merchants')->get_var(array('mid' => $getdata['mid']), 'company');

            $reg = M('cashier_regist')->get_one(array('mid' => $getdata['mid']));
            $type = M('cashier_pieces')->get_var(array('id' => $reg['mclevel3']), 'type');

            $lvl['zero'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel1']), 'name');
            $lvl['fir'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel1']), 'name');
            $lvl['sec'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel2']), 'name');
            $lvl['thr'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel3']), 'name');
        }
        include $this->showTpl();
    }

    public function showReg()
    {

        if (!empty($_GET['mid'])) {
            $getdata = $this->clear_html($_GET);
            $this->check($getdata['mid']);
            $merchant = M('cashier_merchants')->get_var(array('mid' => $getdata['mid']), 'company');
            $mid = $getdata['mid'];
            $reg = M('cashier_regist')->get_one("mid='$mid' AND contactor <> ''","*");
            $type = M('cashier_pieces')->get_var(array('id' => $reg['mclevel3']), 'type');
            $lvl['fir'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel1']), 'name');
            $lvl['sec'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel2']), 'name');
            $lvl['thr'] = M('cashier_pieces')->get_var(array('id' => $reg['mclevel3']), 'name');


        }
        include $this->showTpl();
    }

    // // 检验进件到哪一步
    // public function checkTurn ($mid) {

    //     if(!$mid) $this->errorTip('不存在的商户');
    //     $flag = M('cashier')->get_var(array('mid'=>$mid),'flag');
    //     switch ($flag) {
    //         case '0': $str ='go2Regeist' ;break;
    //         case '1': $str ='regMerchantInfo' ;break;
    //         case '2': $str ='examine' ;break;
    //         case '3': $str ='showReg' ;break;
    //         default:               
    //             break;
    //     }

    //     $url = 'location:?m=Agent&c=merchant&a='.$str.'&mid='.$mid;
    //     header($url);
    // }


    // 获取第二级
    public function getSecondLevel()
    {

        $postdata = $this->clear_html($_POST);

        $list = M('cashier_pieces')
            ->select(array('fid' => $postdata['id']), 'name,id');
        exit(json_encode(array('data' => $list)));

    }


    // 获取第三级
    public function getThirdLevel()
    {

        $postdata = $this->clear_html($_POST);

        $list = M('cashier_pieces')
            ->select(array('fid' => $postdata['id']), 'name,id');
        exit(json_encode(array('data' => $list)));


    }

    public function getFourthlevel()
    {
        if (!IS_POST) return false;
        $postdata = $this->clear_html($_POST);

        $list = M('cashier_pieces')->select(array('id' => $postdata['id']), 'type,rate,settlement');

        $this->dexit($list);
        exit;
    }


    public function uploadImg()
    {

        if (IS_POST) {
            if (!empty($_FILES)) {

                $return = $this->oldUploadFile('png', $_GET['mid']);

                if ($return['error'] > 0) {
                    $this->dexit(array('error' => 1, 'msg' => $return['data']));
                } else {
                    $filesinfo = $return['data']['0'];
                    $this->dexit(array('error' => 0, 'msg' => 'OK', 'fileUrl' => $return['imgurl'] . $filesinfo['savename'], 'originalfilename' => $filesinfo['name'], 'fileSize' => $filesinfo['size']));
                }
            }
            $this->dexit(array('error' => 1, 'msg' => '没有上传文件！'));
        }

    }

    // 获取业务员名
    public function getSalerName($id)
    {
        $name = M('cashier_salesmans')->get_one(array('id' => $id), 'username');
        return $name['username'];
    }

    public function data2Excel()
    {
        //查询数据
        $merchants = M('cashier_merchants')->select(array('aid' => $this->aid));
        $agent = M('cashier_agent')->get_one(array('aid' => $this->aid), 'uname');
        //组装数据Excel导出数据
        $data = array();
        foreach ($merchants as $key => $val) {
            $data[$key]['mid'] = ' ' . $val['mid'] . ' ';//商户id
            $data[$key]['username'] = $val['username'];//登录帐号
            $data[$key]['company'] = $val['company'];//商户名称
            $data[$key]['regTime'] = date('Y-m-d H:i:s', $val['regTime']);//添加时间
            $data[$key]['comefrom'] = $this->getSalerName($val['sid']);//来源
            //判断支付类型
            if ($val['mtype'] == '2') {
                $data[$key]['ispay'] = '平台二清商户 ';
                continue;
            }
            //判断微信是否开通
            if ($val['isopenwxpay'] == '1') {
                $data[$key]['ispay'] = '微信支付(已开通) ';
            } else {
                $data[$key]['ispay'] = '微信支付(未开通) ';
            }
            //判断支付宝是否开通
            if ($val['isopenalipay'] == '1') {
                $data[$key]['ispay'] .= '支付宝支付(已开通) ';
            } else {
                $data[$key]['ispay'] .= '支付宝支付(未开通) ';
            }
        }

        $title = array('商户ID', '登录帐号', '商户名', '添加时间', '商户来源', '支付配置');
        $filename = '代理商:【' . $agent['uname'] . '】下的所有商户.xls';
        $this->ExportTable($data, $title, $filename);

    }

    /**
     * 重新提交进件
     */
    public function again()
    {
        $postdata = $this->clear_html($_GET);

        $regist = M('cashier_regist')->update(array('status' => 0, 'comments' => ''), array('mid' => $postdata['mid']));
        if ($regist) {
            $this->successTip('提交成功');
        } else {
            $this->errorTip('重新提交失败');
        }

    }


}

?>
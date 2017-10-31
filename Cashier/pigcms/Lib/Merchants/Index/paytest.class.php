<?php
bpBase::loadAppClass('base', '', 0);

class paytest_controller extends base_controller
{
    public $is_wexin_browser = false;

    public $user_browser = 'other';

    public function __construct()
    {
        parent::__construct();
        bpBase::loadOrg('checkFunc');
        $checkFunc = new checkFunc();

        if (!function_exists('dsbig3joishdgfhg798rqw4fqnkhffq')) {
            exit('error-4');
        }


        $checkFunc->cfdwdgfds3skgfds3szsd3idsj();
        $session_storage = getSessionStorageType();
        bpBase::loadSysClass($session_storage);

        if (strpos($_SERVER['HTTP_USER_AGENT'], 'icroMessenger') !== false) {
            $this->is_wexin_browser = true;
        }

        // 判断用户浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'icroMessenger') !== false) {
            $this->user_browser = 'wechat';
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            $this->user_browser = 'alipay';
        }
    }
    public function alitradepaytest()
    {
        //var_dump($_POST);
        $mid = 22;
        $eid = 5;
        $storeid = 80;
        $paytype = "alipay";
        $goodsprice = 0.02;
        $goodsname = "收款";

        // 检查参数
        // 检查买家
        if (empty($_SESSION['my_Cashier_aliuserid'])) {
            die('请使用支付宝进行扫码付款');
        }

        // 检查商户、雇员、店铺参数
        if (empty($mid) || empty($eid) || empty($storeid)) {
            die('参数缺失，请联系管理员');
        }

        $merchant = M('cashier_merchants')->get_one('mid=' . $mid, '*');
        $employee = M('cashier_employee')->get_one('eid=' . $eid, '*');
        $store = M('cashier_stores')->get_one('id=' . $storeid, '*');
        if (empty($merchant) || empty($employee) || empty($store)) {
            die('参数错误，请联系管理员');
        }

        // 检查商品价格
        if (empty($goodsprice) || !is_numeric($goodsprice) || $goodsprice <= 0) {
            die('付款金额至少为0.01元');
        }

        if (empty($goodsname)) {
            $goodsname = '收款';
        }

        // 获取当前商户支付宝授权token
        $appauthtoken = '';
        if ($merchant['mtype'] == 1 && $mid > 1) {
            $mconf = M('cashier_payconfig')->getalipayConf($mid);
            if (empty($mconf) || empty($mconf['appauthtoken'])) {
                die('当前商家还未开通支付宝支付，请联系商家');
            }

            $appauthtoken = $mconf['appauthtoken'];
        }

        // 获取云极付支付宝支付配置
        $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
        $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));
        bpBase::loadOrg('alipayHelper');
        $alipayhelper = new alipayHelper($payconfig_data, $appauthtoken);

        // 生成订单
        $mchtype = 0;
        $pf_mid = 0;
        if (isset($alipayConf['pf_mid']) && (0 < $alipayConf['pf_mid'])) {
            $pf_mid = $alipayConf['pf_mid'];
            $mchtype = 2;
        }

        $orderinfo = $this->add_aliorder($_POST, $pf_mid, $mchtype);
        // 创建收款订单（测试）
        $order = array(
            'orderid' => $orderinfo['order_id'],
            'amount' => $goodsprice,
            'subject' => $goodsname,
            'body' => $store['business_name'] . ' ' . $store['branch_name'],
            'buyerid' => $_SESSION['my_Cashier_aliuserid'],
            'operatorid' => $employee['account'],
            'storeid' => $store['id'],
            'notifyUrl'=>'http://pay.yunjifu.net/merchants.php?m=Index&c=paytest&a=alitradepaynotify&merid=' . $mid . '&ordid='.$orderinfo['order_id'],
            'pid' => $payconfig_data['alipay']['pid']
        );

        var_dump($order);
        $result = $alipayhelper->createTrade($order);

        if (!$result['success']) {
            die('收款失败，错误码：' . $result['errcode'] . '，错误信息：' . $result['errmsg']);
        } else {
            // echo '收款单创建成功，trade_no：' . $result['data'];
            $tradeno = $result['data'];
            $orderid = $order['orderid'];
            $goodsprice = $order['amount'];
            include $this->showTpl();
        }
    }

    // 支付宝收款异步通知
    public function alitradepaynotify() {
        file_put_contents('./alipay.txt',json_encode($_POST));
        file_put_contents('./alipay1.txt',json_encode($_GET));
    }



    public function alitraderesult()
    {
        $result = array(
            'success' => false,
            'errcode' => '',
            'errmsg' => '',
            'data' => ''
        );

        $orderid = $_GET['orderid'];
        if (empty($orderid)) {
            $result['errmsg'] = '订单编号不能为空';
            die(json_encode($result));
        }

        // 查询订单
        $order = M('cashier_order')->getOneOrder(array('order_id' => $orderid));

        if (empty($order)) {
            $result['errmsg'] = '订单不存在';
            die(json_encode($result));
        }

       /*
	   
	   */

        $mid = $order['mid'];

        // 查询订单所属商家
        $merchant = M('cashier_merchants')->get_one('mid=' . $mid, '*');

        // 查询订单所属商家支付配置
        $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
        $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));

        // 获取当前商户支付宝授权token
        $appauthtoken = '';
        if ($merchant['mtype'] == 1 && $order['mid'] > 1) {
            $mconf = M('cashier_payconfig')->getalipayConf($mid);
            if (empty($mconf) || empty($mconf['appauthtoken'])) {
                die('当前商家还未开通支付宝支付，请联系商家');
            }

            $appauthtoken = $mconf['appauthtoken'];
        }

        bpBase::loadOrg('alipayHelpertest');
        $alipayhelper = new alipayHelper($payconfig_data, $appauthtoken);
        $result = $alipayhelper->getTradeResult($orderid);
		var_dump($result);
		exit;
        if($result['data']['trade_status'] == "TRADE_SUCCESS"){
            var_dump($result);
            //echo $orderid;
            //echo "<br />";
        }
//            var_dump($result);
//            echo $result['data']['order_id'].'<br />';

        die;
        if (!$result['success']) {
            die(json_encode($result,true));

        }
        // 如果支付宝返回结果，则更新本地订单
        if ($result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_FINISHED') {

            if($result['data']['trade_status'] == 'TRADE_CLOSE')
                die;
            $state = $result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_FINISHED' ? 1 : -1;
            $paytime = strtotime($result['data']['send_pay_date']);
            $updateData = array('ispay' => 1, 'state' => $state, 'openid' => $result['data']['buyer_user_id'], 'paytime' => $paytime, 'transaction_id' => $result['data']['trade_no']);
            $where = array(
                'order_id' => $orderid
            );
            $order_update = M('cashier_order')->update($updateData, $where);
            
        }
//        else{
//			$state = $result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_FINISHED' ? 1 : -1;
//            $paytime = time();
//            $updateData = array('ispay' => 0);
//            $where = array(
//                'order_id' => $orderid
//            );
//            $order_update = M('cashier_order')->update($updateData, $where);
//		}

        $result['data'] = $result['data']['trade_status'];
        die(json_encode($result));
    }


    public function add_aliorder($datas, $pmid = 0, $mchtype = 0)
    {

        //判断是否为二清商户
        $merchants = M('cashier_merchants')->get_One(array('mid' => $datas['mid']), '*');
        $wxrebate = M('cashier_wxrebate')->select(array('is_pay' => 1, 'type' => 2), 'rebate');

        if ($merchants['mtype'] == '1') {
            $pmid = $this->mid;
            $mchtype = 1;
            $wx_pay = $wxrebate[0]['rebate'] / 100;//微信费率配置
        } else if ($merchants['mtype'] == '2') {
            $pmid = 1;
            $mchtype = 2;
            $wx_pay = $wxrebate[1]['rebate'] / 100;//微信费率配置
        }


        //计算利率
        //商家实收金额
        $merchants_income = $datas['goods_price'];

        //计算业务员佣金
        $salesmans = M('cashier_salesmans')->get_One(array('id' => $merchants['sid']), '*');
        $agent = M('cashier_agent')->get_One(array('aid' => $merchants['aid']), '*');
        $wxrebate = M('cashier_wxrebate')->get_one(array('type' => 2));


        //$salesmans_income = $datas['goods_price'] * ($merchants['alicommission'] - $wxrebate['rebate']) * $agent['commission'] * $salesmans['commission'];
        $salesmans_income = $datas['goods_price'] * $wx_pay * $agent['commission'] * $salesmans['commission'];
        $salesmans_income_is_null = $this->sctonum($salesmans_income);//将科学计算法转为实体
        if ($salesmans_income_is_null) {
            $salesmans_income = $salesmans_income_is_null;
        }


        //计算代理商佣金

        //$agent_income = $datas['goods_price'] * ($merchants['alicommission'] - $wxrebate['rebate']) * $agent['commission'];
        $agent_income = $datas['goods_price'] * $wx_pay * $agent['commission'];
        $agent_income_is_null = $this->sctonum($agent_income);//将科学计算法转为实体
        if ($agent_income_is_null) {
            $agent_income = $agent_income_is_null;
        }
        //收入
        $data['income'] = round($merchants_income, 2);
        $data['salesmans_price'] = round($salesmans_income, 2);
        $data['agent_price'] = round($agent_income, 2);
        $data['mid'] = $datas['mid'];
        $data['pmid'] = $pmid;
        $data['mchtype'] = $mchtype;
        $data['goods_id'] = 1;
        $data['pay_way'] = trim($datas['paytype']);
        $data['pay_type'] = 'tradepay';
        $data['order_id'] = '11' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
        $data['goods_type'] = 'unlimit';
        $data['goods_name'] = htmlspecialchars(trim($datas['goods_name']), ENT_QUOTES);
        $data['goods_describe'] = '支付宝统一收款支付';
        $data['goods_price'] = $datas['goods_price'];
        $data['openid'] = '';
        $data['add_time'] = time();
        $data['truename'] = ((isset($datas['tname']) ? htmlspecialchars(trim($datas['tname']), ENT_QUOTES) : ''));
        isset($datas['eid']) && ($data['eid'] = intval($datas['eid']));
        isset($datas['storeid']) && ($data[' storeid'] = intval($datas['storeid']));


        $orderid = M('cashier_order')->insert($data, true);

        if ($orderid) {
            $data['id'] = $orderid;
            return $data;
        }


        return false;
    }

    public function sctonum($num, $double = 5)
    {
        if (false !== stripos($num, "e")) {
            $a = explode("e", strtolower($num));
            return bcmul($a[0], bcpow(10, $a[1], $double), $double);
        }
    }

    public function test()
    {
//        $configData = 'a:1:{s:6:"weixin";a:2:{s:5:"appid";s:0:"";s:9:"appSecret";s:0:"";}}';
//        var_dump(unserialize(htmlspecialchars_decode($configData, ENT_QUOTES)));
//        $wx_user = M('cashier_payconfig')->getwxuserConf(4);
//        var_dump($wx_user);
        //$alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
        //$payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));
        //var_dump($payconfig_data);
        // echo $this->user_browser;
        $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
        $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));

        bpBase::loadOrg('alipayHelper');
        $alipayhelper = new alipayHelper($payconfig_data, '201702BB01c87c025c87428cbe975696f502bX25');

        // 获取支付宝用户userId
        if (empty($_SESSION['my_Cashier_aliuserid'])) {
            $redirecturl = urlencode($this->SiteUrl . '/' . $_SERVER['REQUEST_URI']);
            $result = $alipayhelper->getUserId($redirecturl);
            if (!$result['success']) {
                die($result['errmsg']);
            } else {
                $_SESSION['my_Cashier_aliuserid'] = $result['data'];
            }
        }

        // 创建收款订单（测试）
        $order = array(
            'orderid' => '11' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2),
            'amount' => 0.01,
            'subject' => '支付宝收款测试',
            'body' => '支付宝收款测试说明',
            'buyerid' => $_SESSION['my_Cashier_aliuserid'],
            'operatorid' => 'OP_001',
            'storeid' => 'ST_001',
            'pid' => '2088121729754596'
        );

        $result = $alipayhelper->createTrade($order);
        if (!$result['success']) {
            die('支付失败，错误码：' . $result['errcode'] . '，错误信息：' . $result['errmsg']);
        } else {
            // echo '收款单创建成功，trade_no：' . $result['data'];
            $tradeno = $result['data'];
            $orderid = $order['orderid'];
            include $this->showTpl();
        }
    }

    public function getTradeResult()
    {
        $orderid = $_GET['orderid'];
        $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
        $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));

        bpBase::loadOrg('alipayHelper');
        $alipayhelper = new alipayHelper($payconfig_data, '201612BB3935ad8b8a4d471984d75d4980676X18');
        $result = $alipayhelper->getTradeResult($orderid);
        var_dump($result);
    }

    public function test2() {
        $alipayConf = M('cashier_payconfig')->getalipayConf(1);
        var_dump($alipayConf['appauthtoken']);
    }

    public function test_zp(){
        $sqlStr='select id,order_id,pay_way from cqcjcm_cashier_order where ispay = 0 and pay_way="alipay" and add_time >= '.strtotime("2017-03-15"). ' and add_time <=' . strtotime("2017-03-16") ;
//        echo $sqlStr;
        $notPay = M('cashier_order')->selectBySql($sqlStr);
        //$notPay = json_encode($notPay);
//        include_once $this->showTpl();

//        echo "<pre>";
//        var_dump($notPay);
//        echo "</pre>";
//        die;
        foreach($notPay as $i){
            $tmp = file_get_contents("http://pay.yunjifu.net/merchants.php?m=Index&c=paytest&a=alitraderesult&orderid=".$i['order_id']);
            echo $tmp;
        }
    }
}


?>
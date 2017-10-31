<?php
bpBase::loadAppClass('base', '', 0);

class pay425_controller extends base_controller
{
    public $is_wexin_browser = false;

    // 用户浏览器
    private $user_browser = 'other';

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

    public function aliNotify()
    {
        if (IS_POST) {
            $datas = array_merge($_GET, $_POST);

            if (isset($datas['myparam']) && !empty($datas['myparam'])) {
            } else {
            }

            $vvcode = ((isset($datas['vvcode']) ? trim($datas['vvcode']) : ''));
            $vvcodeStr = str_replace('_', '+', $vvcode);
            $vvcodeStr = str_replace('-', '/', $vvcodeStr);
            $vvcodeStr = Encryptioncode($vvcodeStr, 'DECODE');
            $vvcodeArr = array();
            $xmdd5 = '';
            $mid = 0;
            $oid = 0;

            if (!empty($vvcodeStr) && (0 < strpos($vvcodeStr, '-'))) {
                $vvcodeArr = explode('-', $vvcodeStr);

                if (isset($vvcodeArr[0]) && (0 < $vvcodeArr[0])) {
                } else {
                }

                $mid = 0;

                if (isset($vvcodeArr[1]) && (0 < $vvcodeArr[1])) {
                } else {
                }

                $oid = 0;

                if (isset($vvcodeArr[2]) && !empty($vvcodeArr[2])) {
                } else {
                }

                $xmdd5 = '';
            } else {
                exit('success');
            }

            $mdd5 = md5('ali@pay2w#8m' . $mid . $oid);

            if ((0 < $mid) && (0 < $oid) && !empty($vvcode) && ($mdd5 == $xmdd5)) {
                $newdata = array('open_id' => $datas['open_id'], 'app_id' => $datas['app_id'], 'buyer_logon_id' => $datas['buyer_logon_id'], 'trade_status' => $datas['trade_status'], 'out_trade_no' => $datas['out_trade_no'], 'trade_no' => $datas['trade_no'], 'notify_time' => $datas['notify_time'], 'action_type' => $datas['notify_action_type']);
                if (!isset($datas['out_trade_no']) || empty($datas['out_trade_no'])) {
                    echo 'success';
                    return false;
                }


                unset($datas);
                $newdata = $this->clear_html($newdata);
                if (($newdata['trade_status'] == 'TRADE_SUCCESS') || ($newdata['trade_status'] == 'TRADE_FINISHED')) {
                    $payupdata = array('paytime' => time(), 'state' => 1, 'ispay' => 1, 'truename' => $newdata['buyer_logon_id'], 'openid' => $newdata['open_id'], 'transaction_id' => $newdata['trade_no'], 'extrainfo' => serialize($newdata));
                    $orderDb = M('cashier_order');
                    $tmporder = $orderDb->get_one(array('id' => $oid, 'mid' => $mid, 'order_id' => $newdata['out_trade_no']), '*');
                    if (!$tmporder || !is_array($tmporder)) {
                        echo 'success';
                        return false;
                    }


                    $orderDb->update($payupdata, array('id' => $oid, 'mid' => $mid));
                    $fansDb = M('cashier_fans');
                    $tmpfans = $fansDb->get_one(array('openid' => $newdata['open_id'], 'mid' => $mid, 'buyeraccount' => $newdata['buyer_logon_id']), '*');
                    $total_fee = $tmporder['goods_price'] * 100;
                    $alipayConf = M('cashier_payconfig')->getalipayConf($mid);
                    $fansData = array('appid' => $alipayConf['appid'], 'totalfee' => $total_fee, 'is_subscribe' => 0, 'cf' => 'alipay', 'nickname' => $newdata['buyer_logon_id'], 'buyeraccount' => $newdata['buyer_logon_id']);
                    $useridStr = $newdata['buyer_logon_id'];

                    if (!empty($tmpfans) && is_array($tmpfans)) {
                        $fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
                        $fansDb->update($fansData, array('id' => $tmpfans['id']));
                    } else {
                        $fansData['mid'] = $mid;
                        $fansData['openid'] = $newdata['open_id'];
                        $fansDb->insert($fansData, true);
                    }

                    bpBase::loadOrg('orderPrint');
                    $pt = new orderPrint();
                    $tmpMer = $this->getMerBymid($tmporder['mid']);
                    $printvars = array('mername' => $tmpMer['wxname']);
                    empty($printvars['mername']) && !empty($tmpMer['weixin']) && $printvars['mername'] = $tmpMer['weixin'];

                    if (0 < $tmporder['storeid']) {
                        $tmpStore = $this->getStoreByid($tmporder['storeid'], $tmporder['mid']);
                        $printvars['storename'] = ((!empty($tmpStore) ? $tmpStore['business_name'] . $tmpStore['branch_name'] : ''));
                    } else {
                        $printvars['storename'] = '';
                    }

                    $printvars['user'] = $useridStr;
                    $printvars['paydesc'] = $tmporder['goods_name'];
                    $printvars['buytime'] = date('Y-m-d H:i:s', $tmporder['add_time']);
                    $printvars['mprice'] = $tmporder['goods_price'];
                    $printvars['orderid'] = $tmporder['order_id'];
                    $printvars['paytype'] = '支付宝支付';
                    $printvars['printtime'] = date('Y-m-d H:i:s');
                    $pt->printit($printvars, $tmporder['mid'], $tmporder['storeid']);

                    if ($tmporder['goods_type'] == 'apppay') {
                        bpBase::loadOrg('JPush/JPush');
                        $client = new JPush(JPUSH_AppKey, JPUSH_MasterSecret, NULL);
                        $jpush = $client->push();
                        $jpush->setPlatform('all');

                        if (!empty($tmporder['extrainfo'])) {
                            $jpush->addAlias($tmporder['extrainfo']);
                        } else {
                            $jpush->setAudience('all');
                        }

                        $result = $jpush->setNotificationAlert('支付通知')->addAndroidNotification('支付成功', '支付通知', 1, array('ispay' => 1, 'mid' => $tmporder['mid'], 'storeid' => $tmporder['storeid'], 'eid' => $tmporder['eid'], 'paytime' => date('Y-m-d H:i', SYS_TIME), 'mprice' => $tmporder['goods_price'], 'paytype' => '支付宝支付', 'orderid' => $tmporder['order_id']))->addIosNotification('支付成功', 'default', 1, true, NULL, array('ispay' => 1, 'mid' => $tmporder['mid'], 'storeid' => $tmporder['storeid'], 'eid' => $tmporder['eid'], 'paytime' => date('Y-m-d H:i', SYS_TIME), 'mprice' => $tmporder['goods_price'], 'paytype' => '支付宝支付', 'orderid' => $tmporder['order_id']))->setOptions(NULL, 60, NULL, true)->send();
                    }


                    unset($fansData);
                }


                echo 'success';
            }

        }

    }

    public function aliWapNotify()
    {
        //file_put_contents('./alipay.txt',json_encode($_POST));
        $str = file_get_contents('alipay.txt');


        $_POST = json_decode($str, true);
        $a = 1;
        //if (IS_POST) {
        if ($a) {
            if (isset($_POST['myparam']) && !empty($_POST['myparam'])) {
                $myyparams = $_POST['myparam'];
            } else {
                $myyparams = trim($_GET['myparam']);
            }


            if (!empty($myyparams)) {
                $myyparams = str_replace('_', '+', $myyparams);
                $myyparams = str_replace('-', '/', $myyparams);
                $myyparams = Encryptioncode($myyparams, 'DECODE');

                if (!empty($myyparams) && (0 < strpos($myyparams, '-'))) {
                    $vvcodeArr = explode('-', $myyparams);

                    if (isset($vvcodeArr[0]) && (0 < $vvcodeArr[0])) {
                        $mid = $vvcodeArr[0];
                    } else {
                        $mid = 0;
                    }


                    if (isset($vvcodeArr[1]) && (0 < $vvcodeArr[1])) {
                        $oid = $vvcodeArr[1];
                    } else {
                        $oid = 0;
                    }


                    if (isset($vvcodeArr[2]) && !empty($vvcodeArr[2])) {
                        $xmdd5 = $vvcodeArr[2];
                    } else {
                        $xmdd5 = '';
                    }


                    $newmdd5 = md5('ali1p@ay3wap' . $mid . $oid);
                    unset($myyparams);
                    if (($xmdd5 == $newmdd5) && (0 < $mid) && (0 < $oid)) {
                        if (!empty($_POST['notify_id']) && !empty($_POST['notify_type']) && !empty($_POST['sign'])) {


                            $trade_status = trim($_POST['trade_status']);
                            if (($trade_status == 'TRADE_FINISHED') || ($trade_status == 'TRADE_SUCCESS')) {
                                $datas = array_merge($_GET, $_POST);


                                $newdata = array('open_id' => $datas['buyer_id'], 'app_id' => $alipayConf['appid'], 'buyer_logon_id' => $datas['buyer_email'], 'trade_status' => $datas['trade_status'], 'out_trade_no' => $datas['out_trade_no'], 'trade_no' => $datas['trade_no'], 'notify_time' => $datas['notify_time'], 'total_fee' => $datas['total_fee']);

                                $newdata = $this->clear_html($newdata);
                                $time = time();
                                $payupdata = array('paytime' => $time, 'state' => 1, 'ispay' => 1, 'truename' => $newdata['buyer_logon_id'], 'openid' => $newdata['open_id'], 'transaction_id' => $newdata['trade_no'], 'extrainfo' => serialize($newdata));
                                $orderDb = M('cashier_order');
                                $tmporder = $orderDb->get_one(array('id' => $oid, 'mid' => $mid, 'order_id' => $newdata['out_trade_no']), '*');

                                if (!$tmporder || !is_array($tmporder)) {
                                    echo 'success';
                                    exit();
                                }
                                $order = $orderDb->update($payupdata, array('id' => $oid, 'mid' => $mid));
                                //支付成功发送模版消息通知
                                if ($order) {
                                    $employee_openid = M('cashier_employee')->get_one(array('eid' => $tmporder['eid']), 'openid');
                                    bpBase::loadOrg('WxAuth');
                                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                                    $wx_user_one = json_decode($wx_user_one['value'], true);
                                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                                    $dataMessage = array(
                                        'first' => array('value' => '账单支付成功'),
                                        'keyword1' => array('value' => $tmporder['order_id'], 'color' => '#173177'),
                                        'keyword2' => array('value' => date("Y-m-d H:i:s", $time), 'color' => '#173177'),
                                        'keyword3' => array('value' => $tmporder['goods_price'], 'color' => '#173177'),
                                        'keyword4' => array('value' => $tmporder['goods_describe'], 'color' => '#173177'),
                                        'remark' => array('value' => '你好，顾客已支付成功。', 'color' => '#173177')
                                    );


                                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);
                                    dump($a);
                                    exit;

                                }


                                $fansDb = M('cashier_fans');
                                $tmpfans = $fansDb->get_one(array('openid' => $newdata['open_id'], 'mid' => $mid, 'buyeraccount' => $newdata['buyer_logon_id']), '*');
                                $total_fee = $tmporder['goods_price'] * 100;
                                $fansData = array('appid' => $alipayConf['appid'], 'totalfee' => $total_fee, 'is_subscribe' => 0, 'cf' => 'alipay', 'nickname' => $newdata['buyer_logon_id'], 'buyeraccount' => $newdata['buyer_logon_id']);
                                $useridStr = $newdata['buyer_logon_id'];

                                if (!empty($tmpfans) && is_array($tmpfans)) {
                                    $fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
                                    $fansDb->update($fansData, array('id' => $tmpfans['id']));
                                } else {
                                    $fansData['mid'] = $mid;
                                    $fansData['openid'] = $newdata['open_id'];
                                    $fansDb->insert($fansData, true);
                                }

                                bpBase::loadOrg('orderPrint');
                                $pt = new orderPrint();
                                $tmpMer = $this->getMerBymid($tmporder['mid']);
                                $printvars = array('mername' => $tmpMer['wxname']);
                                empty($printvars['mername']) && !empty($tmpMer['weixin']) && $printvars['mername'] = $tmpMer['weixin'];

                                if (0 < $tmporder['storeid']) {
                                    $tmpStore = $this->getStoreByid($tmporder['storeid'], $tmporder['mid']);
                                    $printvars['storename'] = ((!empty($tmpStore) ? $tmpStore['business_name'] . $tmpStore['branch_name'] : ''));
                                } else {
                                    $printvars['storename'] = '';
                                }

                                $printvars['user'] = $useridStr;
                                $printvars['paydesc'] = $tmporder['goods_name'];
                                $printvars['buytime'] = date('Y-m-d H:i:s', $tmporder['add_time']);
                                $printvars['mprice'] = $tmporder['goods_price'];
                                $printvars['orderid'] = $tmporder['order_id'];
                                $printvars['paytype'] = '支付宝支付';
                                $printvars['printtime'] = date('Y-m-d H:i:s');
                                $pt->printit($printvars, $tmporder['mid'], $tmporder['storeid']);
                                unset($fansData);
                            }

                        }


                        echo 'success';
                        exit();
                    } else {
                        echo 'fail';
                        exit();
                    }
                }

            }

        }


        echo 'success';
    }

    public function aliwappay()
    {

        $_POST['goods_price'] = trim($_POST['goods_price']);
        $_POST['mid'] = intval(trim($_POST['mid']));
        $_POST['paytype'] = 'alipay';
        if (empty($_POST['goods_price']) || !is_numeric($_POST['goods_price'])) {
            $this->errorTips('请填写正确的付款金额！最小值0.01');
            exit();
        }


        if (empty($_POST['goods_name'])) {
            $this->errorTips('收款理由必填！');
            exit();
        }


        if ($_POST['goods_price'] && is_numeric($_POST['goods_price']) && (0 < $_POST['mid'])) {
            //$alipayConf = M('cashier_payconfig')->getalipayConf($_POST['mid']);
            //查询支付宝配置
            $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');


            $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));


            $mchtype = 0;
            $pf_mid = 0;

            if (isset($alipayConf['pf_mid']) && (0 < $alipayConf['pf_mid'])) {
                $pf_mid = $alipayConf['pf_mid'];
                $mchtype = 2;
            }


            $orderinfo = $this->add_aliorder($_POST, $pf_mid, $mchtype);

            bpBase::loadAppClass('AliPayClass', 'Index', 0);


            //$AliPayClass = new AliPayClass($alipayConf);
            $AliPayClass = new AliPayClass($payconfig_data['alipay']);


            if (defined('ABS_UPLOAD_PATH')) {
                $bsSiteUrl = ABS_UPLOAD_PATH . '/pay/alipay/wapnotify.php';
            } else {
                $bsSiteUrl = '/pay/alipay/wapnotify.php';
            }

            $orderinfo['SiteUrl'] = $this->SiteUrl . $bsSiteUrl;
            $AliPayClass->aliWapPay($orderinfo);
        }

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

    public function printf_info($data)
    {
        foreach ($data as $key => $value) {
            echo '<font color=\'#00ff55;\'>' . $key . '</font> : ' . $value . ' <br/>';
        }
    }

    public function tplDispaly()
    {
        include $this->showTpl($_GET['tpl']);
    }

    public function autopay()
    {
        $mid = intval(trim($_GET['mid']));

        if (!0 < $mid) {
            $this->errorTips('参数出错，没有商家ID！');
            exit();
        }

        $eid = intval(trim($_GET['eid']));
        $storeid = intval(trim($_GET['storeid']));
        $company = M('cashier_merchants')->get_one('mid=' . $mid, 'company');
        $ename = M('cashier_employee')->get_one('eid=' . $eid, 'username');
        $branch_name = M('cashier_stores')->get_one('id=' . $storeid, 'branch_name');
        // 判断用户浏览器
        if ($this->user_browser == 'wechat') {
            bpBase::loadOrg('wxCardPack');
            $wx_user = M('cashier_payconfig')->getwxuserConf($mid);
            if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
                $wxCardPack = new wxCardPack($wx_user['submchinfo'], $mid);
            } else {

                $wxCardPack = new wxCardPack($wx_user, $wx_user['mid']);
            }
            //$_SESSION['my_Cashier_openid']=null;
            if ($this->is_wexin_browser && empty($_SESSION['my_Cashier_openid'])) {
                $redirecturl = $this->SiteUrl . '/' . $_SERVER['REQUEST_URI'];
                $retrunarr = $wxCardPack->authorize_openid($redirecturl);
            }

            /**
             *  获取微信信息
             */
            $wxuserinfo = array();
            if ($this->is_wexin_browser && !empty($_SESSION['my_Cashier_openid'])) {
                $access_token = $wxCardPack->getToken();
                $wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $_SESSION['my_Cashier_openid']);
                $this->fanSave($wxuserinfo, $mid);
            }
        } else if ($this->user_browser == 'alipay') {
            $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
            $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));
            bpBase::loadOrg('alipayHelper');
            $alipayhelper = new alipayHelper($payconfig_data);
            if (empty($_SESSION['my_Cashier_aliuserid'])) {
                $redirecturl = urlencode($this->SiteUrl . '/' . $_SERVER['REQUEST_URI']);
                $result = $alipayhelper->getUserId($redirecturl);
                if (!$result['success']) {
                    die($result['errmsg']);
                } else {
                    $_SESSION['my_Cashier_aliuserid'] = $result['data'];
                }
            }
        }

        $ordid = trim($_GET['oid']);
        if (!empty($ordid)) {
            $orderInfo = M('cashier_order')->getOneOrder(array('id' => $ordid, 'mid' => $mid));
        } else {
            $orderInfo = array();
        }

        include $this->showTpl();
    }

    //支付宝二维码支付
    public function aliautopay()
    {
        $mid = intval(trim($_GET['mid']));

        if (!0 < $mid) {
            $this->errorTips('参数出错，没有商家ID！');
            exit();
        }


        $eid = intval(trim($_GET['eid']));
        $storeid = intval(trim($_GET['storeid']));
        $ordid = trim($_GET['oid']);

        if (!empty($ordid)) {
            $orderInfo = M('cashier_order')->getOneOrder(array('id' => $ordid, 'mid' => $mid));
        } else {
            $orderInfo = array();
        }

        include $this->showTpl();
    }

    public function aliforeverpay()
    {
        $orderid = trim($_GET['ordid']);
        $ordertmp = array('mid' => 0);

        if (!empty($orderid)) {
            $ordertmp = json_decode(base64_decode($orderid), true);
        }


        if (!isset($ordertmp['mid'])) {
            $this->errorTips('参数出错，没有商家ID！');
            exit();
        }


        $mid = $ordertmp['mid'];
        include $this->showTpl();
    }

    public function errorTips($msg = '')
    {
        $msg = $msg;
        include $this->showTpl('errorTips');
    }

    public function foreverpay()
    {
        $orderid = trim($_GET['ordid']);
        $ordertmp = array('mid' => 0);

        if (!empty($orderid)) {
            $ordertmp = json_decode(base64_decode($orderid), true);
        }


        if (!isset($ordertmp['mid'])) {
            $this->errorTips('参数出错，没有商家ID！');
            exit();
        }


        $mid = $ordertmp['mid'];

        if (isset($ordertmp['receiveid']) && isset($ordertmp['totalmoney']) && isset($ordertmp['cardid'])) {
            $ordertmp['title'] = ((trim($ordertmp['title']) ? $ordertmp['title'] : '卡券优惠支付'));
            isset($_SESSION['openid_' . $mid]) && !empty($_SESSION['openid_' . $mid]) && $_SESSION['my_Cashier_openid'] = $_SESSION['openid_' . $mid];
            $ordertmp['eid'] = 0;
            if (!isset($ordertmp['storeid']) || empty($ordertmp['storeid'])) {
                $ordertmp['storeid'] = 0;
            }

        }


        bpBase::loadOrg('wxCardPack');
        $wx_user = M('cashier_payconfig')->getwxuserConf($ordertmp['mid']);

        if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $ordertmp['mid']) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
            $wxCardPack = new wxCardPack($wx_user['submchinfo'], $ordertmp['mid']);
        } else {
            $wxCardPack = new wxCardPack($wx_user, $wx_user['mid']);
        }

        if ($this->is_wexin_browser && empty($_SESSION['my_Cashier_openid'])) {
            $redirecturl = $this->SiteUrl . '/' . $_SERVER['REQUEST_URI'];
            $retrunarr = $wxCardPack->authorize_openid($redirecturl);
        }


        $wxuserinfo = array();
        if ($this->is_wexin_browser && !empty($_SESSION['my_Cashier_openid'])) {
            $access_token = $wxCardPack->getToken();
            $wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $_SESSION['my_Cashier_openid']);
            $this->fanSave($wxuserinfo, $ordertmp['mid']);
        }


        include $this->showTpl();
    }

    public function againpay()
    {
        $ordid = trim($_GET['ordid']);
        $ordertmp = json_decode(base64_decode($ordid), true);

        if (!empty($ordertmp) && is_array($ordertmp) && isset($ordertmp['mid'])) {
            $mid = $ordertmp['mid'];
            $oid = $ordertmp['oid'];
            $order_id = $ordertmp['order_id'];
            $openid = $_SESSION['openid_' . $ordertmp['mid']];

            if (empty($openid)) {
                $this->errorTips('没有获取到支付用户的openid！');
            }


            $_SESSION['my_Cashier_openid'] = $openid;
            $orderDb = M('cashier_order');
            $orderArr = $orderDb->get_one(array('id' => $oid, 'mid' => $mid, 'order_id' => $order_id), '*');
            $neworderid = date('YmdHis') . SYS_TIME . mt_rand(11111111, 99999999);

            if (!empty($orderArr)) {
                if ($orderDb->update(array('order_id' => $neworderid), array('id' => $orderArr['id'], 'mid' => $mid))) {
                    $orderArr['order_id'] = $neworderid;
                }


                $wx_user = M('cashier_payconfig')->getwxuserConf($mid);

                if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $_POST['mid']) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
                    define('WxPay_SUBopenid', 1);
                }


                bpBase::loadAppClass('weixinPay', 'Index', 0);
                $weixinPay = new weixinPay();
                $result = $weixinPay->mobilepay($wx_user, $orderArr);

                if (!$result['error']) {
                    $redirctUrl = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=success_tips&ordid=' . $orderArr['id'];
                    $pay_money = $orderArr['goods_price'];
                    include $this->showTpl('weixin_pay');
                    exit();
                } else {
                    $this->errorTips($result['msg']);
                    exit();
                }
            }

        }


        $this->errorTips('支付失败了！');
    }

    public function foreverpaying()
    {

        //如果不是POST提交并且$_GET['ordid']定义并且$_GET['ordid']不为空
        if (empty($_POST) && isset($_GET['ordid']) && !empty($_GET['ordid'])) {
            $cpParam = trim($_GET['ordid']);

            $ordertmp = json_decode(base64_decode($cpParam), true);
            $mid = $ordertmp['mid'];
            $cardpayParam = $_SESSION['cardpayParam' . $mid];

            if ((0 < $mid) && !empty($cardpayParam) && ($cpParam == $cardpayParam) && isset($_SESSION['openid_' . $mid]) && !empty($_SESSION['openid_' . $mid])) {
                $_POST['goods_price'] = $ordertmp['price'];
                $_POST['mid'] = $mid;
                $_POST['paytype'] = 'weixin';
                $_POST['extrainfo'] = $cardpayParam;
                $_POST['eid'] = 0;
                $_POST['storeid'] = (($ordertmp['storeid'] ? intval($ordertmp['storeid']) : 0));

                if (isset($ordertmp['title']) && !empty($ordertmp['title'])) {
                } else {
                }

                $_POST['goods_name'] = '卡券优惠支付';

                if (isset($ordertmp['cf']) && ($ordertmp['cf'] == 'wapvcard')) {
                    $_POST['goods_name'] = '顾客本地会员卡充值';
                }


                $_POST['tname'] = '';
                $_SESSION['my_Cashier_openid'] = $_SESSION['openid_' . $mid];
                unset($_SESSION['cardpayParam' . $mid]);
            }

        }


        $_POST['goods_price'] = trim($_POST['goods_price']);
        $_POST['mid'] = intval(trim($_POST['mid']));
        $paytype = trim($_POST['paytype']);
        $paytype = ((!empty($paytype) ? $paytype : ''));

        $tmpl = 'weixin_pay';
        if (empty($_POST['goods_price']) || !is_numeric($_POST['goods_price'])) {
            $this->errorTips('请填写正确的付款金额！最小值0.01');
            exit();
        }


        if (empty($_POST['goods_name'])) {
            $this->errorTips('收款理由必填！');
            exit();
        }
        switch ($paytype) {
            case 'weixin':
                $wx_user = M('cashier_payconfig')->getwxuserConf($_POST['mid']);
                $pmid = 0;
                $mchtype = 0;

                if (isset($wx_user['p_mid']) && isset($wx_user['submchinfo'])) {
                    $pmid = $wx_user['p_mid'];
                    $mchtype = 1;
                }


                if (isset($wx_user['mymid']) && ($wx_user['mymid'] == $_POST['mid']) && isset($wx_user['pfpaymid'])) {
                    $pmid = $wx_user['mid'];
                    $mchtype = 2;
                }


                if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $_POST['mid']) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
                    define('WxPay_SUBopenid', 1);
                }


                //添加订单
                $orderinfo = $this->add_order($_POST, $pmid, $mchtype);

                if ($orderinfo) {
                    bpBase::loadAppClass('weixinPay', 'Index', 0);
                    //实例化微信类
                    $weixinPay = new weixinPay();
                    $result = $weixinPay->mobilepay($wx_user, $orderinfo);

                    if (!$result['error']) {
                        $redirctUrl = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=success_tips&ordid=' . $orderinfo['orderid'];
                        $pay_money = $orderinfo['goods_price'];

                        $weixin_param = json_decode($result['weixin_param'], true);

                        $tmpl = 'weixin_pay';
                        include $this->showTpl($tmpl);
                    } else {
                        $this->errorTips($result['msg']);
                        exit();
                    }
                }


                break;

            case 'alipay':
                break;

                break;
                include $this->showTpl($tmpl);

                $this->errorTips('付款信息错误！');
        }
    }

    public function success_tips()
    {
        $ordid = trim($_GET['ordid']);
        $orderDb = M('cashier_order');
        $orderInfo = $orderDb->get_one(array('id' => $ordid), '*');
        include $this->showTpl();
    }

    private function fanSave($fdata = array(), $mid = 0)
    {
        $fansData = array();

        if (isset($fdata['nickname']) && isset($fdata['headimgurl'])) {
            $fansData['nickname'] = $fdata['nickname'];
            $fansData['sex'] = $fdata['sex'];
            $fansData['province'] = $fdata['province'];
            $fansData['city'] = $fdata['city'];
            $fansData['country'] = $fdata['country'];
            $fansData['headimgurl'] = $fdata['headimgurl'];
            $fansData['groupid'] = $fdata['groupid'];
            $fansData['is_subscribe'] = 1;
        }


        $fansDb = M('cashier_fans');
        $tmpfans = $fansDb->get_one(array('openid' => $_SESSION['my_Cashier_openid'], 'mid' => $mid), '*');

        if (!empty($tmpfans) && is_array($tmpfans)) {
            $fansDb->update($fansData, array('id' => $tmpfans['id']));
        } else {
            $fansData['mid'] = $mid;
            $fansData['openid'] = $_SESSION['my_Cashier_openid'];
            $fansDb->insert($fansData, true);
        }

        return true;
    }

    public function add_order($datas, $pmid = 0, $mchtype = 0)
    {

        if (isset($datas['extrainfo']) && !empty($datas['extrainfo'])) {
        } else {
        }

        //判断是否为二清商户
        $merchants = M('cashier_merchants')->get_One(array('mid' => $datas['mid']), '*');
        $wxrebate = M('cashier_wxrebate')->select(array('is_pay' => 1, 'type' => 1), 'rebate');

        if ($merchants['mtype'] == '1') {
            $wx_pay = $wxrebate[0]['rebate'] / 100;//微信费率配置
        } else if ($merchants['mtype'] == '2') {
            $wx_pay = $wxrebate[1]['rebate'] / 100;//微信费率配置
        }


        $param = '';
        $paramArr = ((!empty($param) ? json_decode(base64_decode($param), true) : array()));
        $paramArr['price'] = (string)$paramArr['price'];
        $data['mid'] = $datas['mid'];
        $data['pmid'] = $pmid;
        $data['mchtype'] = $mchtype;
        $data['goods_id'] = 1;
        $data['pay_way'] = trim($datas['paytype']);
        $data['pay_type'] = 'wxJSAPI';
        $data['order_id'] = '22' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);

        $data['goods_type'] = ((!empty($paramArr) && isset($paramArr['receiveid']) && isset($paramArr['cardid']) ? 'CardOfPay' : 'unlimit'));

        if (isset($paramArr['cf']) && ($paramArr['cf'] == 'wapvcard')) {
            $data['goods_type'] = 'LocalVipCardRecharge';
        }


        $data['goods_name'] = htmlspecialchars(trim($datas['goods_name']), ENT_QUOTES);
        $data['goods_describe'] = '微信用户自助扫描二维码支付';
        $data['goods_price'] = $datas['goods_price'];
        $data['openid'] = ((!empty($_SESSION['my_Cashier_openid']) ? $_SESSION['my_Cashier_openid'] : ''));
        $data['add_time'] = time();
        $data['truename'] = ((isset($datas['tname']) ? htmlspecialchars(trim($datas['tname']), ENT_QUOTES) : ''));
        isset($datas['eid']) && ($data['eid'] = intval($datas['eid']));
        isset($datas['storeid']) && ($data['storeid'] = intval($datas['storeid']));
        !empty($param) && isset($paramArr['ucid']) && ($data['ucid'] = intval($paramArr['ucid']));
        !empty($param) && is_array($paramArr) && ($data['extrainfo'] = serialize($paramArr));


        //商家实收金额
        $merchants = M('cashier_merchants')->get_One(array('mid' => $datas['mid']), '*');


        $merchants_income = $datas['goods_price'];
        //查询返佣比率
        $salesmans = M('cashier_salesmans')->get_One(array('id' => $merchants['sid']), '*');
        $agent = M('cashier_agent')->get_One(array('aid' => $merchants['aid']), '*');
        $wxrebate = M('cashier_wxrebate')->get_one(array('type' => 1));

        //计算业务员佣金
        //$salesmans_income = $datas['goods_price'] * ($merchants['commission'] - $wxrebate['rebate']) * $agent['commission'] * $salesmans['commission'];
        $salesmans_income = $datas['goods_price'] * $wx_pay * $agent['commission'] * $salesmans['commission'];

        $salesmans_income_is_null = $this->sctonum($salesmans_income);//将科学计算法转为实体
        if ($salesmans_income_is_null) {
            $salesmans_income = $salesmans_income_is_null;
        }

        //计算代理商佣金

        //$agent_income = $datas['goods_price'] * ($merchants['commission'] - $wxrebate['rebate']) * $agent['commission'];
        $agent_income = $datas['goods_price'] * $wx_pay * $agent['commission'];


        $agent_income_is_null = $this->sctonum($agent_income);//将科学计算法转为实体
        if ($agent_income_is_null) {
            $agent_income = $agent_income_is_null;
        }

        //收入
        $data['income'] = round($merchants_income, 2);
        $data['salesmans_price'] = round($salesmans_income, 2);
        $data['agent_price'] = round($agent_income, 2);

        $orderid = M('cashier_order')->insert($data, true);


        if ($orderid) {
            $data['orderid'] = $orderid;

            if (isset($paramArr['cf']) && ($paramArr['cf'] == 'wapvcard')) {
                $paramArr['ordid'] = $orderid;
                $this->add_locmbpayrecord($paramArr);
            }


            return $data;
        }


        return false;
    }

    public function add_locmbpayrecord($cardData = array())
    {
        if (!empty($cardData)) {
            $insertdata = array('ordid' => $cardData['ordid'], 'orderdesc' => $cardData['numstr'] . ' 充值', 'paytype' => 'cardRecharge', 'createtime' => SYS_TIME, 'price' => (double)$cardData['price'], 'mid' => $cardData['mid'], 'openid' => $cardData['openid'], 'type' => '0', 'cdid' => $cardData['cdid']);
            $idd = M('cashier_locmbpayrecord')->insert($insertdata, true);
            return $idd;
        }


        return false;
    }


    /**
     * @param $num         科学计数法字符串  如 2.1E-5
     * @param int $double 小数点保留位数 默认5位
     * @return string
     */

    public function sctonum($num, $double = 5)
    {
        if (false !== stripos($num, "e")) {
            $a = explode("e", strtolower($num));
            return bcmul($a[0], bcpow(10, $a[1], $double), $double);
        }
    }

    //收款
    public function qrinfo()
    {
        if ($_GET['ewmid']) {
            $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $_GET['ewmid'] . "'");
            if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {
                header('Location:http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '/merchants.php?m=Index&c=pay&a=autopay&mid=' . $rows['mid'] . '&eid=' . $rows['eid'] . '&storeid=' . $rows['storesid']);
            } else {
                $this->errorTip('该二维码未绑定商户!');
            }
        } else {
            $this->errorTip('参数错误!');
        }
    }

    //绑定通知二维码
    public function notice()
    {
        $ewmid = $_GET['ewmid'];
        if ($ewmid) {
            $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $ewmid . "'");
            if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {


                $wx_values = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                $wx_values = json_decode($wx_values['value'], true);

                $redirecturl = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
                $openid = $this->binding_wx_openid($redirecturl, $wx_values);
                $re = M('cashier_employee')->update(array('openid' => $openid['openid'], 'xw_img' => $openid['headimgurl'], 'wx_name' => $openid['nickname']), 'eid=' . $rows['eid']);
                if ($re) {
                    include $this->showTpl();
                }
            } else {
                echo "<script>alert('二维码未绑定商户!')</script>";
            }
        } else {
            echo "<script>alert('参数错误!')</script>";
        }
    }


    /**
     * 抓取用户微信信息
     * @param unknown $redirecturl
     * @param unknown $data
     */
    public function binding_wx_openid($redirecturl, $data)
    {
        if (empty($_GET['code'])) {
            $oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $data['appid'] . '&redirect_uri=' . urlencode($redirecturl) . '&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect';
            header('Location: ' . $oauthUrl);
            exit();
        } else {
            $json = $this->getOAuth($data);
            $Resources = $this->getWxUserInfo2($json['openid'], $json['access_token']);
            if ($Resources) {
                return $Resources;
            } else {
                return false;
            }
        }

    }


    /**
     * 通过code获取用户基本信息
     *
     * @return array {access_token,expires_in,refresh_token,openid,scope}
     */
    public function getOAuth($data)
    {
        $code = isset($_GET['code']) ? $_GET['code'] : '';
        if (!$code)
            return false;

        // GET请求连接
        $get_token_url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . $data['appid'] . "&secret=" . $data['appSecret'] . "&code=" . $code . "&grant_type=authorization_code";
        $result = $this->http_get($get_token_url);

        if ($result) {
            $json = json_decode($result, true);
            if (isset($json['access_token'])) {
                return $json;
            }
        }
        return false;
    }

    /**
     * GET 请求
     *
     * @param string $url
     */
    private function http_get($url)
    {
        $oCurl = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($oCurl, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($oCurl, CURLOPT_SSLVERSION, 1); // CURL_SSLVERSION_TLSv1
        }
        curl_setopt($oCurl, CURLOPT_URL, $url);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        $sContent = curl_exec($oCurl);
        $aStatus = curl_getinfo($oCurl);
        curl_close($oCurl);
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }
    }


    /**
     * 获取用户详细信息
     *
     * @param string $openid :微信用户openid
     * @return mixed|boolean {
     *         "subscribe": 1,
     *         "openid": "o6_bmjrPTlm6_2sgVt7hMZOPfL2M",
     *         "nickname": "Band",
     *         "sex": 1,
     *         "language": "zh_CN",
     *         "city": "广州",
     *         "province": "广东",
     *         "country": "中国",
     *         "headimgurl":"http://wx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/0",
     *         "subscribe_time": 1382694957,
     *         "unionid": " o6_bmasdasdsad6_2sgVt7hMZOPfL"
     *         "remark": "",
     *         "groupid": 0
     *         }
     */
    public function getWxUserInfo2($openid, $accessToken)
    {
        $url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $accessToken . '&openid=' . $openid . '&lang=zh_CN';

        $result = $this->http_get($url);
        if ($result) {
            $json = json_decode($result, true);
            if ($json) {
                return $json;
            } else {
                return false;
            }
        }
    }

    /**
     * 获取AccessToken
     *
     * @return boolean|unknown
     */
    public function getAccessToken($data)
    {
        $AccessToken_value = M('cashier_key_values')->get_one(array('name' => 'AccessTokenExpiredTime'));

        if ($time < time()) {
            $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $data['appid'] . '&secret=' . $data['appSecret'];
            $result = $this->http_get($url);
            // 判断是否获取access_token
            if ($result) {
                $json = json_decode($result, true);
                $AccessToken = $json['access_token'];
                if ($AccessToken) {
                    $data['value'] = $AccessToken;
                    // $data['time'] = date('Y-m-d H:i:s',time()+ 30 * 60);
                    M('cashier_key_values')->update(array('time' => time() + 30 * 60, 'value' => $data['value']), array('name' => 'AccessTokenExpiredTime'));
                    return $AccessToken;
                } else {
                    return false;
                }
            }
        } else {
            return $AccessToken_value['value'];
        }
    }

    // 支付宝收款
    public function alitradepay()
    {
        //var_dump($_POST);
        $mid = $_POST['mid'];
        $eid = $_POST['eid'];
        $storeid = $_POST['storeid'];
        $paytype = $_POST['paytype'];
        $goodsprice = $_POST['goods_price'];
        $goodsname = $_POST['goods_name'];

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
            'pid' => $payconfig_data['alipay']['pid']
        );

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
	
    // 获取支付宝收款结果
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

        // 如果订单已处理
        if ($order['state'] != 0) {
            $result['success'] = true;
            $result['data'] = $order['state'] == 1 ? 'TRADE_SUCCESS' : 'TRADE_CLOSED';
            die(json_encode($result));
        }

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

        bpBase::loadOrg('alipayHelper');
        $alipayhelper = new alipayHelper($payconfig_data, $appauthtoken);
        $result = $alipayhelper->getTradeResult($orderid);
	
        if (!$result['success']) {
            die(json_encode($result));
        }


        //Bug Log
        //问题： 数据库state 在数据库的state是tiny(1) 当订单状态TRADE_CLOSED 设置state 为-1失败导致超时未支付订单记录为成功支付
        //原if条件：$result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_CLOSED' || $result['data']['trade_status'] == 'TRADE_FINISHED'
        //解决办法： 不处理订单状态为TRADE_CLOSED的订单
        //理想解决办法：修改数据库的state 字段，但是影响过大，可能印象已有的查询！
        // 如果支付宝返回结果，则更新本地订单
        if ($result['data']['trade_status'] == 'TRADE_SUCCESS'  || $result['data']['trade_status'] == 'TRADE_FINISHED') {
            $state = $result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_FINISHED' ? 1 : -1;
            $paytime = time();
            $updateData = array('ispay' => 1, 'state' => $state, 'openid' => $result['data']['buyer_user_id'], 'paytime' => $paytime, 'transaction_id' => $result['data']['trade_no']);
            $where = array(
                'order_id' => $orderid
            );
			$m = M('cashier_order');
			
            $order_update = $m->update($updateData, $where);
			
			var_dump($m->getLastSql());
			exit;
            /*
			// 模版消息推送
            if ($order_update) {
                $employee_openid = M('cashier_employee')->get_one(array('eid' => $order['eid']), 'openid');
                if (!empty($employee_openid['openid'])) {
                    bpBase::loadOrg('WxAuth');
                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                    $wx_user_one = json_decode($wx_user_one['value'], true);
                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                    $dataMessage = array(
                        'first' => array('value' => '账单支付成功'),
                        'keyword1' => array('value' => $order['order_id'], 'color' => '#173177'),
                        'keyword2' => array('value' => date("Y-m-d H:i:s", $paytime), 'color' => '#173177'),
                        'keyword3' => array('value' => $order['goods_price'], 'color' => '#173177'),
                        'keyword4' => array('value' => $order['goods_describe'], 'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已使用支付宝支付成功。', 'color' => '#173177')
                    );
                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);
                }
            }
			*/
        }

        $result['data'] = $result['data']['trade_status'];
        die(json_encode($result));
    }

    // 支付宝收款异步通知
    public function alitradepaynotify() {
        file_put_contents('./alipay.txt',json_encode($_POST));
    }
}


?>
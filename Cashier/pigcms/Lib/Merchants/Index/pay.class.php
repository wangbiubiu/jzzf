<?php
bpBase::loadAppClass('base', '', 0);

class pay_controller extends base_controller
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

    /**
     *
     */
    public function aliWapNotify()
    {
//        file_put_contents('./alipay.txt',json_encode($_POST));
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
                                    // M('cashier_wxcoupon_receive')->insert(array('openid'=>'1'),true);
                                    $employee_openid = M('cashier_employee')->get_one(array('eid' => $tmporder['eid']), 'openid');
                                    bpBase::loadOrg('WxAuth');
                                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                                    $wx_user_one = json_decode($wx_user_one['value'], true);
                                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                                    if ($tmporder['pay_way'] == "alipay") {
                                        $type = "支付宝" . $tmporder['goods_describe'];
                                    } else {
                                        $type = "微信" . $tmporder['goods_describe'];
                                    }
                                    $dataMessage = array(
                                        'first' => array('value' => '账单支付成功'),
                                        'keyword1' => array('value' => $tmporder['order_id'], 'color' => '#173177'),
                                        'keyword2' => array('value' => date("Y-m-d H:i:s", $time), 'color' => '#173177'),
                                        'keyword3' => array('value' => $tmporder['goods_price'], 'color' => '#173177'),
                                        'keyword4' => array('value' => $type, 'color' => '#173177'),
                                        'remark' => array('value' => '你好，顾客'.$type.'已支付成功。', 'color' => '#173177')
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

    public function add_aliorder($datas, $pmid = 0, $mchtype = 0, $order_id = 0)
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
        $data['order_id'] = $order_id ?: '11' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
        $data['goods_type'] = 'unlimit';
        $data['goods_name'] = htmlspecialchars(trim($datas['goods_name']), ENT_QUOTES);
        $data['goods_describe'] = '扫码支付';
        $data['extrainfo'] = $datas['liuyan'];//支付宝用户留言
        $data['goods_price'] = $datas['goods_price'];
        $data['openid'] = '';
        $data['add_time'] = time();
        $data['truename'] = ((isset($datas['tname']) ? htmlspecialchars(trim($datas['tname']), ENT_QUOTES) : ''));
        isset($datas['eid']) && ($data['eid'] = intval($datas['eid']));
        isset($datas['storeid']) && ($data[' storeid'] = intval($datas['storeid']));
        // 判断$order_id是否为真
        if ($order_id) {

            // 查询传过来的order_id在数据表中是否存在，不存在则添加，存在则提示错误
            $is_orderid = M('cashier_order')->select(array('order_id' => $data['order_id']), 'order_id');

            if ($is_orderid) {
                $this->errorTips('此订单已存在，请重新下单！');
            } else {
                $orderid = M('cashier_order')->insert($data, true);
                if ($orderid) {
                    $data['id'] = $orderid;
                    return $data;
                }
            }

        } else {
            $orderid = M('cashier_order')->insert($data, true);

            if ($orderid) {
                $data['id'] = $orderid;
                return $data;
            }
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
        if ($_GET['wxak']=='wx') {//判断手机直接商场支付
//            查询直接支付的参数是否正确
            $res=M('cashier_qrcode')->select(['eid'=>$eid,'mid'=>$mid,'storesid'=>$storeid],'*');
            if (!$res) {//查出数据不存在在执行
                $str=['success'=>0,'tips'=>'参数错误'];
                echo json_encode($str);
                exit();
            }
        }
        $company = M('cashier_merchants')->get_one('mid=' . $mid, 'company');
        $ename = M('cashier_employee')->get_one('eid=' . $eid, 'username');
        $branch_name = M('cashier_stores')->get_one('id=' . $storeid, '*');
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

//            $_SESSION['my_Cashier_openid'] = "otqnZwSOS9_F9B9bMixKG_UHVaRs";
            if ($this->is_wexin_browser && empty($_SESSION['my_Cashier_openid'])) {
                $redirecturl = $this->SiteUrl . '/' . $_SERVER['REQUEST_URI'];
                $retrunarr = $wxCardPack->authorize_openid($redirecturl);
            }

            /**
             *  获取微信信息
             */
            $wxuserinfo = array();
            if ($this->is_wexin_browser && !empty($_SESSION['my_Cashier_openid'])) {
                //接口开发
                if ($_GET['wxak'] == 'wx') {
                    $data = ['success' => '1', 'openId' => $_SESSION['my_Cashier_openid']];
                    echo json_encode($data);
                    exit();
                }
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
    public function form()
    {
//         $str='{"msg":{"code":"2000","msg":"success"},"data":{"orderid":"22201710301126304127862209333990","balance":26}}';
//         $lastobj=json_decode($str,true);
//         if($lastobj['msg']['code']==2000)
//         {
//             echo(1);
//         }else 
//         {
//             echo($lastobj['data']);
//         }
// die;        
//         $qrcode=M('cashier_qrcode')->get_one(array('mid'=>2),'qrcode_id');var_dump($qrcode['qrcode_id']);die;
// //            $bank=M('cashier_bank')->get_one(array('mid'=>'225'));var_dump($bank);die;
//         $whichtype = M('cashier_merchants')->get_one(array('mid'=>225),'mtype');
//         var_dump(current($whichtype));die;
        echo"<form method='post' action='./merchants.php?m=index&c=pay&a=addO'>
            <input type='text' name='mchtype' placeholder='mchtype'/>
            <input type='text' name='mid' placeholder='mid'/>
            <input type='text' name='goods_price' placeholder='goods_price'/> 
            <input type='submit' value='submit'/>
            <a href='./merchants.php?m=index&c=auto2&a=index'>结算</a>
            </form>";
    }
    
    
    public function addO()
    {
        $_POST['add_time']=time()-3600*24;
        $_POST['order_id']=time()+time();
        $_POST['paytime']=time()-3600*24+20;
        $_POST['ispay']=1;
        $_POST['state']=1;
        $_POST['income']=$_POST['goods_price'];
        $_POST['pay_way']=($_POST['mchtype']=='2'?'weixin':'qq');
        $order=M('cashier_order')->insert($_POST, true);
        var_dump($order);
        die;
    }
    //微信收款
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
        $toadytime=date("H:i:s");
        $todayday=date("Y-m-d");
        $ll=" ad_tfstarttime<='{$toadytime}' AND ad_tfendtime>='{$toadytime}' AND ad_sxstarttime<='{$todayday}' AND ad_sxendtime>='{$todayday}' AND is_gao=1";
        $adresult=M('cashier_adlist')->get_one($ll);
        if($adresult){
            $addr='%'.$adresult['ad_shenaddress'].$adresult['ad_shiaddress'].$adresult['ad_quaddress'].'%';
            $whereaddr=" fulladdress like '{$addr}' AND mid={$_POST['mid']} ";
            $addresult=M('cashier_merchants')->select($whereaddr);
            if($addresult){
                $newad=M('cashier_adlist')->get_one($ll);
            }
        }
//        如果该时间段有广告就把广告的权限改为1
//        if ($adresult) {
//            M('cashier_adlist')->update(['is_adv'=>1],$ll);
//        }
//        在根据mid查出对应的有效广告小的地区
//        $data=M('cashier_adlist')->select(['ad_mid'=>$_POST['mid'],'is_adv'=>1],'mid,ad_id');
//        如果查出的地区mid 不为空就进入下面逻辑处理
//        if (!empty($data)) {
//            $datamid=explode(',',$data[0]['mid']);
//            foreach ($datamid as $v){
//                if($v==$_POST['mid']){
//                    M('cashier_adlist')->update(['is_keyi'=>1],['ad_id'=>$data[0]['id']]);
//                }
//            }
//        }
//        查出广告投放地区是否有效
//        $is_keyi=M('cashier_adlist')->select(['ad_id'=>$data[0]['id'],'is_keyi']);

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
                $orderid = $_POST['orderid'] ?: 0;
                $storesid=$_POST['storesid'];
                //添加订单
                $orderinfo = $this->add_order($_POST, $pmid, $mchtype, $orderid);
                $mid = $orderinfo['mid'];
                $merchant = M('cashier_merchants')->get_one('mid=' . $mid, '*');
                if ($orderinfo) {
                    $redirctUrl = $this->SiteUrl . '/merchants.php?m=Index&c=pay&a=success_tips&ordid=' . $orderinfo['orderid'];
                    $tmpl = 'weixin_pay';
                    $pay_money = $orderinfo['goods_price'];
                    if ($merchant['mtype'] != 1) {//银行直连
                        if ($merchant['sub_merchant'] == 0) {//二清商户
//                            $wechatAppId = "100000568764";//平台专用微信支付
                            $payConfig = M('cashier_payconfig')->get_one(array('mid' => 1), 'configData');
                            $payConfigData = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                            $wechatAppId = $payConfigData['weixin']['sub_mch_id_two'];
                            $wechatNickname = "重庆云极付科技有限公司";
                        } else {
                            $payConfig = M('cashier_payconfig')->get_one(array('mid' => $mid), 'configData');
                            $payConfigData = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                            $wechatAppId = $payConfigData['weixin']['mchid'];
                            $wechatNickname = rawurldecode($payConfigData['weixin']['nickname']);
                        }
                        if (empty($wechatAppId)) {
                            die('收款失败，商家没有微信收款权限');
                        }
                        if (empty($wechatNickname)) {
                            $wechatAppId = "100000710849";
                            $wechatNickname = "重庆云极付科技有限公司";
                        }
                        require_once(ABS_PATH . "../MinShengBank.class.php");
                        $bank = new MinShengBank();
                        $productId = "0105";//微信公众号支付0105
                        $dataCreate = [
                            'productId' => $productId,
                            'transId' => '10',
                            'orderNo' => $orderinfo['order_id'],
                            'returnUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/Cashier/pay/bankreturn.php',
                            'notifyUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/Cashier/pay/banknotify.php',
                            'transAmt' => $orderinfo['goods_price'] * 100,
                            'commodityName' => '消费商品',
                            'subMerNo' => $wechatAppId,
                            'subMerName' => $wechatNickname,
                            'subChnlMerNo' => $wechatAppId,
                            'openid' => $_SESSION['my_Cashier_openid'],
                        ];
//                       调用银行接口
                        $result = $bank->createOrder($dataCreate);
                        if ($result['respCode'] == "P000") {
                            $weixin_param = json_decode($result['payInfo'], true);
                            include $this->showTpl($tmpl);
                        } else {
                            $this->errorTips($result['respDesc']);
                            exit();
                        }
                    } else {//特约商户
                        bpBase::loadAppClass('weixinPay', 'Index', 0);
                        //实例化微信类
                        $weixinPay = new weixinPay();
//                        调用官方接口
                        $result = $weixinPay->mobilepay($wx_user, $orderinfo);
                        if (!$result['error']) {
                            $weixin_param = json_decode($result['weixin_param'], true);
                            include $this->showTpl($tmpl);
                        } else {
                            $this->errorTips($result['msg']);
                            exit();
                        }
                    }
                    exit;
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

    public function add_order($datas, $pmid = 0, $mchtype = 0, $orderid = 0)
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
        $data['extrainfo'] = $datas['liuyan'];//微信用户留言
        $data['order_id'] = $orderid ?: '22' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);

        $data['goods_type'] = ((!empty($paramArr) && isset($paramArr['receiveid']) && isset($paramArr['cardid']) ? 'CardOfPay' : 'unlimit'));

        if (isset($paramArr['cf']) && ($paramArr['cf'] == 'wapvcard')) {
            $data['goods_type'] = 'LocalVipCardRecharge';
        }


        $data['goods_name'] = htmlspecialchars(trim($datas['goods_name']), ENT_QUOTES);
        $data['goods_describe'] = '扫码支付';
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

    //收款 （二维码详情）
    public function qrinfo()
    {
        if ($_GET['ewmid']) {
            $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $_GET['ewmid'] . "'");
            if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {
                if ($_GET['wxak'] == 'wx') {//判断是否是手机微信直接支付
                    $data = ['success' => '1', 'mid' => $rows['mid'], 'eid' => $rows['eid'], 'storeid' => $rows['storesid']];
                    echo json_encode($data);
                    exit();
                }
                header('Location:http://' . $_SERVER['HTTP_HOST'] . '/merchants.php?m=Index&c=pay&a=autopay&mid=' . $rows['mid'] . '&eid=' . $rows['eid'] . '&storeid=' . $rows['storesid']);
            } else {
                if ($_GET['wxak'] == 'wx') {//判断是否是手机微信直接支付
                    $data = ['success' => '0','tips' => '该ewmid未绑定商户!' ];
                    echo json_encode($data);
                    exit();
                }
                $this->errorTip('该二维码未绑定商户!');
            }
        } else {
            if ($_GET['wxak'] == 'wx') {//判断是否是手机微信直接支付
                $data = ['success' => '0','tips' => 'ewmid参数错误!' ];
                echo json_encode($data);
                exit();
            }
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

                $redirecturl = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
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
     * @param $redirecturl
     * @param $data
     * @return bool|mixed
     * 抓取用户微信信息
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
        //$result = $this->http_get($get_token_url);
        $result = file_get_contents($get_token_url);
        if ($result) {
            $json = json_decode($result, true);
            if (isset($json['access_token'])) {
                return $json;
            }
        }
        return false;
    }

    /**
     * @param $url
     * @return bool|mixed
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
//        var_dump($_POST);die;
        $mid = $_POST['mid'];
        $eid = $_POST['eid'];
        $storeid = $_POST['storeid'];
        $paytype = $_POST['paytype'];
        $goodsprice = $_POST['goods_price'];
        $goodsname = $_POST['goods_name'];
        $orderid = $_POST['orderid'] ?: 0;

        //广告查询并显示
        $toadytime=date("H:i:s");
        $todayday=date("Y-m-d");
        $ll=" ad_tfstarttime<='{$toadytime}' AND ad_tfendtime>='{$toadytime}' AND ad_sxstarttime<='{$todayday}' AND ad_sxendtime>='{$todayday}' ";
        $adresult=M('cashier_adlist')->get_one($ll);


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

        //var_dump($employee);

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
        $orderinfo = $this->add_aliorder($_POST, $pf_mid, $mchtype, $orderid);
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

        if ($merchant['mtype'] != 1) {
            require_once("./MinShengBank.class.php");
            $bank = new MinShengBank();
            // 判断用户浏览器
            if ($this->user_browser == 'wechat') {
                //微信
                $productId = "0107";
            } else if ($this->user_browser == 'alipay') {
                //支付宝
                $productId = "0115";
                if (empty($_SESSION['my_Cashier_aliuserid'])) {
                    $redirecturl = urlencode("http://" . $_SERVER['SERVER_NAME'] . '/' . $_SERVER['REQUEST_URI']);
                    $result = $alipayhelper->getUserId($redirecturl);
                    if (!$result['success']) {
                        die($result['errmsg']);
                    } else {
                        $_SESSION['my_Cashier_aliuserid'] = $result['data'];
                    }
                }
            } else {
                //其他
                $productId = "0115";
            }
            if ($merchant['sub_merchant'] == "0") {
                $payConfig = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
                $payConfigData = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                $alipayAppId = $payConfigData['alipay']['sub_mch_id_two'];
                $alipayNickname = "重庆云极付科技有限公司";
//                $alipayAppId = "100000567840";
            } else {
                $payConfig = M('cashier_payconfig')->get_one(array('mid' => $mid), 'configData');
                $payConfigData = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                $alipayAppId = $payConfigData['alipay']['appID'];
                $alipayNickname = rawurldecode($payConfigData['alipay']['appNickname']);
            }
            if (empty($alipayAppId)) {
                die('收款失败，商家没有支付宝收款权限');
            }
            if (empty($alipayNickname)) {
                $alipayAppId = "100000710848";
                $alipayNickname = "重庆云极付科技有限公司";
            }
            $dataCreate = [
                //产品类型：见附注
                'productId' => $productId,
                //交易类型
                'transId' => '10',
                //订单编号
                'orderNo' => $order['orderid'],

                'returnUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/Cashier/pay/bankreturn.php',
                'notifyUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/Cashier/pay/banknotify.php',

                'transAmt' => $order['amount'] * 100,
                'commodityName' => '消费商品',
                'subMerNo' => $alipayAppId,
                'subMerName' => $alipayNickname,
                'subChnlMerNo' => $alipayAppId,
                'storeId' => $_SESSION['my_Cashier_aliuserid'],
                'terminalId' => time(),
                'userId' => $_SESSION['my_Cashier_aliuserid'],
            ];
            $result = $bank->createOrder($dataCreate);
            if ($result['respCode'] != 'P000') {
                die('收款失败，错误码：' . $result['respCode'] . '，错误信息：' . $result['respDesc']);
            } else {
                // echo '收款单创建成功，trade_no：' . $result['data'];
                $tradeno = $result['tradeNo'];
                $orderid = $order['orderid'];
                $goodsprice = $order['amount'];

                include $this->showTpl();
            }
            exit;
        } else {
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
        if ($result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_FINISHED') {
            $state = $result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_FINISHED' ? 1 : -1;
            $paytime = time();
            $updateData = array('ispay' => 1, 'state' => $state, 'openid' => $result['data']['buyer_user_id'], 'paytime' => $paytime, 'transaction_id' => $result['data']['trade_no']);
            $where = array(
                'order_id' => $orderid
            );
            $order_update = M('cashier_order')->update($updateData, $where);

            // 模版消息推送
            if ($order_update) {
                $employee_openid = M('cashier_employee')->get_one(array('eid' => $order['eid']), 'openid');
                if (!empty($employee_openid['openid'])) {
                    bpBase::loadOrg('WxAuth');
                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                    $wx_user_one = json_decode($wx_user_one['value'], true);
                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                    if ($order['pay_way'] == "alipay") {
                        $type = "支付宝" . $order['goods_describe'];
                    } else {
                        $type = "微信" . $order['goods_describe'];
                    }
                    $dataMessage = array(
                        'first' => array('value' => '账单支付成功'),
                        'keyword1' => array('value' => $order['order_id'], 'color' => '#173177'),
                        'keyword2' => array('value' => date("Y-m-d H:i:s", $paytime), 'color' => '#173177'),
                        'keyword3' => array('value' => $order['goods_price'], 'color' => '#173177'),
                        'keyword4' => array('value' => $type, 'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已使用支付宝支付成功。', 'color' => '#173177')
                    );
                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);
                }
            }
        }

        $result['data'] = $result['data']['trade_status'];
        die(json_encode($result));
    }

    public function alitradebankresult()
    {
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
        require_once("./MinShengBank.class.php");
        $bank = new MinShengBank();

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

        $result = $bank->queryOrder($orderid, time());

        $result2 = array(
            'success' => false,
            'errcode' => '',
            'errmsg' => '',
            'data' => ''
        );
        //Bug Log
        //问题： 数据库state 在数据库的state是tiny(1) 当订单状态TRADE_CLOSED 设置state 为-1失败导致超时未支付订单记录为成功支付
        //原if条件：$result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_CLOSED' || $result['data']['trade_status'] == 'TRADE_FINISHED'
        //解决办法： 不处理订单状态为TRADE_CLOSED的订单
        //理想解决办法：修改数据库的state 字段，但是影响过大，可能印象已有的查询！
        // 如果支付宝返回结果，则更新本地订单
        if ($result['origRespCode'] == "0000") {
            $result2 = array(
                'success' => true,
                'errcode' => '',
                'errmsg' => '',
                'data' => 'TRADE_SUCCESS'
            );
            $state = 1;
            $paytime = time();
//            $updateData = array('ispay' => 1, 'state' => $state, 'openid' => $result['data']['buyer_user_id'], 'paytime' => $paytime, 'transaction_id' => $result['data']['trade_no']);
            $updateData = array('ispay' => 1, 'state' => $state, 'paytime' => $paytime,);
            $where = array(
                'order_id' => $orderid
            );
            $order_update = M('cashier_order')->update($updateData, $where);

            // 模版消息推送
            if ($order_update) {
                $employee_openid = M('cashier_employee')->get_one(array('eid' => $order['eid']), 'openid');
                if (!empty($employee_openid['openid'])) {
                    bpBase::loadOrg('WxAuth');
                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                    $wx_user_one = json_decode($wx_user_one['value'], true);
                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                    if ($order['pay_way'] == "alipay") {
                        $type = "支付宝" . $order['goods_describe'];
                    } else {
                        $type = "微信" . $order['goods_describe'];
                    }
                    $dataMessage = array(
                        'first' => array('value' => '账单支付成功'),
                        'keyword1' => array('value' => $order['order_id'], 'color' => '#173177'),
                        'keyword2' => array('value' => date("Y-m-d H:i:s", $paytime), 'color' => '#173177'),
                        'keyword3' => array('value' => $order['goods_price'], 'color' => '#173177'),
                        'keyword4' => array('value' => $type, 'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已使用支付宝支付成功。', 'color' => '#173177')
                    );
                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);



                }
            }
        }

        die(json_encode($result2));
    }

    // 支付宝收款异步通知
    public function alitradepaynotify()
    {
        if($_POST['trade_status']=='TRADE_SUCCESS'||$_POST['trade_status']=='TRADE_FINISHED'){
            $paytime=strtotime($_POST['gmt_payment']);
            M('cashier_order')->update(array('ispay'=>1,'state'=>1,'paytime'=>$paytime),array('ispay'=>0,'order_id'=>$_POST['out_trade_no']));
            echo 'success';
        }

        if ($_POST['trade_status']=='TRADE_SUCCESS'||$_POST['trade_status']=='TRADE_FINISHED') {
            $state = $_POST['trade_status']=='TRADE_SUCCESS' || $_POST['trade_status']=='TRADE_FINISHED' ? 1 : -1;
            $paytime = strtotime($_POST['gmt_payment']);
            $updateData = array('ispay' => 1, 'state' => $state, 'openid' => $_POST['buyer_id'], 'paytime' => $paytime, 'transaction_id' => $_POST['trade_no']);
            $where = array(
                'order_id' => $_POST['out_trade_no']
            );
            $order_update = M('cashier_order')->update($updateData, $where);
            // 查询订单
            $order = M('cashier_order')->getOneOrder(array('order_id' => $_POST['out_trade_no']));

//            打印机
            $print_id = M('cashier_qrcode')->select(['eid' => $order['eid']], 'print_id,mid');

//            打印机id不能为 为空 不进入
            if (!empty($print_id[0]['print_id']) ) {
                //            根据mid查出对应的公司名称
                $company=M('cashier_merchants')->select(['mid'=>$print_id[0]['mid']],'company');
//                根基eid查出对应营业员
                $name=M('cashier_employee')->select(['eid'=>$order['eid']],'username');
                if (preg_match('/^\d{10,11}/',$print_id[0]['print_id']) ) {//为整数类型 就是真就调用易联云打印机
                    $this->yilianyunToken($print_id[0]['print_id'], $order['order_id'], $order['goods_price'], '支付宝',$company[0]['company'],$name[0]['username']);
                } else {//为假就调用咕咕打印机
                    $strs['card_title']=$order['order_id'];
                    $strs['card_id']=$order['eid'];
                    M('cashier_wxcoupon')->insert($strs,true);
                    //                        调用打印机
                    $this->gugu($print_id[0]['print_id'], $order['order_id'], $order['goods_price'],'支付宝',$company[0]['company'],$name[0]['username']);
                }
            }
            // 模版消息推送
            if ($order_update) {
                //查询商家的openid
                $employee_openid = M('cashier_employee')->get_one(array('eid' => $order['eid']), 'openid');
                if (!empty($employee_openid['openid'])) {
                    bpBase::loadOrg('WxAuth');
                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                    $wx_user_one = json_decode($wx_user_one['value'], true);
                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                    if ($order['pay_way'] == "alipay") {
                        $type = "支付宝" . $order['goods_describe'];
                    } else {
                        $type = "微信" . $order['goods_describe'];
                    }
                    $dataMessage = array(
                        'first' => array('value' => '账单支付成功'),
                        'keyword1' => array('value' => $order['order_id'], 'color' => '#173177'),
                        'keyword2' => array('value' => date("Y-m-d H:i:s", $paytime), 'color' => '#173177'),
                        'keyword3' => array('value' => $order['goods_price'], 'color' => '#173177'),
                        'keyword4' => array('value' => $type, 'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已使用支付宝支付成功。', 'color' => '#173177')
                    );
                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);
                }
            }
        }
    }

    // 支付宝收款异步通知
//    public function alicallback(){
//        file_put_contents('./alipaycallback.txt', json_encode($_POST));
//    }

    //银行接口异步回调
    public function banknotify()
    {
        $orderid = $_GET['orderNo'] ?: $_POST['orderNo'];
        if (empty($orderid)) {
            die("ERROR");
        }
        // 查询订单
        $order = M('cashier_order')->getOneOrder(array('order_id' => $orderid));
        if (empty($order)) {
            die("ERROR");
        }
        // 如果订单已处理
        if ($order['state'] != 0) {
            die("SUCCESS");
        }

        $mid = $order['mid'];
        require_once(ABS_PATH . "../MinShengBank.class.php");
        $bank = new MinShengBank();
        $mid = $order['mid'];
        // 查询订单所属商家
        $merchant = M('cashier_merchants')->get_one('mid=' . $mid, '*');

        $result = $bank->queryOrder($orderid, time());
        //Bug Log
        //问题： 数据库state 在数据库的state是tiny(1) 当订单状态TRADE_CLOSED 设置state 为-1失败导致超时未支付订单记录为成功支付
        //原if条件：$result['data']['trade_status'] == 'TRADE_SUCCESS' || $result['data']['trade_status'] == 'TRADE_CLOSED' || $result['data']['trade_status'] == 'TRADE_FINISHED'
        //解决办法： 不处理订单状态为TRADE_CLOSED的订单
        //理想解决办法：修改数据库的state 字段，但是影响过大，可能印象已有的查询！
        // 如果支付宝返回结果，则更新本地订单
        if ($result['origRespCode'] == "0000") {
            $state = 1;
            $paytime = time();
//            $updateData = array('ispay' => 1, 'state' => $state, 'openid' => $result['data']['buyer_user_id'], 'paytime' => $paytime, 'transaction_id' => $result['data']['trade_no']);
            $updateData = array('ispay' => 1, 'state' => $state, 'paytime' => $paytime,);
            $where = array(
                'order_id' => $orderid
            );
            $order_update = M('cashier_order')->update($updateData, $where);
            if ($order['pay_way'] == "alipay") {
                $type = "支付宝" . $order['goods_describe'];
                $type2 = "支付宝";
            } else {
                $type = "微信" . $order['goods_describe'];
                $type2 = "微信";
            }
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
                        'keyword4' => array('value' => $type, 'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已使用' . $type2 . '支付成功。', 'color' => '#173177')
                    );
                    //                        发送微信模板短信
                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);
                }
                //                    查出商户收银员对应的咕咕鸡ID (打印机id)
                $print_id = M('cashier_qrcode')->select(['eid' => $order['eid']], 'print_id,mid');
//                有打印机id才进入
                if (!empty($print_id[0]['print_id'])) {
                    //            根据mid查出对应的公司名称
                    $company=M('cashier_merchants')->select(['mid'=>$print_id[0]['mid']],'company');
//                根基eid查出对应营业员
                    $name=M('cashier_employee')->select(['eid'=>$order['eid']],'username');
                    if (preg_match('/^\d{10,11}/', $print_id[0]['print_id'])) {//为整数类型 就是真就调用易联云打印机
                        $this->yilianyunToken($print_id[0]['print_id'], $order['order_id'], $order['goods_price'], $type2,$company[0]['company'],$name[0]['username']);
                    } else {//为假就调用咕咕打印机
                        //                        调用打印机
                        $this->gugu($print_id[0]['print_id'], $order['order_id'], $order['goods_price'], $type2,$company[0]['company'],$name[0]['username']);
                    }
                }
            }
            die("SUCCESS");
        }
        file_put_contents('./banknotify2.txt', json_encode($_POST));
    }

    //银行接口同步回调
    public function bankreturn()
    {
        echo "银行接口同步回调";
        file_put_contents('./bankreturn2.txt', json_encode($_POST));
    }



    /**
     * 咕咕机打印配
     * @param $order_id  订单号
     * @param $goods_price  金额
     * @param $pay  支付方式
     * @param $print_id 打印机id
     * @param  $company  公司名称
     * @param  $name 营业员名称
     */
    public function gugu($print_id, $order_id, $goods_price, $pay,$company="" ,$name="")
    {

        //        设置咕咕机参数
        $ak = 'b6a5801aad8d4418ab3a4228a5cc484d';
        $timeStamp = str_replace(' ', '5%', date('Y-m-d H:i:s', time()));
        $memobirdID = $print_id;//姑姑机ID
        $useridentifying = time();
//                                        发送请求url地址
        $posturl = "http://open.memobird.cn/home/setuserbind?ak={$ak}&timestamp={$timeStamp}&memobirdID={$memobirdID}&useridentifying={$useridentifying}";
        $printdanju = file_get_contents($posturl);
        $printdanju = json_decode($printdanju, true);
        if ($printdanju['showapi_res_code'] == 1) {
            $time = str_replace(' ', '5%', date('Y-m-d H:i:s', time()));
            $paytime = date('Y-m-d H:i:s', time());
            $txt = "        订单付款成功通知 
                    
                                订单号:
                                {$order_id}
                                支付时间:{$paytime}
                                公司名称:{$company}
                                营业员:{$name}
                                支付金额:{$goods_price}
                                支付方式:{$pay}支付
                                -------云极付提供技术支持-------
                                          023-81380045
                    
                    
                    ";
//                        把文本输出的内容转化成GBK格式
            $GBK = iconv("UTF-8", "GB2312//IGNORE", $txt);
            $data = [
                'printcontent' => 'T:' . base64_encode($GBK),//在吧GBK格式的文本转化成base64编码的格式
                'userID' => $printdanju['showapi_userid'],
                'ak' => $ak,
                'timestamp' => $time,
                'memobirdID' => $memobirdID //咕咕鸡编号ID
            ];
//                        模拟post提交参数
            $datas = http_build_query($data);
            $opts = array(
                'http' => array(
                    'method' => 'POST',
                    'timeout' => 60,
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $datas
                )
            );
            $cxContext = stream_context_create($opts);
            $printurl = "http://open.memobird.cn/home/printpaper";
            $str = file_get_contents($printurl, false, $cxContext);
//            保存打印机打印状态
            $strs['card_title']=$str;
            $strs['card_id']=$memobirdID;
            M('cashier_wxcoupon')->insert($strs,true);

        }
    }

    /**
     * 易联云获取token
     */

    private function yilianyunToken($print_id, $order_id, $goods_price, $pay,$company,$name)
    {
        $client_id = '1059856816';
        $time = time();
        $id = strtoupper($this->create_uuid());
        $sign = strtolower(md5($client_id . $time . '500134680e02cd5895a303db27ccebf7'));
        $data = [
            'client_id' => $client_id,
            'grant_type' => 'client_credentials',
            'sign' => $sign,
            'scope' => 'all',
            'timestamp' => $time,
            'id' => $id
        ];
        $datas = http_build_query($data);
//                    dump($datas);exit();
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'timeout' => 60,
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $datas
            )
        );
        $cxContext = stream_context_create($opts);
        $printurl = "https://open-api.10ss.net/oauth/oauth";
        $str = file_get_contents($printurl, false, $cxContext);
        $str = json_decode($str, true);
        if ($str['error'] == '0') {
            $this->yilianyun($print_id, $order_id, $goods_price, $pay, $data, $str['body']['access_token'],$company,$name);
        }
    }

    /**
     * 易联云打印配置
     * @param $print_id  打印机id
     * @param $order_id  订单号
     * @param $goods_price  金额
     * @param $pay  支付方式
     * * @param  $company  公司名称
     * @param  $name 营业员名称
     */
    private function yilianyun($print_id, $order_id, $goods_price, $pay, $datas, $access,$company,$name)
    {
        $time = date('Y-m-d H:i:s', $datas['timestamp']);
        $txt = "        订单付款成功通知
                    
                                订单号:
                                {$order_id}
                                公司名称:{$company}
                                营业员:{$name}
                                支付时间:{$time}
                                支付金额:{$goods_price}
                                支付方式:{$pay}支付
                                -------云极付提供技术支持-------
                                          023-81380045
                   
                   
                    ";
        $data = [
            'client_id' => $datas['client_id'],//应用id
            'access_token' => $access,//第三方授权token
            'machine_code' => $print_id,//打印机id
            'content' => $txt,//打印的内容
            'origin_id' => time(),//订单号
            'sign' => $datas['sign'],
            'id' => $datas['id'],
            'timestamp' => $datas['timestamp']//打印时间

        ];
        $datas = http_build_query($data);
//                    dump($datas);exit();
        $opts = array(
            'http' => array(
                'method' => 'POST',
                'timeout' => 60,
                'header' => 'Content-type: application/x-www-form-urlencoded',
                'content' => $datas
            )
        );
        $cxContext = stream_context_create($opts);
        $printurl = "https://open-api.10ss.net/print/index";
        $str = file_get_contents($printurl, false, $cxContext);
    }

    /**
     * @param string $prefix
     * @return string
     * 封装uuid
     */
    function create_uuid($prefix = "")
    {    //可以指定前缀
        $str = md5(uniqid(mt_rand(), true));
        $uuid = substr($str, 0, 8) . '-';
        $uuid .= substr($str, 8, 4) . '-';
        $uuid .= substr($str, 12, 4) . '-';
        $uuid .= substr($str, 16, 4) . '-';
        $uuid .= substr($str, 20, 12);
        return $prefix . $uuid;
    }

    /**
     * 封装线上收款
     */

    public function onlineinfo()
    {
        $arrstr=$_GET;
        if (empty($arrstr['order_id'])) {
            $this->errorTip('订单号不能为空!');
        }
        if (empty($arrstr['money'])) {
            $this->errorTip('订单金额不能为空!');
        }
        //ewmid二维码id
        if ($_GET['ewmid']) {
            $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $_GET['ewmid'] . "'");
            if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {
//                if ($_GET['wxak'] == 'wx') {//判断是否是手机微信直接支付
//                    $data = ['success' => '1', 'mid' => $rows['mid'], 'eid' => $rows['eid'], 'storeid' => $rows['storesid']];
//                    echo json_encode($data);
//                    exit();
//                }
                header('Location:http://' . $_SERVER['HTTP_HOST'] . '/merchants.php?m=Index&c=pay&a=onlinepay&mid=' . $rows['mid'] . '&eid=' . $rows['eid'] . '&storeid=' . $rows['storesid']."&order_id={$arrstr['order_id']}&money={$arrstr['money']}");
            } else {
//                if ($_GET['wxak'] == 'wx') {//判断是否是手机微信直接支付
//                    $data = ['success' => '0','tips' => '该ewmid未绑定商户!' ];
//                    echo json_encode($data);
//                    exit();
//                }
                $this->errorTip('该二维码未绑定商户!');
            }
        } else {
            if ($_GET['wxak'] == 'wx') {//判断是否是手机微信直接支付
                $data = ['success' => '0','tips' => 'ewmid参数错误!' ];
                echo json_encode($data);
                exit();
            }
            $this->errorTip('参数错误!');
        }
    }


    /**
     * 封装线上支付
     */
    public function onlinepay()
    {
//        接收订单号
        $order_id=$_GET['order_id'];
//        接收订单金额
        $money=$_GET['money'];
        $mid = intval(trim($_GET['mid']));
        if (!0 < $mid) {
            $this->errorTips('参数出错，没有商家ID！');
            exit();
        }

        $eid = intval(trim($_GET['eid']));
        $storeid = intval(trim($_GET['storeid']));
//        if ($_GET['wxak']=='wx') {//判断手机直接商场支付
//            查询直接支付的参数是否正确
//            $res=M('cashier_qrcode')->select(['eid'=>$eid,'mid'=>$mid,'storesid'=>$storeid],'*');
//            if (!$res) {//查出数据不存在在执行
//                $str=['success'=>0,'tips'=>'参数错误'];
//                echo json_encode($str);
//                exit();
//            }
//        }
        $company = M('cashier_merchants')->get_one('mid=' . $mid, 'company');
            $ename = M('cashier_employee')->get_one('eid=' . $eid, 'username');
            $branch_name = M('cashier_stores')->get_one('id=' . $storeid, '*');
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

                //            $_SESSION['my_Cashier_openid'] = "otqnZwSOS9_F9B9bMixKG_UHVaRs";
                if ($this->is_wexin_browser && empty($_SESSION['my_Cashier_openid'])) {
                    $redirecturl = $this->SiteUrl . '/' . $_SERVER['REQUEST_URI'];
                    $retrunarr = $wxCardPack->authorize_openid($redirecturl);
                }

            /**
             *  获取微信信息
             */
            $wxuserinfo = array();
            if ($this->is_wexin_browser && !empty($_SESSION['my_Cashier_openid'])) {
                //接口开发
                if ($_GET['wxak'] == 'wx') {
                    $data = ['success' => '1', 'openId' => $_SESSION['my_Cashier_openid']];
                    echo json_encode($data);
                    exit();
                }
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
        // 判断用户浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'icroMessenger') !== false) {
//           微信打开模拟post提交

            echo "<form style='display:none;' id='form1' name='form1' method='post' action='https://pay.yunjifu.net/Cashier/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=auto'>
              <input name='goods_price' type='text' value='$money' />
              <input name='mid' type='text' value='{$_GET['mid']}'/>
              <input name='goods_name' type='text' value='消费商品'/>
              <input name='eid' type='text' value='{$eid}'/>
              <input name='storeid' type='text' value='{$storeid}'/>
              <input name='paytype' type='text' value='weixin'/>
            </form>
            <script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";


        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
//           支付宝打开
            echo "<form style='display:none;' id='form1' name='form1' method='post' action='https://pay.yunjifu.net/merchants.php?m=Index&c=pay&a=alitradepay'>
              <input name='goods_price' type='text' value='$money' />
              <input name='mid' type='text' value='{$_GET['mid']}'/>
              <input name='goods_name' type='text' value='消费商品'/>
              <input name='eid' type='text' value='{$eid}'/>
              <input name='storeid' type='text' value='{$storeid}'/>
              <input name='paytype' type='text' value='alipay'/>
            </form>
            <script type='text/javascript'>function load_submit(){document.form1.submit()}load_submit();</script>";
        }
    }




    /*
     * 扫码枪支付接口
     */
    public function scaner()
    {
        //将$_POST赋值给$POST，方便下面代码使用
        $POST=$_POST;
        //二维码ID
        $qrcode_id=$POST['appid'];
        //获取二维码信息
        $mtype=M('cashier_qrcode')->select(['qrcode_id'=>$qrcode_id]);
        if($mtype){
            //获取商户mid
            $mid=$mtype[0]['mid'];
            if($mid==0){
                $data['respCode']='403';
                $data['respDesc']='此APPID暂无交易权限';
            }
            else{
                //订单ID
                $where['order_id']='44' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
                //商户MID
                $where['mid']=$mid;
                //商户门店ID
                $where['storeid']=$mtype[0]['storesid'];
                //商户员工ID
                $where['eid']=$mtype[0]['eid'];
                //商品类型
                $where['goods_type']=$POST['goods_type'] ?:'unlimit';
                //商品ID
                $where['goods_id']==$POST['goods_id']?:'1';
                //商品名称
                $where['goods_name']=$POST['goods_name']?:'消费商品';
                //支付方式
                $where['goods_describe']='条码支付';
                //商品价格
                $where['goods_price']=$POST['price'];
                //订单创建时间
                $where['add_time']=strtotime(date("Y-m-d H:i:s",time()));
                //不晓得这是怎么，传一个空格进去
                $where['truename']=' ';
                //用户openid扫码枪扫码不能获取，传入一个空格
                $where['openid']=' ';
                //退款结果数据，不晓得哪个SB设计的不能为空
                $where['refundtext']=' ';
                //不晓得是什么卵
                $where['p_openid']=' ';
                //原商品订单号，需返回给商家进行对账
                $where['out_trade_no']=$POST['order_id']?:' ';
                //业务员佣金
                $where['salesmans_price']=0;
                //代理商佣金
                $where['agent_price']=0;
                //支付宝商户门店编号
                $storeId=$mtype[0]['storesid'];
                //支付宝商户机具终端编号
                $terminalId='T'.$mtype[0]['storesid'];
                //调用微信支付API的机器IP
                $wxip=$POST['spbill_create_ip'];
                //授权支付码（条形码）
                $authcode=$POST['auth_code'];
                //授权支付码前两位数字
                $number=substr($authcode,0,2);
                /*正则判断是微信支付还是支付宝支付
                 * 微信是以10、11、12、13、14、15开头的数字
                 * 支付宝是以25、26、27、28、29、30开头的数字
                 */
                //微信验证
                $weixin=preg_match('/^1[012345]$/',$number);
                //支付宝验证
                $alipay=preg_match('/^2[056789]$/',$number);
                //支付途径和方式
                if($weixin){
                    $where['pay_way']='weixin';
                    $where['pay_type']='wxJSAPI';
                    $productId='0106';
                }
                if($alipay){
                    $where['pay_way']='alipay';
                    $where['pay_type']='tradepay';
                    $productId='0110';
                }
                //获取商户走的是银行通道还是官方通道
                $mtype=M('cashier_merchants')->select(['mid'=>$mid],'mtype');
                $where['mchtype']=$mtype[0]['mtype'];
                $orderResult = M('cashier_order')->insert($where);
                if($orderResult){
                    //银行通道商户
                    if($mtype[0]['mtype']==2){
                        require_once(ABS_PATH . "../MinShengBank.class.php");
                        $bank = new MinShengBank();
                        $payConfig = M('cashier_payconfig')->get_one(array('mid' => 1), 'configData');
                        $payConfigData = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                        $wechatAppId = $payConfigData['weixin']['sub_mch_id_two'];
                        $dataCreate = [
                            'productId' => $productId,
                            'transId' => '10',
                            'orderNo' => $where['order_id'],
                            'returnUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/Cashier/pay/bankreturn.php',
                            'notifyUrl' => 'https://' . $_SERVER['SERVER_NAME'] . '/Cashier/pay/banknotify.php',
                            'transAmt' => $where['goods_price'] * 100,
                            'commodityName' => $where['goods_name'],
                            'subMerNo' => $wechatAppId,
                            'subMerName' => "重庆云极付科技有限公司",
                            'subChnlMerNo' => $wechatAppId,
                            'authCode'=>$authcode,
                            'storeId'=>$storeId,
                            'terminalId'=>$terminalId
                        ];
                        $result = $bank->createOrder($dataCreate);
                        if($result['respCode']=="0000"){
                            //应答码
                            $data['respCode']=$result['respCode'];
                            //应答码描述
                            $data['respDesc']=$result['respDesc'];
                            //交易单号
                            $data['orderNo']=$result['orderNo'];
                            //原商品交易单号
                            $data['out_trade_no']=$where['out_trade_no'];
                            //交易金额
                            $data['transAmt']=$result['transAmt'];
                            //商品名称
                            $data['commodityName']=$result['commodityName'];
                            //支付完成时间
                            $data['payTime']=$result['payTime'];
                        }
                        if($result['respCode']=="P000"){
                            //应答码
                            $data['respCode']=$result['respCode'];
                            //应答码描述
                            $data['respDesc']='交易处理中，请调用查询接口查询支付结果';
                        }
                        if($result['respCode']=="9997"){
                            //应答码
                            $data['respCode']=$result['respCode'];
                            //应答码描述
                            $data['respDesc']='交易结果未知，请调用查询接口查询支付结果';
                        }
                        else{
                            //应答码
                            $data['respCode']='E0002';
                            //应答码描述
                            $data['respDesc']='交易失败';
                        }
                    }
                    //官方通道商户
                    else{
                        //微信支付
                        if($weixin){
                            //32位随机数生成开始
                            $arr=['ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'];
                            $nonce_str='';
                            for($i=0;$i<32;$i++){
                                $nonce_str.=$arr[rand(0,1)];
                            }
                            //32位随机数生成结束
                            bpBase::loadAppClass('weixinPay', 'Index', 0);
                            //微信商户号
                            $payConfig = M('cashier_payconfig')->get_one(array('mid' => $mid), 'configData');
                            $payConfigData = unserialize(htmlspecialchars_decode($payConfig['configData'], ENT_QUOTES));
                            $mch_id = $payConfigData['weixin']['mchid'];
                            //实例化微信类
                            $weixinPay = new weixinPay();
                            $data['appid']='';
                            $data['mch_id']=$mch_id;
                            $data['nonce_str']=$nonce_str;
                            $data['body']=$where['goods_name'];
                            $data['out_trade_no']=$where['order_id'];
                            $data['total_fee']=$where['goods_price'];
                            $data['spbill_create_ip']=$wxip;
                            $data['auth_code']=$authcode;
                            $result = $weixinPay->micropay($data);
                            if($result['return_code']=='SUCCESS'&&$result['result_code']=='SUCCESS'){
                                //应答码
                                $data['respCode']='0000';
                                //应答码描述
                                $data['respDesc']='交易成功';
                                //交易单号
                                $data['orderNo']=$result['out_trade_no'];
                                //原商品交易单号
                                $data['out_trade_no']=$where['out_trade_no'];
                                //交易金额
                                $data['transAmt']=$result['total_fee'];
                                //商品名称
                                $data['payTime']=$result['time_end'];
                            }
                            else{
                                //应答码
                                $data['respCode']='E0002';
                                //应答码描述
                                $data['respDesc']='交易失败';
                            }
                        }
                        //支付宝支付
                        if($alipay){
                            // 获取云极付支付宝支付配置
                            $alipayConf = M('cashier_payconfig')->get_one(array('id' => 1), 'configData');
                            $payconfig_data = unserialize(htmlspecialchars_decode($alipayConf['configData'], ENT_QUOTES));
                            $order = array(
                                'orderid' => $where['order_id'],
                                'amount' => $where['goods_price'],
                                'subject' => $where['goods_name'],
                                'body' => $where['goods_name'],
                                'operatorid' => $where['eid'],
                                'storeid' => $where['storeid'],
                                'auth_code'=>$authcode,
                                'pid' => $payconfig_data['alipay']['pid']
                            );
                            bpBase::loadOrg('alipayHelper');
                            $alipayhelper = new alipayHelper($payconfig_data);
                            $result = $alipayhelper->alipayTradePay($order);
                            if (!$result['success']) {
                                //应答码
                                $data['respCode']='E0002';
                                //应答码描述
                                $data['respDesc']='交易失败';
                            } else {
                                //应答码
                                $data['respCode']='0000';
                                //应答码描述
                                $data['respDesc']='交易成功';
                                //交易单号
                                $data['orderNo']=$result['out_trade_no'];
                                //原商品交易单号
                                $data['out_trade_no']=$where['out_trade_no'];
                                //交易金额
                                $data['transAmt']=$result['total_amount'];
                                //商品名称
                                $data['commodityName']=$where['goods_name'];
                                //支付完成时间
                                $data['payTime']=$result['gmt_payment'];
                            }
                        }
                    }
                }
                else{
                    $data['respCode']='E0000';
                    $data['respDesc']='创建订单失败';
                }
            }
        }
        else{
            $data['respCode']='E0001';
            $data['respDesc']='APPID错误';
        }
        //以json的方式返给接入方
        echo json_encode($data,true);
    }


    /*
     * 扫码枪支付结果查询接口
     */
    public function scanerOrder()
    {
        //将$_POST赋值给$POST，方便下面代码使用
        $POST=$_POST;
        //二维码ID
        $qrcode_id=$POST['appid'];
        //获取二维码信息
        $mtype=M('cashier_qrcode')->select(['qrcode_id'=>$qrcode_id]);
        if($mtype) {
            //订单号
            $orderid = $POST['order_id'];
            //金额
            $price=$POST['price'];
            //支付时间
            $paytime=$POST['paytime'];
            //订单号为空返回状态
            if (empty($orderid)) {
                $data['respCode'] = 'N1000';
                $data['respDesc'] = '订单号不能为空';
            }
            // 查询订单
            $order = M('cashier_order')->getOneOrder(array('out_trade_no' => $orderid,'income'=>$price,'paytime'=>$paytime));
            //订单不存在返回状态
            if (empty($order)) {
                $data['respCode'] = 'N1001';
                $data['respDesc'] = '订单不存在';
            }
            // 如果订单已处理
            if ($order['state'] == 2) {
                $data['respCode'] = 'N1002';
                $data['respDesc'] = '订单已结算';
            }
            //如果订单已付款且未结算
            if($order['state'] == 1 && $order['ispay'] == 1){
                //应答码
                $data['respCode'] = '0000';
                //应答码描述
                $data['respDesc'] = '交易成功';
                //交易单号
                $data['trade_no'] = $order['order_id'];
                //原商品交易单号
                $data['out_trade_no'] = $order['out_trade_no'];
                //交易金额
                $data['transAmt'] = $order['income'];
                //商品名称
                $data['commodityName'] = $order['goods_name'];
                //支付完成时间
                $data['payTime'] = $order['paytime'];
            }
            //如果订单未付款
            if($order['ispay'] == 0)
            {
                //应答码
                $data['respCode'] = 'E0002';
                //应答码描述
                $data['respDesc'] = '交易失败';
            }
        }
        else{
            $data['respCode']='E0001';
            $data['respDesc']='APPID错误';
        }
        //以json的方式返给接入方
        echo json_encode($data,true);
    }


    public function test(){
        require_once(ABS_PATH . "../MinShengBank.class.php");
        $bank = new MinShengBank();

    }
}



?>
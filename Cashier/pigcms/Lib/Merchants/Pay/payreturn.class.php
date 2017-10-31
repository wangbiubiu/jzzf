<?php
bpBase::loadAppClass('base', '', 0);

class payreturn_controller extends base_controller
{
    public function __construct()
    {
        parent::__construct();
        $session_storage = getSessionStorageType();
        bpBase::loadSysClass($session_storage);
    }

    public function return_url()
    {
        bpBase::loadOrg('WxSaoMaPay/WxPayPubHelper');
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];
        //file_put_contents('./44.txt',$xml);
        //$xml = file_get_contents('http://www.qugoubao.cn/Cashier/pay/wxpay/44.txt');

        $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

        if (($array_data['return_code'] == 'SUCCESS') && ($array_data['result_code'] == 'SUCCESS')) {
            $notifyData['appid'] = $array_data['appid'];
            $notifyData['mch_id'] = $array_data['mch_id'];
            $notifyData['sub_appid'] = ((isset($array_data['sub_appid']) ? $array_data['sub_appid'] : ''));
            $notifyData['sub_mch_id'] = ((isset($array_data['sub_mch_id']) ? $array_data['sub_mch_id'] : ''));
            $notifyData['total_fee'] = $array_data['total_fee'];
            $notifyData['trade_type'] = $array_data['trade_type'];
            $notifyData['transaction_id'] = $array_data['transaction_id'];
            $notifyData['order_id'] = $array_data['out_trade_no'];
            $notifyData['openid'] = ((isset($array_data['openid']) ? $array_data['openid'] : ''));
            $notifyData['sub_openid'] = ((isset($array_data['sub_openid']) ? $array_data['sub_openid'] : ''));
            $notifyData['ordid'] = ((isset($array_data['ordid']) ? $array_data['ordid'] : 0));
            $notifyData['mid'] = ((isset($array_data['merid']) ? $array_data['merid'] : 0));
            $notifyData['is_subscribe'] = ((strtoupper(trim($array_data['is_subscribe'])) == 'Y' ? 1 : 0));

            if (0 < $notifyData['mid']) {
                $orderDb = M('cashier_order');
                (0 < $notifyData['ordid']) && $where['id'] = $notifyData['ordid'];
                $where['mid'] = $notifyData['mid'];
                $where['order_id'] = $notifyData['order_id'];
                $orderTmp = $orderDb->get_one($where, '*');

                if ($orderTmp['ispay'] == 1) {
                    echo '<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>';
                    exit();
                }


                if (!empty($notifyData['sub_mch_id']) && !empty($notifyData['sub_openid'])) {
                } else {
                }

                $tmpopenid = $notifyData['openid'];
                $p_openid = ((!empty($notifyData['sub_mch_id']) ? $notifyData['openid'] : ''));

                if (!empty($notifyData['sub_mch_id']) && !empty($notifyData['sub_appid'])) {
                } else {
                }

                $tmpappid = $notifyData['appid'];
                $wxuserinfo = array();
                bpBase::loadOrg('wxCardPack');
                $wx_user = M('cashier_payconfig')->getwxuserConf($notifyData['mid']);

                if (!empty($notifyData['sub_mch_id']) && isset($wx_user['submchinfo']) && ($notifyData['mid'] == $wx_user['submchinfo']['mid'])) {
                    $wxCardPack = new wxCardPack($wx_user['submchinfo'], $notifyData['mid']);
                } else {
                    $wxCardPack = new wxCardPack($wx_user, $wx_user['mid']);
                }

                $access_token = $wxCardPack->getToken();
                $wxuserinfo = $wxCardPack->GetwxUserInfoByOpenid($access_token, $tmpopenid);
                $paytime = time();
                $updateData = array('ispay' => 1, 'state' => 1, 'openid' => $tmpopenid, 'p_openid' => $p_openid, 'paytime' => $paytime, 'transaction_id' => $notifyData['transaction_id']);


                isset($wxuserinfo['nickname']) && $updateData['truename'] = $wxuserinfo['nickname'];
                $order_update = $orderDb->update($updateData, $where);
                //模版消息推送
                if ($order_update) {
                    $employee_openid = M('cashier_employee')->get_one(array('eid' => $orderTmp['eid']), 'openid');
                    bpBase::loadOrg('WxAuth');
                    $wx_user_one = M('cashier_key_values')->get_one(array('name' => 'wxconfig'));
                    $wx_user_one = json_decode($wx_user_one['value'], true);
                    $WxAuth = new WxAuth($wx_user_one['appid'], $wx_user_one['appSecret']);
                    $dataMessage = array(
                        'first' => array('value' => '账单支付成功'),
                        'keyword1' => array('value' => $orderTmp['order_id'], 'color' => '#173177'),
                        'keyword2' => array('value' => date("Y-m-d H:i:s", $paytime), 'color' => '#173177'),
                        'keyword3' => array('value' => $orderTmp['goods_price'], 'color' => '#173177'),
                        'keyword4' => array('value' => $orderTmp['goods_describe'], 'color' => '#173177'),
                        'remark' => array('value' => '你好，顾客已支付成功。', 'color' => '#173177')
                    );
                    //                    查出商户收银员对应的咕咕鸡ID (打印机id)
                    $print_id = M('cashier_qrcode')->select(['eid' => $orderTmp['eid']], 'print_id,mid');
//                    查询出打印机id 不能为空才进入一下方法
                    if (!empty($print_id[0]['print_id'])) {
                        //            根据mid查出对应的公司名称
                        $company=M('cashier_merchants')->select(['mid'=>$print_id[0]['mid']],'company');
//                根基eid查出对应营业员
                        $name=M('cashier_employee')->select(['eid'=>$orderTmp['eid']],'username');
                        if (preg_match('/^\d{10,11}/', $print_id[0]['print_id'])) {//为整数类型 就是真就调用易联云打印机
                            $this->yilianyunToken($print_id[0]['print_id'], $orderTmp['order_id'], $orderTmp['goods_price'], '微信',$company[0]['company'],$name[0]['username']);
                        } else {//为假就调用咕咕打印机
                            //                        调用打印机
                            $this->gugu($print_id[0]['print_id'], $orderTmp['order_id'], $orderTmp['goods_price'], '微信',$company[0]['company'],$name[0]['username']);
                        }
                    }
                    $a = $WxAuth->sendTemplateMessage($employee_openid['openid'], '1Z9OTmsEHTpq7eq7n_6RIsMWdW-ZQm-SEMJXggWlqIw', $dataMessage);
                }
                $fansDb = M('cashier_fans');
                $useridStr = $tmpopenid;

                if (!empty($tmpopenid)) {
                    $tmpfans = $fansDb->get_one(array('openid' => $tmpopenid, 'mid' => $notifyData['mid']), '*');
                    $fansData = array('appid' => $tmpappid, 'totalfee' => $notifyData['total_fee'], 'is_subscribe' => 0);

                    if (isset($wxuserinfo['nickname'])) {
                        $fansData['nickname'] = $wxuserinfo['nickname'];
                        $fansData['sex'] = $wxuserinfo['sex'];
                        $fansData['province'] = $wxuserinfo['province'];
                        $fansData['city'] = $wxuserinfo['city'];
                        $fansData['country'] = $wxuserinfo['country'];
                        $fansData['headimgurl'] = $wxuserinfo['headimgurl'];
                        $fansData['groupid'] = $wxuserinfo['groupid'];
                        $fansData['is_subscribe'] = 1;
                    }


                    if (isset($fansData['nickname']) && !empty($fansData['nickname'])) {
                    } else {
                    }

                    $useridStr = $useridStr;

                    if (!empty($tmpfans) && is_array($tmpfans)) {
                        $fansData['totalfee'] = $fansData['totalfee'] + $tmpfans['totalfee'];
                        $fansDb->update($fansData, array('id' => $tmpfans['id']));
                    } else {
                        $fansData['mid'] = $notifyData['mid'];
                        $fansData['openid'] = $tmpopenid;
                        $fansDb->insert($fansData, true);
                    }

                    unset($fansData);
                    $yuanprice = $notifyData['total_fee'] / 100;
                    M('cashier_wxcoupon')->cardbonus(array('openid' => $tmpopenid, 'price' => $yuanprice, 'msg' => '微信支付', 'fromid' => 0));
                }


                if (!empty($p_openid) && isset($wx_user['p_mid']) && isset($wx_user['submchinfo'])) {
                    $pwxCardPack = new wxCardPack($wx_user, $wx_user['p_mid']);
                    $paccess_token = $pwxCardPack->getToken();
                    $pwxuserinfo = $pwxCardPack->GetwxUserInfoByOpenid($paccess_token, $p_openid);
                    $ptmpfans = $fansDb->get_one(array('openid' => $p_openid, 'mid' => $wx_user['p_mid']), '*');
                    $fansData = array('appid' => $wx_user['appid'], 'totalfee' => $notifyData['total_fee'], 'is_subscribe' => 0);

                    if (isset($pwxuserinfo['nickname'])) {
                        $fansData['nickname'] = $pwxuserinfo['nickname'];
                        $fansData['sex'] = $pwxuserinfo['sex'];
                        $fansData['province'] = $pwxuserinfo['province'];
                        $fansData['city'] = $pwxuserinfo['city'];
                        $fansData['country'] = $pwxuserinfo['country'];
                        $fansData['headimgurl'] = $pwxuserinfo['headimgurl'];
                        $fansData['groupid'] = $pwxuserinfo['groupid'];
                        $fansData['is_subscribe'] = 1;
                    }


                    if (isset($fansData['nickname']) && !empty($fansData['nickname'])) {
                    } else {
                    }

                    $useridStr = $useridStr;

                    if (!empty($ptmpfans) && is_array($ptmpfans)) {
                        $fansData['totalfee'] = $fansData['totalfee'] + $ptmpfans['totalfee'];
                        $fansDb->update($fansData, array('id' => $ptmpfans['id']));
                    } else {
                        $fansData['mid'] = $wx_user['p_mid'];
                        $fansData['openid'] = $p_openid;
                        $fansDb->insert($fansData, true);
                    }

                    $yuanprice = $notifyData['total_fee'] / 100;
                    M('cashier_wxcoupon')->cardbonus(array('openid' => $p_openid, 'price' => $yuanprice, 'msg' => '微信支付', 'fromid' => 0));
                }


                if (isset($orderTmp['extrainfo']) && !empty($orderTmp['extrainfo'])) {
                } else {
                }

                $receivecard = '';

                if (!empty($receivecard) && is_array($receivecard)) {
                    if (isset($receivecard['cf']) && ($receivecard['cf'] == 'wapvcard') && (0 < $receivecard['uid'])) {
                        $updatelocmbpayrecord = array('paytime' => time(), 'paid' => 1);
                        M('cashier_locmbpayrecord')->update($updatelocmbpayrecord, array('ordid' => $orderTmp['id'], 'mid' => $orderTmp['mid'], 'paytype' => 'cardRecharge'));
                        $locmbcard = M('cashier_locmbcard')->get_one(array('id' => $receivecard['cdid'], 'mid' => $orderTmp['mid']), 'id,isdonate');
                        $updatemony = $orderTmp['goods_price'];
                        $updatescore = 0;

                        if ($locmbcard['isdonate'] == 1) {
                            $donate = M('cashier_locmbdonate')->get_one(array('mid' => $orderTmp['mid'], 'cdid' => $receivecard['cdid'], 'isopen' => 1), '*');

                            if (!empty($donate) && (0 < $donate['minmoney']) && ($donate['minmoney'] <= $orderTmp['goods_price'])) {
                                if ((0 < $donate['maxmoney']) && ($orderTmp['goods_price'] <= $donate['maxmoney'])) {
                                    $updatemony = $updatemony + $donate['donatemoney'];
                                } else if (!0 < $donate['maxmoney']) {
                                    $updatemony = $updatemony + $donate['donatemoney'];
                                }

                            }

                        }


                        $userinfoDb = M('cashier_userinfo');
                        $userinfo = $userinfoDb->get_one(array('id' => $receivecard['uid']), '*');
                        $userinfo['balance'] = $userinfo['balance'] + $updatemony;
                        $tmpf = $userinfoDb->update(array('balance' => $userinfo['balance']), array('id' => $userinfo['id']));

                        if (!$tmpf) {
                            $userinfoDb->update(array('balance' => $userinfo['balance']), array('id' => $userinfo['id']));
                        }

                    } else if (isset($receivecard['receiveid']) && (0 < $receivecard['receiveid'])) {
                        $receiveid = $receivecard['receiveid'];
                        $cardid = $receivecard['cardid'];
                        $mid = $receivecard['mid'];
                        $ucid = $receivecard['ucid'];
                        $storeid = $receivecard['storeid'];
                        $receiveDb = M('cashier_wxcoupon_receive');
                        $receiveArr = $receiveDb->get_one(array('id' => $receiveid), '*');
                        $updateData = array('status' => 1, 'consumetime' => time());

                        if (empty($receiveArr['outerid'])) {
                            $updateData['outerid'] = $notifyData['mid'];
                        }


                        if (empty($receiveArr['storeid'])) {
                            $updateData['storeid'] = $storeid;
                        }


                        $receiveDb->update($updateData, array('id' => $receiveid));
                        $wxcouponDb = M('cashier_wxcoupon');
                        if (strpos($receiveArr['cardid'], 'ocalCardid') && ($receiveArr['consumesource'] == 'LOCAL')) {
                            $tempcardid = explode('_', $receiveArr['cardid']);
                            $wxcouponID = $tempcardid[1];
                            $wxcouponTmp = $wxcouponDb->get_one(array('id' => $wxcouponID, 'mid' => $notifyData['mid'], 'card_id' => 'localCard_id'), '*');
                            $consumenum = $wxcouponTmp['consumenum'] + 1;
                            $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wxcouponTmp['id']));
                        } else {
                            $wxcouponTmp = $wxcouponDb->get_one(array('card_id' => $receiveArr['cardid'], 'mid' => $notifyData['mid']), '*');
                            $consumenum = $wxcouponTmp['consumenum'] + 1;
                            $wxcouponDb->update(array('consumenum' => $consumenum), array('id' => $wxcouponTmp['id']));
                            $vrets = $wxCardPack->wxCardConsume($access_token, '{"code":"' . $receiveArr['cardcode'] . '","card_id":"' . $receiveArr['cardid'] . '"}');
                        }

                        if (0 < $ucid) {
                            $ucenterDb = M('cashier_ucenter');
                            $ucenterArr = $ucenterDb->get_one(array('id' => $ucid), '*');
                            $paymoney = ((isset($ucenterArr['paymoney']) ? $ucenterArr['paymoney'] + ($notifyData['total_fee'] / 100) : $notifyData['total_fee'] / 100));
                            $paycount = ((isset($ucenterArr['paymoney']) ? $ucenterArr['paycount'] + 1 : 1));
                            $updateData = array('paymoney' => $paymoney, 'paycount' => $paycount);
                            $ucenterDb->update($updateData, array('id' => $ucid));
                        }

                    }

                }


                bpBase::loadOrg('orderPrint');
                $pt = new orderPrint();
                $tmpMer = $this->getMerBymid($orderTmp['mid']);
                $printvars = array('mername' => $tmpMer['wxname']);
                empty($printvars['mername']) && !empty($tmpMer['weixin']) && $printvars['mername'] = $tmpMer['weixin'];

                if (0 < $orderTmp['storeid']) {
                    $tmpStore = $this->getStoreByid($orderTmp['storeid'], $orderTmp['mid']);
                    $printvars['storename'] = ((!empty($tmpStore) ? $tmpStore['business_name'] . $tmpStore['branch_name'] : ''));
                } else {
                    $printvars['storename'] = '';
                }

                $printvars['user'] = $useridStr;
                $printvars['paydesc'] = $orderTmp['goods_name'];
                $printvars['buytime'] = date('Y-m-d H:i:s', $orderTmp['add_time']);
                $printvars['mprice'] = $orderTmp['goods_price'];
                $printvars['orderid'] = $orderTmp['order_id'];
                $printvars['paytype'] = '微信支付';
                $printvars['printtime'] = date('Y-m-d H:i:s');
                $pt->printit($printvars, $orderTmp['mid'], $orderTmp['storeid']);

                if ($orderTmp['goods_type'] == 'apppay') {
                    bpBase::loadOrg('JPush/JPush');
                    $client = new JPush(JPUSH_AppKey, JPUSH_MasterSecret, NULL);
                    $jpush = $client->push();
                    $jpush->setPlatform('all');

                    if (!empty($orderTmp['extrainfo'])) {
                        $jpush->addAlias($orderTmp['extrainfo']);
                    } else {
                        $jpush->setAudience('all');
                    }

                    $result = $jpush->setNotificationAlert('支付通知')->addAndroidNotification('支付成功', '支付通知', 1, array('ispay' => 1, 'mid' => $orderTmp['mid'], 'storeid' => $orderTmp['storeid'], 'eid' => $orderTmp['eid'], 'paytime' => date('Y-m-d H:i', SYS_TIME), 'mprice' => $orderTmp['goods_price'], 'paytype' => '微信支付', 'orderid' => $orderTmp['order_id']))->addIosNotification('支付成功', 'default', 1, true, NULL, array('ispay' => 1, 'mid' => $orderTmp['mid'], 'storeid' => $orderTmp['storeid'], 'eid' => $orderTmp['eid'], 'paytime' => date('Y-m-d H:i', SYS_TIME), 'mprice' => $orderTmp['goods_price'], 'paytype' => '微信支付', 'orderid' => $orderTmp['order_id']))->setOptions(NULL, 60, NULL, true)->send();
                }

            }


            echo '<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>';
            exit();
        }


        echo '<xml><return_code><![CDATA[SUCCESS]]></return_code></xml>';
        exit();
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


}

?>
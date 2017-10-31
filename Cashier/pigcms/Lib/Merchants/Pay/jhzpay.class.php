<?php
bpBase::loadAppClass('base', '', 0);
//金海哲支付接口类
class jhzpay_controller extends base_controller
{
    //金海哲支付方法
    private function jhzpay($amount,$paymethod,$remark,$order_id){
        $public_key = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQCL4nMv6qK7Lt1MzfK20LrVd/0g0pXIvV281sT16s4xIWEg/Hfv0su0MHdbTobZfHcziyO/xdmItCzkcJOIIskuC3QukNrWnt7kf1wZ1OmIMWAcS5s9wnMd0QcpDpcyfZfJvlZgFDtgJtApXvCBBVIEX65W1FnmlZ7wccO3Ca+J8QIDAQAB
-----END PUBLIC KEY-----";
// 密钥必须按照以下格式
        $private_key = '-----BEGIN PRIVATE KEY-----
MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAJ2TUM67PRRJPXyi7idveSFot5KcSsqHFsvtfXTgq4W7MY/IeUgdsIGosU+s2iTGXxHbYtjnI6H6HG8Tk9hJs/KF5kMD+V384bnmPi7q/Q5CzkFP0JE7laindmm1DehIkMLAExU+fklylyC+16UCIN4yxk3CtMuv0e0IKicne5S9AgMBAAECgYEAhZ5G9pa1i38zoX2zv0L6j0bx62OW1DhLL2/aY4KkT8lVlJwlo+5xHvGCMZLchDSmp0jGgDE3+QFSnSoXw190M4Oq6VXX9bLCVRSekRQfIzMxCPEQ0FB5PDVZinGaQvOvYbhGru3Bgo1mMZrr+gAidcI1Ns5qj4csginpSZIpqwECQQD/dVLOLNnywyatYRzGpmOdwml+Rsav60fv3bkMTfxCyk7ls6LEhkiCmeFOH9fTeJjzoT0bzzGQFTBXBSQEFi19AkEAnejbKffIWyOs3yOEA0WObZUP/FpJYr0GzvGQtRxFhzQ5kDI9+5TSuZUZJT8CQPwSyuhiAo5v5ZyRZcw20ACoQQJBALPXqvYPSVjI3p/M8G9BkHvt9Eq8FQCgSUKq+62X8XIr7yNzNbHZP48COkW/0TfFfRh3eQfs892VrTR2IAbofhkCQE7V5S0jrpyJyBGy+oJjpILjC5MSRFcORirlATjaP4ALu71YyAclOrs6S86DkY1+C6fPsrbSA91feFuZQ7g+y8ECQCA8phM6B0VoRzTueDZdHgZy3039BH0HaUAnrcC+QSok+yFlQwDdU+Eoee6iSssYWe3BnCb5IINiDxAt2yl7a0Q=
-----END PRIVATE KEY-----';
//支付系统网关地址
        $pay_url = "http://zf.szjhzxxkj.com/ownPay/pay";
// 请求数据赋值
        $data = "";
        $data['merchantNo'] = '500008170689'; //商户号
        $data['requestNo'] =  $order_id; //支付流水
        $data['amount'] = $amount;//金额（分）
        $data['payMethod'] = $paymethod;//业务编号
        /*
        6001 微信扫码
        6011 QQ扫码
        6002 网银支付
        6003 支付宝扫码
        6004 微信公众号
        6005 微信WAP
        6006 无卡支付
        6007 点卡销卡接口
        6008 支付宝H5
        6009 微信APP支付
        6010 京东扫码
        */
        $data['backUrl'] = $this->SiteUrl . '/merchants.php?m=pay&c=jhzpay&a=success';   //页面返回URL
        $data['pageUrl'] = 'http://www.baidu.com';   //服务器返回URL
        $data['payDate'] = time();   //支付时间，必须为时间戳
        $data['remark1'] = $remark;

        $signature=$data['merchantNo']."|".$data['requestNo']."|".$data['amount']."|".$data['pageUrl']."|".$data['backUrl']."|".$data['payDate']."|".$data['agencyCode']."|".$data['remark1']."|".$data['remark2']."|".$data['remark3'];

////////////////////////
        $pr_key ='';
        if(openssl_pkey_get_private($private_key)){
            $pr_key = openssl_pkey_get_private($private_key);

        }else{
            echo json_encode(array("msg"=>"","code"=>"4005"));
            exit();
        }

        $pu_key = '';
        if(openssl_pkey_get_public($public_key)){
            $pu_key = openssl_pkey_get_public($public_key);
        }else{
            echo json_encode(array("msg"=>"","code"=>"4007"));
            exit();
        }

        $sign = '';

//openssl_sign(加密前的字符串,加密后的字符串,密钥:私钥);
        openssl_sign($signature,$sign,$pr_key);


        openssl_free_key($pr_key);

        $sign = base64_encode($sign);

        $data['signature'] = $sign;
        $ch = curl_init();
        if(!$flag)
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_URL, $pay_url);
        $response =  curl_exec($ch);
//  echo '请求成功：'.$response;
        curl_close($ch);

        $str = stripslashes($response);
//转成Array
        $arr = json_decode($str,true);
//转成json
        $php_json = json_encode($response);

//获取返回字符串sign
        $resultsign=$arr['sign'];
//从arr去掉sign
        unset($arr['sign']);
//去掉斜杠
        $original_str=stripslashes(json_encode($arr));
        $result=openssl_verify($original_str,base64_decode($resultsign),$public_key);
        if (1!=$result){
            echo json_encode(array("msg"=>"验签失败！","code"=>"4005"));
            exit();
        }

//去掉返回字符串
        return $response;
    }
    //金海哲支
    public function jpay()
    {
        if (empty($_GET['ewmid'])){
            echo json_encode(array("msg"=>"ewmid为空！","code"=>"4000"));
            exit();
        }
        if(empty($_GET['goods_price']) or $_GET['goods_price'] < 0.01){
            echo json_encode(array("msg"=>"交易最小金额为0.01！","code"=>"4001"));
            exit();
        }
        if(empty($_GET['paymethod'])){
            echo json_encode(array("msg"=>"paymethod为空！","code"=>"4002"));
            exit();
        }
        $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $_GET['ewmid'] . "'");
        if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {

            $rows['goods_price'] = $_GET['goods_price'];
            $rows['openid'] = $_GET['openid'];

            $payinfo = $this->payinfo($_GET['paymethod']);
            if($payinfo == false){
                echo json_encode(array("msg"=>"业务编号错误！","code"=>"4004"));
                exit();
            }else{

                //此代码删除就可以上线测试
                $orderid = $rows['orderid'] ?: 0;
                $rows['transaction_id'] = $info['payNo'];
                //添加订单
                $orderinfo = $this->add_order($rows, $rows['mid'], 3, $orderid, $payinfo);
                echo "<pre>";
                print_r($orderinfo);
                exit;
                //此代码删除就可以上线测试

                $info = $this->jhzpay($info['goods_price']*100,$info['paymethod'],$info['remark'],$info['order_id']);
                $info = json_decode($info,true);
                unset($info['sign']);
                $orderid = $rows['orderid'] ?: 0;
                $rows['transaction_id'] = $info['payNo'];
                //添加订单
                $orderinfo = $this->add_order($rows, $rows['mid'], 3, $orderid, $payinfo);
                unset($info['sign']);
                if(!empty($orderinfo) && !empty($info['backQrCodeUrl']) && !empty($info['backOrderId'])){
                    echo json_encode(array("msg"=>"success","data"=>array("orderid"=>$orderinfo['order_id'],"url"=>$info['backQrCodeUrl']),"code"=>"2000"));
                    exit();
                }else{
                    echo json_encode(array("msg"=>"","code"=>"4006"));
                    exit();
                }
            }
        } else {
            echo json_encode(array("msg"=>"ewmid不存在！","code"=>"4003"));
            exit();
        }

    }

    public function add_order($datas, $pmid = 0, $mchtype = 0, $orderid = 0, $payinfo)
    {
        //判断是否为二清商户
        $merchants = M('cashier_merchants')->get_One(array('mid' => $datas['mid']), 'mtype,sid,aid');
        $wxrebate = M('cashier_wxrebate')->select(array('is_pay' => 1, 'type' => 1), 'rebate');

        if ($merchants['mtype'] == '1') {
            $wx_pay = $wxrebate[0]['rebate'] / 100;//微信费率配置
        } else {
            $wx_pay = $wxrebate[1]['rebate'] / 100;//微信费率配置
        }


        $param = '';
        $paramArr = ((!empty($param) ? json_decode(base64_decode($param), true) : array()));
        $paramArr['price'] = (string)$paramArr['price'];
        $data['mid'] = $datas['mid'];
        $data['pmid'] = $pmid;
        $data['mchtype'] = $mchtype;
        $data['goods_id'] = 1;

        $data['pay_way'] = $payinfo['pay_way'];
        $data['pay_type'] = $payinfo['pay_type'];
        $data['goods_describe'] = $payinfo['goods_describe'];
        $data['goods_price'] = $datas['goods_price'];
        $data['openid'] = $datas['openid'];
        $data['transaction_id'] = $datas['transaction_id'];

        $data['extrainfo'] = "";//微信用户留言
        $data['goods_name'] = empty($datas['goods_name'])?"消费商品":$datas['goods_name'];
        $data['truename'] = "";

        $data['order_id'] = $orderid ?: '22' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);

        $data['goods_type'] = ((!empty($paramArr) && isset($paramArr['receiveid']) && isset($paramArr['cardid']) ? 'CardOfPay' : 'unlimit'));

        if (isset($paramArr['cf']) && ($paramArr['cf'] == 'wapvcard')) {
            $data['goods_type'] = 'LocalVipCardRecharge';
        }


        $data['goods_price'] = $datas['goods_price'];
        $data['add_time'] = time();
        isset($datas['eid']) && ($data['eid'] = intval($datas['eid']));
        isset($datas['storeid']) && ($data['storeid'] = intval($datas['storeid']));
        !empty($param) && isset($paramArr['ucid']) && ($data['ucid'] = intval($paramArr['ucid']));
        !empty($param) && is_array($paramArr) && ($data['extrainfo'] = serialize($paramArr));

        $merchants_income = $datas['goods_price'];
        //查询返佣比率
        $salesmans = M('cashier_salesmans')->get_One(array('id' => $merchants['sid']), '*');
        $agent = M('cashier_agent')->get_One(array('aid' => $merchants['aid']), 'commission');

        //计算业务员佣金
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
            $data['code'] = $payinfo['code'];
            return $data;
        }


        return false;
    }
    /**
     * @param $paymethod         支付方式
     */
    public function payinfo($paymethod)
    {
        switch ($paymethod){
            case 6001:
                return array("pay_way"=>"weixin","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲微信扫码","code"=>"6001");
            break;
            case 6002:
                return array("pay_way"=>"金海哲网银支付","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲网银支付","code"=>"6002");
            break;
            case 6003:
                return array("pay_way"=>"alipay","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲支付宝扫码","code"=>"6003");
            break;
            case 6004:
                return array("pay_way"=>"金海哲微信公众号","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲微信公众号","code"=>"6004");
            break;
            case 6005:
                return array("pay_way"=>"金海哲微信WAP","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲微信WAP","code"=>"6005");
            break;
            case 6006:
                return array("pay_way"=>"金海哲无卡支付","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲无卡支付","code"=>"6006");
            break;
            case 6007:
                return array("pay_way"=>"金海哲点卡销卡接口","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲点卡销卡接口","code"=>"6007");
            break;
            case 6008:
                return array("pay_way"=>"alipay","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲支付宝H5","code"=>"6008");
            break;
            case 6009:
                return array("pay_way"=>"金海哲微信APP支付","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲微信APP支付","code"=>"6009");
            break;
            case 6010:
                return array("pay_way"=>"金海哲京东扫码","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲京东扫码","code"=>"6010");
            break;
            case 6011:
                return array("pay_way"=>"qq","pay_type"=>"jhzwxAPI","goods_describe"=>"QQ扫码","code"=>"6011");
            break;
            default:
                return false;
        }
    /*6001 微信扫码
    6002 网银支付
    6003 支付宝扫码
    6004 微信公众号
    6005 微信WAP
    6006 无卡支付
    6007 点卡销卡接口
    6008 支付宝H5
    6009 微信APP支付
    6010 京东扫码
    6011 QQ扫码*/
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
    /**
     * 金海哲页面返回URL回调
     */

    public function success()
    {
        if(!empty($_POST) && $_POST['ret']['code'] == "1000"){
            $fansDb = M('cashier_order');
            $ispay['ispay'] = "1";
            $fansDb->update($ispay, array('transaction_id' => $_POST['msg']['payNo']));
        }
    }
}

?>
<?php
bpBase::loadAppClass('base', '', 0);

//金海哲支付接口类
class jpay_controller extends base_controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function order(){
        if(!empty($_POST['order_id'])){
            $rows = M("cashier_order")->get_one(array('order_id' =>$_POST['order_id']),"ispay");
            if(!empty($rows) and $rows['ispay'] == "1"){
                echo "success";
            }else{
                echo "error";
            }
        }

    }
    /*
     * $amount      金额
     * $paymethod   业务编号
     * $remark      回调地址
     * $order_id      订单号
     * $rows      金额
     * $payinfo      mid商家,storesid门店,eid店员
     * $pay_type      微信或者QQ配置
     * */
    //金海哲支付方法
    private function jhzpay($rows){

        error_reporting(E_ALL^E_NOTICE^E_WARNING);
        header("Content-Type: text/html; charset=utf8");
        $jhz = loadConfig('jhz');
        $public_key = $jhz['public_key'];
// 密钥必须按照以下格式
        $private_key = $jhz['private_key'];
//支付系统网关地址
        $pay_url = $jhz['pay_url'];
// 请求数据赋值
        $data = "";
        $data['merchantNo'] = $jhz['merchantNo']; //商户号
        $data['requestNo'] =  $rows['orderid']; //支付流水
        $data['amount'] = $rows['goods_price'];//金额（分）
        $data['payMethod'] = $rows['payinfo']['code'];//业务编号
        $data['backUrl'] =  $rows['backurl'];   //页面返回URL
        $data['pageUrl'] = $jhz['pageUrl'];   //服务器返回URL
        $data['payDate'] = time();   //支付时间，必须为时间戳
        $data['remark1'] = $rows['backurl'];
        $data['remark2'] ='2';
        $data['remark3'] = '3';


        $signature=$data['merchantNo']."|".$data['requestNo']."|".$data['amount']."|".$data['pageUrl']."|".$data['backUrl']."|".$data['payDate']."|".$data['agencyCode']."|".$data['remark1']."|".$data['remark2']."|".$data['remark3'];
////////////////////////
        $pr_key ='';
        if(openssl_pkey_get_private($private_key)){
            $pr_key = openssl_pkey_get_private($private_key);

        }

        $pu_key = '';
        if(openssl_pkey_get_public($public_key)){
            $pu_key = openssl_pkey_get_public($public_key);

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
//调用添加订单后续方法
        $info = array(
            "qrcode_id"=>$rows['ewmid'],
            "mid"=>$rows['mid'],
            "storesid"=>$rows['storesid'],
            "eid"=>$rows['eid'],
            "goods_price"=>$rows['goods_price'],
            "order_id"=>$rows['orderid'],
            "pay_way"=>$rows['payinfo']['pay_way'],
            "pay_type"=>$rows['payinfo']['pay_type'],
            "goods_describe"=>$rows['payinfo']['goods_describe'],
            "code"=>$rows['payinfo']['code']
        );
        $this->Response($response,$info);

//获取返回字符串sign
        $resultsign=$arr['sign'];
//从arr去掉sign
        unset($arr['sign']);
//去掉斜杠
        $original_str=stripslashes(json_encode($arr));
        $result=openssl_verify($original_str,base64_decode($resultsign),$public_key);

    }

    //金海哲支
    public function jpay()
    {
        if (empty($_POST['ewmid'])){
//            echo json_encode(array("msg"=>"ewmid为空！","code"=>"4000"));
            echo"<script>alert('ewmid为空');history.go(-1);</script>";
            exit();
        }
        if(empty($_POST['goods_price']) or intval($_POST['goods_price']) < 1){
//            echo json_encode(array("msg"=>"交易最小金额为0.01！","code"=>"4001"));
            echo"<script>alert('交易最小金额为0.01！');history.go(-1);</script>";
            exit();
        }
        if(empty($_POST['paymethod'])){
//            echo json_encode(array("msg"=>"业务编号为空！","code"=>"4002"));
            echo"<script>alert('业务编号为空！');history.go(-1);</script>";
            exit();
        }
        $rows = M('cashier_qrcode')->get_one(array("qrcode_id"=>$_POST['ewmid']),"mid,eid,storesid");
        if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {
            $rows['goods_price'] = $_POST['goods_price'];
            $rows['ewmid'] = $_POST['ewmid'];
            $rows['backurl'] = empty($_POST['backurl']) ? "www.baidu.com" : $_POST['backurl'];
            $rows['orderid'] = '33' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);
            $rows['payinfo'] = $this->payinfo($_POST['paymethod']);
            if($rows['payinfo'] == false){
//                echo json_encode(array("msg"=>"业务编号错误！","code"=>"4004"));
                echo"<script>alert('业务编号错误！');history.go(-1);</script>";
                exit();
            }else{
                $this->jhzpay($rows);
            }
        } else {
//            echo json_encode(array("msg"=>"ewmid不存在！","code"=>"4003"));
            echo"<script>alert('ewmid不存在！');history.go(-1);</script>";
            exit();
        }

    }
    private function Response($response,$list){
        $info = json_decode($response,true);
        unset($response);
        if($info['code'] == "2086"){
//            echo json_encode(array("msg"=>"单笔交易金额超限!","code"=>"4007"));
            echo"<script>alert('单笔交易金额超限！');history.go(-1);</script>";
            exit();
        }
        //添加订单
        $list['backOrderId'] = $info['backOrderId'];
        $list['sign'] = $info['sign'];
        $list['goods_price'] = $list['goods_price'] / 100;
        $orderinfo = $this->add_order($list);
        if(!empty($orderinfo) && !empty($info['backQrCodeUrl']) && !empty($info['backOrderId'])){
//            echo json_encode(array("msg"=>array("code"=>"2000","msg"=>"success"),"data"=>array("orderid"=>$list['order_id'],"url"=>$info['backQrCodeUrl'],"ewmid"=>$list['qrcode_id'])));
            $data = array("order_id"=>$list['order_id'],"goods_price"=>$list['goods_price'],"url"=>$info['backQrCodeUrl'],"paymethod"=>$list['paymethod']);
            include $this->showTpl();
        }else{
//            echo json_encode(array("msg"=>"","code"=>"4006"));
            echo"<script>alert('4006！');history.go(-1);</script>";
            exit();
        }
    }
    public function add_order($data)
    {
        $info = array(
            "order_id"=>$data['order_id'],
            "mid"=>$data['mid'],
            "pay_way"=>$data['pay_way'],
            "pay_type"=>$data['pay_type'],
            "goods_type"=>"unlimit",
            "goods_id"=>"1",
            "goods_name"=>"消费商品",
            "goods_describe"=>$data['goods_describe'],
            "goods_price"=>$data['goods_price'],
            "income"=>$data['goods_price'],
            "add_time"=>time(),
            "paytime"=>"",
            "state"=>"0",
            "ispay"=>"0",
            "truename"=>"",
            "openid"=>"",
            "transaction_id"=>$data['backOrderId'],
            "refund"=>"0",
            "refundtext"=>"0",
            "comefrom"=>"0",
            "mchtype"=>"3",
            "pmid"=>"1",
            "p_openid"=>"otqnZwRchg0xm32Eb88SAODei84o",
            "storeid"=>$data['storesid'],
            "eid"=>$data['eid'],
            "ucid"=>"0",
            "receiveid"=>"0",
            "extrainfo"=>"",
            "mprice"=>"",
            "salesmans_price"=>"",
            "agent_price"=>"",
            "saler_stm"=>"0",
            "agent_stm"=>"0",
            "out_trade_no"=>"",
            "out_trade_nos"=>$data['order_id'],
            "bank_type"=>$data['sign'],
        );
        //收入
        if (M('cashier_order')->insert($info,true)) {
            return true;
            exit();
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
                return array("pay_way"=>"weixin","pay_type"=>"jhzwxAPI","goods_describe"=>"金海哲微信API","code"=>"6001");
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
                return array("pay_way"=>"qq","pay_type"=>"jhzqqAPI","goods_describe"=>"金海哲QQAPI","code"=>"6011");
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
     * 金海哲页面返回URL回调
     */

    public function success()
    {
        if(!empty($_POST)){
            $status['ret'] = json_decode(stripslashes(htmlspecialchars_decode($_POST['ret'])),true);
            $status['msg'] = json_decode(stripslashes(htmlspecialchars_decode($_POST['msg'])),true);
            if($status['ret']['code'] == "1000" and $status['ret']['msg'] == "SUCCESS" and !empty($_POST['sign']) and !empty($status['msg'])){
                $fansDb = M('cashier_order');
                $ispay['ispay'] = "1";
                $ispay['paytime'] = time();
                $rows = $fansDb->get_one(array('transaction_id' =>$status['msg']['payNo']),"mid,goods_price,order_id");
                $fansDb->update($ispay, array('mid' => $rows['mid'], 'order_id' => $rows['order_id']));

                if($status['msg']['remarks'] != "www.baidu.com"){
                    $this->request_by_curl($status['msg']['remarks'],array("orderid"=>$rows['order_id'],"money"=>$rows['goods_price'],"orderdate"=>time(),"code"=>"1000"));
                }
                return  "SUCCESS";
            }
        }
    }

    private function request_by_curl($uri, $data) {
        $ch = curl_init ();
        // print_r($ch);
        curl_setopt ( $ch, CURLOPT_URL, $uri );
        curl_setopt ( $ch, CURLOPT_POST, 1 );
        curl_setopt ( $ch, CURLOPT_HEADER, 0 );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
        $return = curl_exec ( $ch );
        curl_close ( $ch );
    }
}

?>
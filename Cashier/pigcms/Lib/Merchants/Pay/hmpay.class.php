<?php
bpBase::loadAppClass('base', '', 0);

//支付接口类
class hmpay_controller extends base_controller
{

    private function hmpay($rows,$money,$type,$orderid,$callbackurl){

        $pay_url="http://pay.hubonet.com.cn/chargebank.aspx";
//        商户id
        $data['parter']=1820;
//        银行类型
        $data['type']=$type;
//            金额
        $data['value']=$money;
//            订单号
        $data['orderid']=$orderid;
//            回调地址
        $data['callbackurl']='http://' . $_SERVER['SERVER_NAME'] ."/Cashier/pay/hb.php";
//                ip
        $data['payerIp']=$_SERVER["REMOTE_ADDR"];
//            备注
            $data['attach']="url123";
//        md5签名
        $sign=md5("parter={$data['parter']}&type={$data['type']}&value={$data['value']}&orderid={$data['orderid']}&callbackurl={$data['callbackurl']}");
        $sign = iconv("UTF-8","GB2312",$sign);
        $data['sign']=$sign;

        $ch = curl_init();
        //        if(!$flag)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_URL, $pay_url);
        $response =  curl_exec($ch);
        curl_close($ch);
        $response=iconv("GB2312","UTF-8",$response);


        if($type==992 or $type==1004 or $type==1593){
            $urlToEncode="http://www.jb51.net";
            $this->generateQRfromGoogle($urlToEncode);
        }else{
            echo $response;
        }

    }
    public function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0')
    {
        $chl = urlencode($chl);
        echo '<img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.' 
 &cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="QR code" widhtHeight="'.$widhtHeight.'
 " widhtHeight="'.$widhtHeight.'"/>';
    }

    //hm哲支
    public function hpay()
    {
//        emid
        if (empty($_POST['ewmid'])){
            echo json_encode(array("msg"=>"ewmid为空！","code"=>"4000"));
            exit();
        }
//        银行卡类型
        if (empty($_POST['type'])){
            echo json_encode(array("msg"=>"支付类型为空！","code"=>"4001"));
            exit();
        }
        $payinfo = $this->payinfo($_POST['type']);
        if($payinfo == false){
            echo json_encode( [ "msg" => "支付类型错误！", "code" => "4004" ] );
            exit();
        }
//        金额
        if(empty($_POST['money']) or $_POST['money'] < 200){
            echo json_encode(array("msg"=>"交易最小金额为2元","code"=>"4002"));
            //            echo"<script>alert('交易最小金额为0.01！');history.go(-1);</script>";
            exit();
        }

        //        支付宝、微信、qq、3000，网银5万
        if($_POST['type']==992 or $_POST['type']==1004 or $_POST['type']==1593){
            if($_POST['money'] >300000){
                echo json_encode(array("msg"=>"超过最大支付金额","code"=>"4003"));
                exit();
            }
        }else{
            if($_POST['money'] >5000000){
                echo json_encode(array("msg"=>"超过最大支付金额","code"=>"4003"));
                exit();
            }
        }
        $rows = M('cashier_qrcode')->get_one("qrcode_id='" . $_POST['ewmid'] . "'");
        if ($rows['mid'] && $rows['eid'] && $rows['storesid']) {
            $money=intval($_POST['money'])/100;
            $backurl = empty($_POST['backurl']) ? "www.baidu.com" : $_POST['backurl'];
//            44开头为互泊
            $orderid = '44' . date('YmdHis') . mt_rand(11111, 99999) . substr(SYS_TIME, 2);
            $this->hmpay($rows,$money,$_POST['type'],$orderid,$backurl);
        } else {
            echo json_encode(array("msg"=>"ewmid不存在！","code"=>"4005"));
            exit();
        }
    }

    private function Response($response,$list){
        $info = json_decode($response,true);
        unset($response);
        if($info['code'] == "2086"){
            echo json_encode(array("msg"=>"单笔交易金额超限!","code"=>"4007"));
//            echo"<script>alert('单笔交易金额超限！');history.go(-1);</script>";
            exit();
        }
        //添加订单
        $list['backOrderId'] = $info['backOrderId'];
        $list['sign'] = $info['sign'];
        $orderinfo = $this->add_order($list);
        if(!empty($orderinfo) && !empty($info['backQrCodeUrl']) && !empty($info['backOrderId'])){
            echo json_encode(array("msg"=>array("code"=>"2000","msg"=>"success"),"data"=>array("orderid"=>$list['order_id'],"url"=>$info['backQrCodeUrl'],"ewmid"=>$list['qrcode_id'])));
            //$data = array("order_id"=>$list['order_id'],"goods_price"=>$list['goods_price'],"url"=>$info['backQrCodeUrl']);
            //include $this->showTpl();
        }else{
            echo json_encode(array("msg"=>"","code"=>"4006"));
            //            echo"<script>alert('4006！');history.go(-1);</script>";
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
    public function payinfo($paytype)
    {
        switch ($paytype){
            case 962:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊中信银行api","code"=>"962");
                break;
            case 963:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊中国银行api","code"=>"963");
                break;
            case 964:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊中国农业银行api","code"=>"964");
                break;
            case 965:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊中国建设银行api","code"=>"965");
                break;
            case 967:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊中国工商银行api","code"=>"967");
                break;
            case 968:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊浙商银行api","code"=>"968");
                break;
            case 969:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊浙江稠州商业银行api","code"=>"969");
                break;
            case 970:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊招商银行api","code"=>"970");
                break;
            case 971:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊邮政储蓄api","code"=>"971");
                break;
            case 972:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊兴业银行api","code"=>"972");
                break;
            case 973:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊顺德农村信用合作社api","code"=>"973");
                break;
            case 974:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊深圳发展银行api","code"=>"974");
                break;
            case 975:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊上海银行api","code"=>"975");
                break;
            case 976:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊上海农村商业银行api","code"=>"976");
                break;
            case 977:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊浦东发展银行api","code"=>"977");
                break;
            case 978:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊平安银行api","code"=>"978");
                break;
            case 979:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊南京银行api","code"=>"979");
                break;
            case 980:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊民生银行api","code"=>"980");
                break;
            case 981:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊交通银行api","code"=>"981");
                break;
            case 982:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊华夏银行api","code"=>"982");
                break;
            case 983:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊杭州银行api","code"=>"983");
                break;
            case 984:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊广州市农村信用社|广州市商业银行api","code"=>"984");
                break;
            case 985:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊广东发展银行api","code"=>"985");
                break;
            case 986:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊光大银行api","code"=>"986");
                break;
            case 987:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊东亚银行api","code"=>"987");
                break;
            case 988:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊渤海银行api","code"=>"988");
                break;
            case 989:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊北京银行api","code"=>"989");
                break;
            case 990:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊北京农村商业银行api","code"=>"990");
                break;
            case 992:
                return array("pay_way"=>"aliPay","pay_type"=>"hmUPay","goods_describe"=>"互泊支付宝扫码api","code"=>"992");
                break;
            case 1004:
                return array("pay_way"=>"weixin","pay_type"=>"hmUnionPay","goods_describe"=>"互泊微信扫码api","code"=>"1004");
                break;
            case 1005:
                return array("pay_way"=>"weixin","pay_type"=>"hmUnionPay","goods_describe"=>"互泊微信wap版api","code"=>"1005");
                break;
            case 1006:
                return array("pay_way"=>"aliPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊支付宝wap版api","code"=>"1006");
                break;
            case 1593:
                return array("pay_way"=>"qq","pay_type"=>"hmUnionPay","goods_describe"=>"互泊QQ钱包扫码api","code"=>"1593");
                break;
            case 2088:
                return array("pay_way"=>"UnionPay","pay_type"=>"hmUnionPay","goods_describe"=>"互泊网银快捷通道api","code"=>"2088");
                break;
            default:
                return false;
        }
    }
}

?>
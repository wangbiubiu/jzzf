<?php
bpBase::loadAppClass('base', '', 0);

class index_controller extends base_controller
{
    public $is_wexin_browser = false;

    // 用户浏览器
    private $user_browser = 'other';
    public function __construct()
    {
        // 判断用户浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'icroMessenger') !== false) {
            $this->user_browser = 'wechat';
            $this->is_wexin_browser = true;
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            $this->user_browser = 'alipay';
        }
    }
    //支付接口
    public function index(){
        //获取接口信息
        $goods_price = $_GET['goods_price'];
        $mid = $_GET['mid'];//115
        $goods_name = $_GET['goods_name'];//商品名称
        $eid = $_GET['eid'];//店员ID 1031
        $storeid = $_GET['storeid'];//门店ID 541
        $orderid = $_GET['orderid'];//订单号码
        $return_url = $_GET['rurl'];//同步回调
        $notify_url = $_GET['nurl'];//异步回调
        $key = $_GET['key'];
        $key2 = md5($goods_name."#".$mid."#".$storeid."#".$eid."#".$orderid."#".$goods_price."#".$return_url."#".$notify_url);
        if($key != $key2){
            die("签名错误！");
        }
        $goods_price = $goods_price;
        if($goods_price <= 0){
            die("金额有误！");
        }
        session_start();
        if ($this->user_browser == 'wechat') {
            bpBase::loadOrg('wxCardPack');
            $wx_user = M('cashier_payconfig')->getwxuserConf($mid);
            if (isset($wx_user['submchinfo']) && ($wx_user['submchinfo']['mid'] == $mid) && !empty($wx_user['submchinfo']['appid']) && !empty($wx_user['submchinfo']['appSecret'])) {
                $wxCardPack = new wxCardPack($wx_user['submchinfo'], $mid);
            } else {
                $wxCardPack = new wxCardPack($wx_user, $wx_user['mid']);
            }
            if ($this->is_wexin_browser && empty($_SESSION['my_Cashier_openid'])) {
                $redirecturl = 'http://'.$_SERVER['SERVER_NAME']. '/' . $_SERVER['REQUEST_URI'];
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
                $redirecturl = urlencode('http://'.$_SERVER['SERVER_NAME'].'/' . $_SERVER['REQUEST_URI']);
                $result = $alipayhelper->getUserId($redirecturl);
                if (!$result['success']) {
                    die($result['errmsg']);
                } else {
                    $_SESSION['my_Cashier_aliuserid'] = $result['data'];
                }
            }
        }
        else{
            die("仅支持微信、支付宝支付！");
        }
        // 判断用户浏览器
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'icroMessenger') !== false) {
            //微信
            $formUrl = ABS_UPLOAD_PATH.'/pay/wxpay/index.php?m=Index&c=pay&a=foreverpaying&ordid=auto&orderid='.$orderid;
            $paytype = "weixin";//支付渠道
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false) {
            //支付宝
            $formUrl = "/merchants.php?m=Index&c=pay&a=alitradepay&orderid=".$orderid;
            $paytype = "alipay";//支付渠道
        }
        else{
            //其他
            die("暂不支持该浏览器！");
        }
        echo '<form method="post" id="form1" action="'.$formUrl.'">
            <input type="hidden" value="'.$goods_price.'" name="goods_price"/>
            <input type="hidden" value="'.$mid.'" name="mid"/>
            <input type="hidden" value="'.$goods_name.'" name="goods_name"/>
            <input type="hidden" value="'.$storeid.'" name="storeid"/>
            <input type="hidden" value="'.$eid.'" name="eid"/>
            <input type="hidden" value="'.$paytype.'" name="paytype"/>
            <input type="hidden" value="'.$orderid.'" name="orderid"/>
</form>
<script type="text/javascript:;">document.form1.submit();</script>';
        echo "<script>document.getElementById('form1').submit();</script>";
    }
    public function queryOrder(){
        $orderid = I("orderid");
    }
    //保存用户
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
    //查询接口
    public function query(){
        $mid = $_POST['mid'];
        $sid = $_POST['storeid'];
        $eid = $_POST['eid'];
        $orderid = $_POST['orderid'];
        $key = $_POST['key'];
        $key2 = md5($mid."#".$sid."#".$eid."#".$orderid);
        if($key != $key2){
            $error = array(
                "order_id"=>$orderid,
                "state"=>0
            );
            echo json_encode($error);
            exit;
        }
        $order = M("cashier_order") -> get_one(array("order_id"=>$orderid,"mid"=>$mid,"storeid"=>$sid,"eid"=>$eid),"order_id,state,paytime,pay_way");
        echo json_encode($order);
    }
}
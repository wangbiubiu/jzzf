<?php

ini_set('date.timezone','Asia/Shanghai');
/**
 * Created by PhpStorm.
 * User: zp
 * mail: admin@zhangp.cn
 * Date: 17-5-2
 * Time: 下午9:46
 */
class MinShengBank
{
    //测试环境地址
    const URLTEST = 'https://gzwkzftest.cmbc.com.cn/payment-gate-web/gateway/api/backTransReq';

    //生产环境地址
    const URL = 'https://gzwkzf.cmbc.com.cn/payment-gate-web/gateway/api/backTransReq';

    static $errMsg = '';

    static $errNo = '';

    static $conf = [
        //版本号
        'version'   =>  'V1.0',
        //商户号
        'merNo'     =>  '850500053991253',
        //证书路径
        'pem'       =>  '../pem/850500053991253_prv.pem',
        //支付同步通知地址
        'payReturnUrl'  =>  'https://www.baidu.com',
        //支付异步通知地址
        'payNotifyUrl'  =>  'https://www.baidu.com',
        //退款同步通知地址
        'refundReturnUrl'  =>  'https://www.baidu.com',
        //退款异步通知地址
        'refundNotifyUrl'  =>  'https://www.baidu.com',
    ];


    /************************工具类方法***************************/

    /**
     * 功能： 生成签名
     * @param $data
     * @return string
     */
    final static protected function sign(&$data){
        //排序生成待签名字符串
        $signString = self::SinParamsToString($data);
        //读取私钥文件
        //注意所放文件路径
        $priKey = file_get_contents(self::$conf['pem']);

        //转换为openssl密钥，必须是没有经过pkcs8转换的私钥
        $res = openssl_get_privatekey($priKey);

        //调用openssl内置签名方法，生成签名$sign
        openssl_sign($signString, $sign, $res);

        //释放资源
        openssl_free_key($res);

        $signStr = base64_encode($sign);
        return str_replace("+", "%2B", $signStr);

    }

    /**
     * 功能： 排序生成待签名字符串
     * @param $params
     * @return string
     */
    final static protected function SinParamsToString(&$params) {
        $sign_str = '';
        // 排序
        ksort($params);
        foreach ($params as $key =>$val){
            if ($key == 'signature'){
                continue;
            }
            if($val == ''){
                unset($params[$key]);
                continue;
            }

            $sign_str .= sprintf ( "%s=%s&", $key, $val );
        }
        return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );
    }

    /**
     * 功能： 模拟POST请求
     * @param $url
     * @param null $data
     * @return bool|mixed
     */
    final static public function curlPost($url, $data = null){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        if(!empty($data)){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        }
        //curl_setopt($ch,CURLOPT_SSLVERSION,CURL_SSLVERSION_TLSv1);
        curl_setopt($ch,CURLOPT_TIMEOUT,30);
        $outPut = curl_exec($ch);
        $aStatus = curl_getinfo($ch);
        curl_close($ch);
        if(intval($aStatus['http_code'])==200){
            return $outPut;
        }else{
            return false;
        }
    }

    /**
     * 功能： 设置错误信息
     * @param $errMsg
     * @param string $errNo
     * @return bool
     */
    static protected function setError($errMsg, $errNo = '10000'){
        //类返回错误代码为10000，表示调用类错误。
        self::$errMsg =  $errMsg;

        self::$errNo = $errNo;

        return false;
    }

    /**
     * 功能：获取错误信息
     * @return array
     */
    static public function getError(){
        return [
            'errMsg'    =>  self::$errMsg,
            'errNo'     =>  self::$errNo
        ];
    }

    static protected function arrayToString($params){
        $sign_str = '';
        // 排序
        ksort ( $params );
        foreach ( $params as $key => $val ) {

            $sign_str .= sprintf ( "%s=%s&", $key, $val );
        }
        return substr ( $sign_str, 0, strlen ( $sign_str ) - 1 );

    }

    /**
     * 功能： 发送封包数据
     * @param $data
     * @return bool
     */
    static protected function sendData($data){
        $sign = self::sign($data);
        $data['signature'] = $sign;
        $post_data = self::arrayToString($data);
        $url = self::URLTEST;
        $url = $url . '?'.$post_data;
        $result = self::curlPost($url);
        if($result){
            parse_str($result, $resultArr);
            if(!self::checkSign($resultArr)){
                return self::setError('返回参数签名验证失败！');
            }
            return $resultArr;
        }
        return self::setError('CURL 错误');
    }

    /**
     * 功能： 签名验证
     * @param $data
     * @return bool
     */
    final static protected function checkSign($data){
        $orgSign = $data['signature'];
        //却掉签名后生成签名
        unset($data['signature']);
        $sign = urldecode(self::sign($data));
        $orgSign = str_replace(' ', '+', $orgSign);
        $sign = str_replace(' ', '+', $sign);
        if($orgSign === $sign){
            return true;
        }
        return false;
    }
    /*************************功能性方法***********************/
    /**
     * @param $input
     * @return bool
     */
    public function createOrder($input){
        if(empty($input)){
            return static::setError('订单信息不能为空！');
        }

        $data = [
        //必填参数

            //请求流水号
            'requestNo' =>  md5(uniqid()),
            //接口版本号
//            'version'   =>  static::$conf['version'],
            'version'   =>  'V1.0',
            //商户号，服务商在民生银行的商户号，850开头
            'merNo'     =>  static::$conf['merNo'],
//            'merNo'     =>  '850500053991253',
            //产品类型：见附注
            'productId' =>  trim($input['productId']),
//            'productId' =>  '0104',
            //交易类型：见附注
            'transId'   =>  trim($input['transId']),
//            'transId'   =>  '10',
            //订单日期
            'orderDate' =>  date('Ymd', time()),
            //商户订单号
//            'orderNo'   =>  trim($input['orderNo']),
            'orderNo'   =>  md5(time()),
            //同步通知地址
            'returnUrl' =>  isset($input['returnUrl'])?trim($input['returnUrl']):self::$conf['payReturnUrl'],
            //异步通知地址
            'notifyUrl' =>  isset($input['notifyUrl'])?trim($input['notifyUrl']):self::$conf['payNotifyUrl'],
            //交易金额，单位为分
            'transAmt'  =>  intval(trim($input['transAmt'])),
            //商品名称（在无法确定商品名称时上送商户名称，或基于实际的业务需求，加送联系电话或订单号等）
            'commodityName' =>  trim($input['commodityName']),
            //支付商户识别id，民生后台的【渠道商户识别码】;
            'subMerNo'  =>  trim($input['subMerNo']),
            //支付收款商户名称
            'subMerName'    =>  trim($input['subMerName']),

        //选填参数(部分参数在部分情况下必填)
            //民生子商户ID
            'subChnlMerNo'    =>  isset($input['subChnlMerNo'])?trim($input['subChnlMerNo']):'',
            //微信openid
            'openid'    =>  isset($input['openid'])?trim($input['openid']):'',
            //当产品类型为0106、0110、0121时，必填，即微信/支付宝/银联支付的刷卡交易页面的串码
            'authCode'    =>  isset($input['authCode'])?trim($input['authCode']):'',
            //支付宝产品必填，该支付宝商户的属下门店的编号
            'storeId'    =>  isset($input['storeId'])?trim($input['storeId']):'',
            //支付宝商户机具终端编号
            'terminalId'    =>  isset($input['terminalId'])?trim($input['terminalId']):'',
            //微信产品（不包含刷卡支付）可输入no_credit --指定不能使用信用卡支付。
            'limitPay'    =>  isset($input['limitPay'])?trim($input['limitPay']):'',
            //当产品为0115时，必填。 买家的支付宝唯一用户号
            'userId'    =>  isset($input['userId'])?trim($input['userId']):'',
            //仅产品类型为0122时，可选送。上送后，超过二维码有效期时限，将交易失败。 单位：秒
            'qrValidTime'    =>  isset($input['qrValidTime'])?trim($input['qrValidTime']):'',
            //京东支付必填，合作商户的外部商户的注册成功实践，13位unix时间戳
            'omRt'    =>  isset($input['omRt'])?trim($input['omRt']):'',
            //京东支付必填:外部商户行业
            'omType'    =>  isset($input['omType'])?trim($input['omType']):'',
            //京东支付必填:外部商户地址
            'omAdd'    =>  isset($input['omAdd'])?trim($input['omAdd']):'',
        ];

        return self::sendData($data);

//        $url="https://gzwkzftest.cmbc.com.cn/payment-gate-web/gateway/api/backTransReq";

    }

    /**
     * 功能：订单状态查询
     * @param $orderId
     * @param $time
     * @return bool
     */
    public function queryOrder($orderId, $time){
        $data = [
            'requestNo' => md5(uniqid()),
            'version'   =>  'V1.0',
            'merNo'     =>  static::$conf['merNo'],
            'transId'   =>  '04',
            'orderDate' =>  date('Ymd',$time),
            'orderNo'   =>  $orderId,
        ];
        return self::sendData($data);
    }

    public function refundOrder($data){
        $data = [
            'requestNo' => md5(uniqid()),
            'version'   =>  'V1.0',
            'merNo'     =>  static::$conf['merNo'],
            'transId'   =>  '02',
            'orderDate' =>  date('Ymd',time()),
            'orderNo'   =>  md5(uniqid()),
            'origOrderDate' =>  date('Ymd', $data['orderDate']),
            'origOrderNo'   =>  $data['orderNo'],
            'returnUrl' =>  isset($data['returnUrl'])?$data['returnUrl']:self::$conf['refundReturnUrl'],
            'notifyUrl' =>  isset($data['notifyUrl'])?$data['notifyUrl']:self::$conf['refundNotifyUrl'],
            'transAmt' =>  intval($data['transAmt']),
            'refundReson'   =>  trim($data['refundReson'])
        ];
        return self::sendData($data);
    }
}




/*************以下为测试数据*************************/




/*
$bank = new MinShengBank();

$dataCreate = [
    'productId' =>  '0104',
    'transId'   =>  '10',
    'orderNo'   =>  md5(time()),
    'returnUrl' =>  'https://www.baidu.com',
    'notifyUrl' =>  'https://www.baidu.com',
    'transAmt'  =>  '1',
    'commodityName' =>  '测试商品',
    'subMerNo'  =>  '25432454',
    'subMerName'    =>  '重庆**********限公司',
    'subChnlMerNo'  =>  '1000000*****'
];

//var_dump($bank->createOrder($dataCreate));

//订单查询
//var_dump($bank->queryOrder('273870398012226b17d74ae8cb6c7836', time()));

$dataRefund = [
    'orderDate' =>  time(),
    'orderNo' =>  '273870398012226b17d74ae8cb6c7836',
    'transAmt' =>  '1',
    'refundReson'   =>  '我就是测试测试'
];

//订单退款
var_dump($bank->refundOrder($dataRefund));

*/



/********************以下附注****************************************/

/*

创建订单接口
productId   产品类型

    0104-微信扫码支付
    0105-微信公众号支付
    0106-微信刷卡（反扫）
    0107-微信H5支付
    0108-微信APP支付
    0109-支付宝扫码支付
    0110-支付宝刷卡支付
    0115-支付宝支付窗支付（支付宝门店固定二维码支付）
    0121-银联二维码刷卡支付（反扫）
    0122-银联二维码扫码支付（主扫）
    0118-QQ扫码支付
    0119-QQ公众号支付
    0120-QQ刷卡（反扫）
    0123-京东扫码
    0124-京东付款码支付
    0125-京东商户二维码支付（公众号）
    0126-京东H5支付

transId 交易类型
    10-微信/支付宝/QQ/京东消费
    24-银联二维码刷卡支付（反扫）消费
    25-银联二维码扫码支付（主扫）消费
    04-订单查询
    02-订单退款


   */

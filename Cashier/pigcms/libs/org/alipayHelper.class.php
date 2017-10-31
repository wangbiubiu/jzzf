<?php

bpBase::loadAppClass('base', '', 0);

class alipayHelper
{
    private $alipayconfig;
    private $appauthcode;
    private $aop;
    private $result = array('success' => false, 'errcode' => '', 'errmsg' => '', 'data' => '');

    public function __construct($alipayconfig, $appauthcode = '')
    {
        bpBase::loadOrg('Alipay/AopClient');
        $this->alipayconfig = $alipayconfig;
        $this->appauthcode = $appauthcode;
        $this->aop = new AopClient ();
        $this->aop->appId = $this->alipayconfig['alipay']['appid'];
        $this->aop->rsaPrivateKeyFilePath = CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_private_key.pem';
        $this->aop->alipayPublicKey = CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_public_key.pem';
    }

    /**
     * 通过支付宝网页授权获取userid
     * @param $redirecturl 回调地址
     * @return array
     */
    public function getUserId($redirecturl)
    {
        if (empty($_GET['auth_code'])) {
            $_SESSION['alipaystate'] = md5(uniqid());
            $oauthUrl = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=' . $this->alipayconfig['alipay']['appid'] . '&scope=auth_base&redirect_uri=' . $redirecturl . '&state=' . $_SESSION['alipaystate'];
            header('Location: ' . $oauthUrl);
            exit();
        } else {
            // 校验返回的state
            if ($_GET['state'] != $_SESSION['alipaystate']) {
                $this->result['errmsg'] = '授权出错，请勿非法授权';
                return $this->result;
            }

            $authcode = $_GET['auth_code'];
            bpBase::loadOrg('Alipay/Request/AlipaySystemOauthTokenRequest');
            $request = new AlipaySystemOauthTokenRequest();
            $request->setCode($authcode);
            $request->setGrantType("authorization_code");
            $result = $this->aop->execute($request);

            // 判断是否授权成功
            if (isset($result['error_response']) || (isset($result['alipay_system_oauth_token_response']) && isset($result['alipay_system_oauth_token_response']['code']))) {
                $err_code = isset($result['error_response']) ? $result['error_response']['code'] : $result['alipay_system_oauth_token_response']['code'];
                $this->result['errcode'] = $err_code;
                $this->result['errmsg'] = '支付宝授权出错，错误码' . $err_code;
                return $this->result;
            }

            $this->result['success'] = true;
            $this->result['data'] = $result['alipay_system_oauth_token_response']['user_id'];
            return $this->result;
        }
    }

    /** 创建统一收款订单
     * @param $data
     * @return array
     */
    public function createTrade($data)
    {
        $orderid = '11' . date('YmdHis') . mt_rand(11111111, 99999999) . substr(SYS_TIME, 2);

        bpBase::loadOrg('Alipay/Request/AlipayTradeCreateRequest');
        $request = new AlipayTradeCreateRequest2();
//        $request->setBizContent("{" .
//            "    \"out_trade_no\":\"" . $orderid . "\"," .
//            "    \"total_amount\":0.01," .
//            "    \"subject\":\"商家收款（测试）\"," .
//            "    \"body\":\"商家收款\"," .
//            "    \"buyer_id\":\"2088002507871251\"," .
//            "    \"operator_id\":\"test_001\"," .
//            "    \"store_id\":\"ST_001\"," .
//            "    \"extend_params\":{" .
//            "      \"sys_service_provider_id\":\"2088121729754596\"" .
//            "    }" .
//            "  }");

        $bizcon = "{" .
            "    \"out_trade_no\":\"" . $data['orderid'] . "\"," .
            "    \"timeout_express\":\"6m\"," .
            "    \"total_amount\":" . $data['amount'] . "," .
            "    \"subject\":\"" . $data['subject'] . "\"," .
            "    \"body\":\"" . $data['body'] . "\"," .
            "    \"buyer_id\":\"" . $data['buyerid'] . "\"," .
            "    \"operator_id\":\"" . $data['operatorid'] . "\"," .
            "    \"store_id\":\"" . $data['storeid'] . "\"," .
            "    \"extend_params\":{" .
            "      \"sys_service_provider_id\":\"" . $data['pid'] . "\"" .
            "    }" .
            "  }";

        $request->setBizContent($bizcon);

        $response = $this->aop->execute($request, $this->appauthcode);
        if (empty($response) || empty($response['alipay_trade_create_response']) || $response['alipay_trade_create_response']['code'] != '10000') {
            $this->result['errcode'] = $response['alipay_trade_create_response']['code'] . '|' . $response['alipay_trade_create_response']['sub_code'];
            $this->result['errmsg'] = $response['alipay_trade_create_response']['msg'] . '|' . $response['alipay_trade_create_response']['sub_msg'];
            return $this->result;
        } else {
            $this->result['success'] = true;
            $this->result['data'] = $response['alipay_trade_create_response']['trade_no'];
            return $this->result;
        }
    }

    /** 获取订单支付宝支付状态
     * @param $orderId 订单编号
     * @return array
     */
    public function getTradeResult($orderId)
    {
        if (empty($orderId)) {
            $this->result['errmsg'] = '订单编号不能为空';
            return $this->result;
        }

        bpBase::loadOrg('Alipay/Request/AlipayTradeQueryRequest');
        $request = new AlipayTradeQueryRequest();
        $request->setBizContent("{" .
            "    \"out_trade_no\":\"" . $orderId . "\"" .
            "  }");

        $response = $this->aop->execute($request, $this->appauthcode);
        if (empty($response) || empty($response['alipay_trade_query_response']) || $response['alipay_trade_query_response']['code'] != '10000') {
            $this->result['errcode'] = $response['alipay_trade_query_response']['code'];
            $this->result['errmsg'] = $response['alipay_trade_query_response']['msg'];
            return $this->result;
        } else {
            $this->result['success'] = true;
            $this->result['data'] = $response['alipay_trade_query_response'];
            return $this->result;
        }

        return $response;
    }

}


?>
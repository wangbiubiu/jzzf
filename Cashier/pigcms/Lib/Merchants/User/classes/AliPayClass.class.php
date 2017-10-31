
<?php

class AliPayClass
{
	private $aliPayConfig;

	public function __construct($aliPayConfig)
	{
	    
		bpBase::loadOrg('Alipay/SignData');
		bpBase::loadOrg('Alipay/AopClient');
		bpBase::loadOrg('Alipay/LtLogger');
		$this->aliPayConfig = array('merchant_rsa_private_key' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_private_key.pem', 'merchant_rsa_public_key' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_public_key.pem', 'charset' => 'UTF-8', 'gatewayUrl' => 'https://openapi.alipay.com/gateway.do', 'app_id' => $aliPayConfig['appid'], 'key' => $aliPayConfig['key'], 'name' => $aliPayConfig['name'], 'pid' => $aliPayConfig['pid']);
		
	}

	private function aopclient_request_execute($request,$appauthtoken, $isajax = false, $notify_url = false)
	{
		$aop = new AopClient($isajax);
		$aop->gatewayUrl = $this->aliPayConfig['gatewayUrl'];
		$aop->appId = $this->aliPayConfig['app_id'];
		$aop->rsaPrivateKeyFilePath = $this->aliPayConfig['merchant_rsa_private_key'];
		$aop->apiVersion = '1.0';
        
		
		
		if (!empty($notify_url)) {
			$aop->notify_url = $notify_url;
		}


		$result = $aop->execute($request,$appauthtoken);
		return $result;
	}

	public function f2fBarPay($datas)
	{
		date_default_timezone_set('Asia/Shanghai');
		set_time_limit(60);
		bpBase::loadOrg('Alipay/Request/AlipayTradePayRequest');
		$time_expire = date('Y-m-d H:i:s', time() + 600);
		$biz_content = '{"out_trade_no":"' . $datas['order_id'] . '",';
		$biz_content .= '"scene":"bar_code",';
		$biz_content .= '"auth_code":"' . $datas['auth_code'] . '",';
		$biz_content .= '"total_amount":"' . $datas['goods_price'] . '",';
		$biz_content .= '"subject":"' . $datas['goods_name'] . '","body":"' . $datas['goods_name'] . '",';

		if (isset($datas['goodsdetail']) && !empty($datas['goodsdetail'])) {
			$biz_content .= '"goods_detail":[';

			foreach ($datas['goodsdetail'] as $dvv ) {
				$biz_content .= '{"goods_id":"' . $dvv['goodsid'] . '","goods_name":"' . $dvv['goodsname'] . '","goods_category":"' . $dvv['goodscategory'] . '","price":"' . $dvv['price'] . '","quantity":"' . $dvv['num'] . '"}],';
			}

			$biz_content .= '],';
		}


		$biz_content .= '"operator_id":"op001","store_id":"lhs001",';

		if (!empty($this->aliPayConfig['pid'])) {
			$biz_content .= '"seller_id":"' . $this->aliPayConfig['pid'] . '",';
		}


		$biz_content .= '"time_expire":"' . $time_expire . '"}';
		
		$request = new AlipayTradePayRequest();
		$request->setBizContent($biz_content);
		$response = $this->aopclient_request_execute($request, true);
		$returnResponse = false;
		$isSUCCESS = true;
		$out_trade_no = $datas['order_id'];

		if (!empty($response) && isset($response['alipay_trade_pay_response'])) {
			$response = $response['alipay_trade_pay_response'];

			if ($response['code'] == '10003') {
				$queryTimes = 15;
				$succResult = 0;
				$queryResult = '';

				if (0 < $queryTimes) {
					$queryResult = $this->queryTrade($out_trade_no, $succResult);

					if ($succResult == 2) {
						sleep(2);

						if ($queryTimes < 7) {
							sleep(2);
						}


						continue;
					}


					if ($succResult == 1) {
						$returnResponse = $queryResult;
						$returnResponse['error'] = 0;
						break;
					}


					break;
				}


				if ($succResult == 2) {
					$returnResponse = $queryResult;
					$returnResponse['error'] = 0;
				}
				 else if ($succResult == 0) {
					$isSUCCESS = false;
				}

			}
			 else if ($response['code'] == '40004') {
				$returnResponse = array('error' => 1, 'msg' => $response['sub_msg']);
			}
			 else if ($response['code'] == '20000') {
				$returnResponse = array('error' => 1, 'msg' => '业务出现未知错误或者系统异常');
				$isSUCCESS = false;
			}
			 else if ($response['code'] == '10000') {
				$returnResponse = $response;
				$returnResponse['error'] = 0;
				$returnResponse['ispay'] = 1;
			}
			 else if (isset($response['sub_msg']) && !empty($response['sub_msg'])) {
				$returnResponse = array('error' => 1, 'msg' => $response['sub_msg']);
			}

		}
		if (!$isSUCCESS) {
			$cancelResponse = $this->cancel($out_trade_no);
			if ($cancelResponse && isset($cancelResponse['alipay_trade_pay_response'])) {
				$cancelResponse = $cancelResponse['alipay_trade_pay_response'];

				if (($cancelResponse['code'] == '10000') && ($cancelResponse['retry_flag'] == 'N')) {
					$cancelJOSN = json_encode(array('error' => 1, 'msg' => '订单支付失败已经撤销了！'));
					exit();
				}

			}

		}


		unset($response);
		return $returnResponse;
	}

	public function f2fqrpay($datas, $notify_url = false)
	{
		date_default_timezone_set('Asia/Shanghai');
		set_time_limit(150);
		bpBase::loadOrg('Alipay/Request/AlipayTradePrecreateRequest');
		$time_expire = date('Y-m-d H:i:s', time() + 600);
		$biz_content = '{"out_trade_no":"' . $datas['order_id'] . '",';
		$biz_content .= '"total_amount":"' . $datas['price'] . '",';
		$biz_content .= '"subject":"' . $datas['tname'] . '","body":"' . $datas['tname'] . '",';
		$biz_content .= '"operator_id":"op002","store_id":"lhs002",';

		if (!empty($this->aliPayConfig['pid'])) {
			$biz_content .= '"seller_id":"' . $this->aliPayConfig['pid'] . '",';
		}


		$biz_content .= '"time_expire":"' . $time_expire . '"}';
		$request = new AlipayTradePrecreateRequest();
		$request->setBizContent($biz_content);
		$response = $this->aopclient_request_execute($request, true, $notify_url);
		$returnResponse = array('error' => 1, 'msg' => '二维码生成失败');
		$isSUCCESS = true;

		if (!empty($response) && isset($response['alipay_trade_precreate_response'])) {
			$response = $response['alipay_trade_precreate_response'];

			if ($response['code'] == '40004') {
				$returnResponse = array('error' => 1, 'msg' => $response['sub_msg']);
			}
			 else if ($response['code'] == '10000') {
				$returnResponse = $response;
				$returnResponse['error'] = 0;
			}
			 else if (isset($response['sub_msg']) && !empty($response['sub_msg'])) {
				$returnResponse = array('error' => 1, 'msg' => $response['sub_msg']);
			}
			 else {
				$returnResponse = array('error' => 1, 'msg' => '二维码生成失败！');
			}
		}


		unset($response);
		return $returnResponse;
	}

	public function queryTrade($out_trade_no, &$succResult)
	{
		bpBase::loadOrg('Alipay/Request/AlipayTradeQueryRequest');
		$biz_content = '{"out_trade_no":"' . $out_trade_no . '"}';
		$qrequest = new AlipayTradeQueryRequest();
		$qrequest->setBizContent($biz_content);
		$queryResp = $this->aopclient_request_execute($qrequest);

		if (!empty($queryResp) && isset($queryResp['alipay_trade_pay_response'])) {
			$queryResp = $queryResp['alipay_trade_pay_response'];

			if ($queryResp['code'] == '10000') {
				if ($queryResp['trade_status'] == 'TRADE_SUCCESS') {
					$queryResp['ispay'] = 1;
					$succResult = 1;
				}
				 else if ($queryResp['trade_status'] == 'WAIT_BUYER_PAY') {
					$queryResp['ispay'] = 0;
					$succResult = 2;
				}
				 else {
					$queryResp['ispay'] = 0;
					$succResult = 2;
				}

				return $queryResp;
			}


			$succResult = 0;
			return false;
		}


		$succResult = 0;
		return false;
	}

	public function queryOrder($out_trade_no)
	{
		bpBase::loadOrg('Alipay/Request/AlipayTradeQueryRequest');
		$biz_content = '{"out_trade_no":"' . $out_trade_no . '"}';
		$request = new AlipayTradeQueryRequest();
		$request->setBizContent($biz_content);
		$response = $this->aopclient_request_execute($request);
		return $response;
	}

	public function cancel($out_trade_no)
	{
		bpBase::loadOrg('Alipay/Request/AlipayTradeCancelRequest');
		$biz_content = '{"out_trade_no":"' . $out_trade_no . '"}';
		$request = new AlipayTradeCancelRequest();
		$request->setBizContent($biz_content);
		$response = $this->aopclient_request_execute($request);
		return $response;
	}

	public function aliRefund($trade_no, $refund_amount, $out_request_no,$appauthtoken)
	{
		bpBase::loadOrg('Alipay/Request/AlipayTradeRefundRequest');
		$biz_content = '{"trade_no":"' . $trade_no . '","refund_amount":"' . $refund_amount . '","out_request_no":"' . $out_request_no . '","refund_reason":"正常退款"}';
        $newResp = array('error' => 1, 'msg' => $biz_content);
        //return $newResp;
		$request = new AlipayTradeRefundRequest();
		$request->setBizContent($biz_content);
		$response = $this->aopclient_request_execute($request,$appauthtoken);
		$newResp = array('error' => 1, 'msg' => '退款失败！');

		if (!empty($response) && isset($response['alipay_trade_refund_response'])) {
			$response = $response['alipay_trade_refund_response'];

			if ($response['code'] == '40004') {
				$newResp = array('error' => 1, 'msg' => $response['sub_msg']);
			}
			 else if ($response['code'] == '10000') {
				if ($response['fund_change'] == 'Y') {
					$newResp = array('error' => 0, 'data' => $response);
				}
				 else {
					$newResp = array('error' => 1, 'msg' => '此订单您已经退过款了！');
				}
			}
			 else if (isset($response['sub_msg']) && !empty($response['sub_msg'])) {
				$newResp = array('error' => 1, 'msg' => $response['sub_msg']);
			}
			 else {
				$newResp = array('error' => 1, 'msg' => '退款失败了！');
			}
		}


		unset($response);
		return $newResp;
	}

	public function characet($data)
	{
		if (!empty($data)) {
			$fileType = mb_detect_encoding($data, array('UTF-8', 'GBK', 'GB2312', 'LATIN1', 'BIG5'));

			if ($fileType != 'UTF-8') {
				$data = mb_convert_encoding($data, 'UTF-8', $fileType);
			}

		}


		return $data;
	}
}


?>
<?php
class weixinPay
{
	public function __construct()
	{
		bpBase::loadOrg('WxPay/WxPay.Api');
		bpBase::loadOrg('WxPay/WxPay.Log');
	}

	public function micropay($data)
	{
		bpBase::loadOrg('WxPay/WxPay.MicroPay');
		$input = new WxPayMicroPay();
		$input->SetAuth_code($data['auth_code']);
		$input->SetBody($data['goods_name']);
		$input->SetTotal_fee($data['goods_price'] * 100);
		$input->SetOut_trade_no($data['order_id']);
		$microPay = new MicroPay();
		return $microPay->pay($input);
	}
	
    /**
     * 微信扫二维码支付
     * @param unknown $wx_user
     * @param unknown $datas
     */
	public function mobilepay($wx_user, $datas)
	{
		$notify_url = SITEURL;
        
		if (defined('ABS_UPLOAD_PATH')) {
			$notify_url = SITEURL . ABS_UPLOAD_PATH;
		}
		
        
		$notify_url = $notify_url . '/pay/wxpay/wxasyn_notice.php?merid=' . $datas['mid'] . '&ordid=' . $datas['orderid'];
		//微信支付类
		bpBase::loadOrg('WxSaoMaPay/WxPayPubHelper');
		//调起微信支付
		$jsApi = new JsApi_pub($wx_user['appid'], $wx_user['mchid'], $wx_user['key'], $wx_user['appSecret']);
		
		$unifiedOrder = new UnifiedOrder_pub($wx_user['appid'], $wx_user['mchid'], $wx_user['key'], $wx_user['appSecret']);
		
		if (defined('WxPay_SUBAPPID') && isset($wx_user['submchinfo']) && defined('WxPay_SUBopenid')) {
		   
			$unifiedOrder->setParameter('sub_appid', WxPay_SUBAPPID);
		}
        
		
		/*
		 *  添加平台子商户号
		 */
		
		if (defined('WxPay_SUBMCHID')) {
		
		    $unifiedOrder->setParameter('sub_mch_id', WxPay_SUBMCHID);
		}
		/* if (defined('WxPay_SUBMCHID') && isset($wx_user['submchinfo'])) {
		    
			$unifiedOrder->setParameter('sub_mch_id', WxPay_SUBMCHID);
		} */
		

		if (defined('WxPay_SUBAPPID') && isset($wx_user['submchinfo']) && defined('WxPay_SUBopenid')) {
			$unifiedOrder->setParameter('sub_openid', $_SESSION['my_Cashier_openid']);
		}
		 else {
			$unifiedOrder->setParameter('openid', $_SESSION['my_Cashier_openid']);
		}
        
		$unifiedOrder->setParameter('body', $datas['goods_name']);
		$unifiedOrder->setParameter('out_trade_no', $datas['order_id']);
		$unifiedOrder->setParameter('total_fee', floatval($datas['goods_price'] * 100));
		$unifiedOrder->setParameter('notify_url', $notify_url);
		$unifiedOrder->setParameter('trade_type', 'JSAPI');
        $unifiedOrder->setParameter('time_start', date('YmdHis',time()));
        $unifiedOrder->setParameter('time_expire', date('YmdHis',strtotime("+6 min")));
		$unifiedOrder->setParameter('attach', 'weixin');
		$prepay_result = $unifiedOrder->getPrepayId();
      
		if ($prepay_result['return_code'] == 'FAIL') {
		    var_dump($unifiedOrder);die;
			return array('error' => 1, 'msg' => '没有获取微信支付的预支付ID，请重新发起支付！微信支付错误返回：' . $prepay_result['return_msg']);
		}


		if ($prepay_result['err_code']) {
			return array('error' => 1, 'msg' => '没有获取微信支付的预支付ID，请重新发起支付！<br/><br/>微信支付错误返回：' . $prepay_result['err_code_des']);
		}


		$jsApi->setPrepayId($prepay_result['prepay_id']);
		
		return array('error' => 0, 'weixin_param' => $jsApi->getParameters());
	}
}


?>
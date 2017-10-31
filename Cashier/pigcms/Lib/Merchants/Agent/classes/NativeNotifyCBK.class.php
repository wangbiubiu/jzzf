<?php

class NativeNotifyCBK
{
	public $wxinfo;
	public $openid;

	public function __construct()
	{
		bpBase::loadOrg('WxPay/WxPay.Api');
		bpBase::loadOrg('WxPay/WxPay.Log');
		bpBase::loadOrg('WxPay/WxPay.Notify');
		$this->NativeNotifyCallBack();
	}

	public function NativeNotifyCallBack()
	{
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];

		if (empty($xml)) {
			exit('非法访问,请速速离去！');
		}


		$msg = 'OK';
		$wxpayHandle = new WxPayNotify();
		$data = WxPayResults::Init($xml);
		if (!array_key_exists('openid', $data) || !array_key_exists('product_id', $data)) {
			$msg = '回调数据异常';
			$wxpayHandle->SetReturn_code('FAIL');
			$wxpayHandle->SetReturn_msg($msg);
			$wxpayHandle->ReplyNotify(false);
			return;
		}


		$_SEESION['open_id'] = $this->openid = $data['openid'];
		$product_idarr = explode('_', $data['product_id']);
		$orderDb = M('cashier_order');
		$this->wxinfo = M('cashier_payconfig')->getwxuserConf($product_idarr[0]);
		$ordertmp = $orderDb->get_one(array('id' => $product_idarr[1], 'mid' => $product_idarr[0]), '*');
		$orderDb->update(array('pay_way' => 'weixin', 'pay_type' => 'wxsaoma2pay'), array('id' => $ordertmp['id'], 'mid' => $ordertmp['mid']));
		$notify_url = SITEURL;

		if (defined('ABS_UPLOAD_PATH')) {
			$notify_url = SITEURL . ABS_UPLOAD_PATH;
		}


		$notify_url = $notify_url . '/pay/wxpay/wxasyn_notice.php?merid=' . $ordertmp['mid'] . '&ordid=' . $ordertmp['id'];
		$input = new WxPayUnifiedOrder();
		$input->SetBody($ordertmp['goods_name']);
		$input->SetAttach('weixin');
		$input->SetOut_trade_no($ordertmp['order_id']);
		$input->SetTotal_fee(floatval($ordertmp['goods_price'] * 100));
		$input->SetNotify_url($notify_url);
		$input->SetTrade_type('NATIVE');
		$input->SetOpenid($this->openid);
		$input->SetProduct_id($ordertmp['mid'] . '_' . $ordertmp['id']);
		$result = WxPayApi::unifiedOrder($input);
		if (!array_key_exists('appid', $result) || !array_key_exists('mch_id', $result) || !array_key_exists('prepay_id', $result)) {
			$msg = '统一下单失败了';

			if (isset($result['err_code'])) {
				$msg = '统一下单失败了' . "\n" . '错误代码：' . $result['err_code'] . "\n" . '错误描述：' . $result['err_code_des'];
			}


			$wxpayHandle->SetReturn_code('FAIL');
			$wxpayHandle->SetReturn_msg($msg);
			$wxpayHandle->ReplyNotify(false);
			return;
		}


		$wxpayHandle->SetData('appid', $result['appid']);
		$wxpayHandle->SetData('mch_id', $result['mch_id']);
		$wxpayHandle->SetData('nonce_str', WxPayApi::getNonceStr());
		$wxpayHandle->SetData('prepay_id', $result['prepay_id']);
		$wxpayHandle->SetData('result_code', 'SUCCESS');
		$wxpayHandle->SetData('err_code_des', 'OK');
		$wxpayHandle->SetReturn_code('SUCCESS');
		$wxpayHandle->SetReturn_msg('OK');
		$wxpayHandle->ReplyNotify(true);
	}
}


?>
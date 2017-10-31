<?php
class AliPayClass
{
	private $aliPayConfig;

	public function __construct($aliPayConfig)
	{
		bpBase::loadOrg('Alipay/Notifylib/alipay_submit');
		bpBase::loadOrg('Alipay/Notifylib/alipay_notify');
		$this->aliPayConfig = array('private_key_path' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_private_key.pem', 'merchant_rsa_public_key' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'rsa_public_key.pem', 'input_charset' => 'utf-8', 'ali_public_key_path' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'alipay_public_key.pem', 'gatewayUrl' => 'https://openapi.alipay.com/gateway.do', 'app_id' => $aliPayConfig['appid'], 'key' => $aliPayConfig['key'], 'name' => $aliPayConfig['name'], 'pid' => $aliPayConfig['pid'], 'sign_type' => 'RSA', 'transport' => 'http', 'cacert' => CMSBASEDIR . DIRECTORY_SEPARATOR . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . 'Alipay' . DIRECTORY_SEPARATOR . 'cacert.pem');
		
	}

	public function aliWapPay($datas)
	{
		$payment_type = '1';
		$md5str = md5('ali1p@ay3wap' . $datas['mid'] . $datas['id']);
		$codeStr = $datas['mid'] . '-' . $datas['id'] . '-' . $md5str;
		$codeStr = Encryptioncode($codeStr, 'ENCODE');
		$codeStr = str_replace('+', '_', $codeStr);
		$codeStr = str_replace('/', '-', $codeStr);
		$notify_url = $datas['SiteUrl'] . '?myparam=' . $codeStr;
		$parameter = array('service' => 'alipay.wap.create.direct.pay.by.user', 'partner' => trim($this->aliPayConfig['pid']), 'seller_id' => trim($this->aliPayConfig['pid']), 'payment_type' => $payment_type, 'notify_url' => $notify_url, 'out_trade_no' => $datas['order_id'], 'subject' => $datas['goods_name'], 'total_fee' => $datas['goods_price'], 'body' => $datas['goods_name'], '_input_charset' => trim(strtolower($this->aliPayConfig['input_charset'])));
		$alipaySubmit = new AlipaySubmit($this->aliPayConfig);
		$html_text = $alipaySubmit->buildRequestForm($parameter, 'post', '确认');
		
		
		echo $html_text;
	}

	public function verifyNotifyRequest()
	{
		$alipayNotify = new AlipayNotify($this->aliPayConfig);
		$verify_result = $alipayNotify->verifyNotify();
		return $verify_result;
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
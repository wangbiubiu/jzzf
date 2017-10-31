<?php
class WxApi
{
	const appId = '';
	const appSecret = '';
	const mchid = '';
	const privatekey = '';

	public $parameters = array();
	public $jsApiTicket;
	public $jsApiTime;

	public function __construct()
	{
	}

	public function wxHttpsRequest($url, $data = NULL)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

		if (!empty($data)) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}


		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);
		curl_close($curl);
		return $output;
	}

	public function wxHttpsRequestPem($url, $vars, $second = 30, $aHeader = array())
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_TIMEOUT, $second);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, getcwd() . '/apiclient_cert.pem');
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, getcwd() . '/apiclient_key.pem');
		curl_setopt($ch, CURLOPT_CAINFO, 'PEM');
		curl_setopt($ch, CURLOPT_CAINFO, getcwd() . '/rootca.pem');

		if (1 <= count($aHeader)) {
			curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
		}


		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $vars);
		$data = curl_exec($ch);

		if ($data) {
			curl_close($ch);
			return $data;
		}


		$error = curl_errno($ch);
		echo 'call faild, errorCode:' . $error . "\n";
		curl_close($ch);
		return false;
	}

	public function wxAccessToken($appId = NULL, $appSecret = NULL)
	{
		$appId = ((is_null($appId) ? self::appId : $appId));
		$appSecret = ((is_null($appSecret) ? self::appSecret : $appSecret));
		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appId . '&secret=' . $appSecret;
		$result = $this->wxHttpsRequest($url);
		$jsoninfo = json_decode($result, true);
		$access_token = $jsoninfo['access_token'];
		return $access_token;
	}

	public function wxJsApiTicket($appId = NULL, $appSecret = NULL)
	{
		$appId = ((is_null($appId) ? self::appId : $appId));
		$appSecret = ((is_null($appSecret) ? self::appSecret : $appSecret));
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=' . $this->wxAccessToken();
		$result = $this->wxHttpsRequest($url);
		$jsoninfo = json_decode($result, true);
		$ticket = $jsoninfo['ticket'];
		return $ticket;
	}

	public function wxVerifyJsApiTicket($appId = NULL, $appSecret = NULL)
	{
		if (!empty($this->jsApiTime) && (time() < intval($this->jsApiTime)) && !empty($this->jsApiTicket)) {
			$ticket = $this->jsApiTicket;
		}
		 else {
			$ticket = $this->wxJsApiTicket($appId, $appSecret);
			$this->jsApiTicket = $ticket;
			$this->jsApiTime = time() + 7200;
		}

		return $ticket;
	}

	public function wxGetUser($openId)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $wxAccessToken . '&openid=' . $openId . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxQrCodeTicket($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxQrCode($ticket)
	{
		$url = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . urlencode($ticket);
		return $url;
	}

	public function wxSetSend($touser, $template_id, $url, $data, $topcolor = '#7B68EE')
	{
		$template = array('touser' => $touser, 'template_id' => $template_id, 'url' => $url, 'topcolor' => $topcolor, 'data' => $data);
		$jsonData = json_encode($template);
		$result = $this->wxSendTemplate($jsonData);
		return $result;
	}

	public function wxOauthBase($redirectUrl, $state = '', $appId = NULL)
	{
		$appId = ((is_null($appId) ? self::appId : $appId));
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appId . '&redirect_uri=' . $redirectUrl . '&response_type=code&scope=snsapi_base&state=' . $state . '#wechat_redirect';
		return $url;
	}

	public function wxOauthUserinfo($redirectUrl, $state = '', $appId = NULL)
	{
		$appId = ((is_null($appId) ? self::appId : $appId));
		$url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appId . '&redirect_uri=' . $redirectUrl . '&response_type=code&scope=snsapi_userinfo&state=' . $state . '#wechat_redirect';
		return $url;
	}

	public function wxHeader($url)
	{
		header('location:' . $url);
	}

	public function wxOauthAccessToken($code, $appId = NULL, $appSecret = NULL)
	{
		$appId = ((is_null($appId) ? self::appId : $appId));
		$appSecret = ((is_null($appSecret) ? self::appSecret : $appSecret));
		$url = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $appId . '&secret=' . $appSecret . '&code=' . $code . '&grant_type=authorization_code';
		$result = $this->wxHttpsRequest($url);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxOauthUser($OauthAT, $openId)
	{
		$url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $OauthAT . '&openid=' . $openId . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxNonceStr($length = 16, $type = false)
	{
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str = '';
		$i = 0;

		while ($i < $length) {
			$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			++$i;
		}

		if ($type == true) {
			return strtoupper(md5(time() . $str));
		}


		return $str;
	}

	public function wxMchBillno($mchid = NULL)
	{
		if (is_null($mchid)) {
			if ((self::mchid == '') || is_null(self::mchid)) {
				$mchid = time();
			}
			 else {
				$mchid = self::mchid;
			}
		}
		 else {
			$mchid = substr(addslashes($mchid), 0, 10);
		}

		return date('Ymd', time()) . time() . $mchid;
	}

	public function wxSetParam($parameters)
	{
		if (is_array($parameters) && !empty($parameters)) {
			$this->parameters = $parameters;
			return $this->parameters;
		}


		return array();
	}

	public function wxFormatArray($parameters = NULL, $urlencode = false)
	{
		if (is_null($parameters)) {
			$parameters = $this->parameters;
		}


		$restr = '';
		ksort($parameters);

		foreach ($parameters as $k => $v ) {
			if ((NULL != $v) && ('null' != $v) && ('sign' != $k)) {
				if ($urlencode) {
					$v = urlencode($v);
				}


				$restr .= $k . '=' . $v . '&';
			}

		}

		if (0 < strlen($restr)) {
			$restr = substr($restr, 0, strlen($restr) - 1);
		}


		return $restr;
	}

	public function wxMd5Sign($content, $privatekey)
	{
		try {
			if (is_null($privatekey)) {
				throw new Exception('财付通签名key不能为空！');
			}


			if (is_null($content)) {
				throw new Exception('财付通签名内容不能为空');
			}


			$signStr = $content . '&key=' . $privatekey;
			return strtoupper(md5($signStr));
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function wxSha1Sign($content)
	{
		try {
			if (is_null($content)) {
				throw new Exception('签名内容不能为空');
			}


			return sha1($content);
		}
		catch (Exception $e) {
			exit($e->getMessage());
		}
	}

	public function wxJsapiPackage()
	{
		$jsapi_ticket = $this->wxVerifyJsApiTicket();
		$protocol = (((!empty($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] !== 'off')) || ($_SERVER['SERVER_PORT'] == 443) ? 'https://' : 'http://'));
		$url = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$timestamp = time();
		$nonceStr = $this->wxNonceStr();
		$signPackage = array('jsapi_ticket' => $jsapi_ticket, 'nonceStr' => $nonceStr, 'timestamp' => $timestamp, 'url' => $url);
		$rawString = 'jsapi_ticket=' . $jsapi_ticket . '&noncestr=' . $nonceStr . '&timestamp=' . $timestamp . '&url=' . $url;
		$signature = $this->wxSha1Sign($rawString);
		$signPackage['signature'] = $signature;
		$signPackage['rawString'] = $rawString;
		$signPackage['appId'] = self::appId;
		return $signPackage;
	}

	public function wxCardPackage($cardId, $timestamp = '')
	{
		$api_ticket = $this->wxVerifyJsApiTicket();

		if (!empty($timestamp)) {
			$timestamp = $timestamp;
		}
		 else {
			$timestamp = time();
		}

		$arrays = array(self::appSecret, $timestamp, $cardId);
		sort($arrays, SORT_STRING);
		$string = sha1(implode($arrays));
		$resultArray['cardId'] = $cardId;
		$resultArray['cardExt'] = array();
		$resultArray['cardExt']['code'] = '';
		$resultArray['cardExt']['openid'] = '';
		$resultArray['cardExt']['timestamp'] = $timestamp;
		$resultArray['cardExt']['signature'] = $string;
		return $resultArray;
	}

	public function wxCardAllPackage($cardIdArray = array(), $timestamp = '')
	{
		$reArrays = array();

		if (!empty($cardIdArray) && (is_array($cardIdArray) || is_object($cardIdArray))) {
			foreach ($cardIdArray as $value ) {
				$reArrays[] = $this->wxCardPackage($value, $timestamp);
			}
		}
		 else {
			$reArrays[] = $this->wxCardPackage($cardIdArray, $timestamp);
		}

		return strval(json_encode($reArrays));
	}

	public function wxCardListPackage($cardType = '', $cardId = '')
	{
		$resultArray = array();
		$timestamp = time();
		$nonceStr = $this->wxNonceStr();
		$arrays = array(self::appId, self::appSecret, $timestamp, $nonceStr);
		sort($arrays, SORT_STRING);
		$string = sha1(implode($arrays));
		$resultArray['app_id'] = self::appId;
		$resultArray['card_sign'] = $string;
		$resultArray['time_stamp'] = $timestamp;
		$resultArray['nonce_str'] = $nonceStr;
		$resultArray['card_type'] = $cardType;
		$resultArray['card_id'] = $cardId;
		return $resultArray;
	}

	public function wxArrayToXml($parameters = NULL)
	{
		if (is_null($parameters)) {
			$parameters = $this->parameters;
		}


		if (!is_array($parameters) || empty($parameters)) {
			exit('参数不为数组无法解析');
		}


		$xml = '<xml>';

		foreach ($arr as $key => $val ) {
			if (is_numeric($val)) {
				$xml .= '<' . $key . '>' . $val . '</' . $key . '>';
			}
			 else {
				$xml .= '<' . $key . '><![CDATA[' . $val . ']]></' . $key . '>';
			}
		}

		$xml .= '</xml>';
		return $xml;
	}

	public function wxCardUpdateImg()
	{
		$wxAccessToken = $this->wxAccessToken();
		$data['buffer'] = '@D:\\workspace\\htdocs\\yky_test\\logo.jpg';
		$url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $data);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardColor()
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/getcolors?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardCreated($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/create?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardGetInfo($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/get?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardWhiteList($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/testwhitelist/set?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardConsume($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/code/consume?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardDelete($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/delete?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardDecryptCode($jsonData)
	{
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/code/decrypt?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardModifyStock($cardId, $increase_stock_value = 0, $reduce_stock_value = 0)
	{
		if ((intval($increase_stock_value) == 0) && (intval($reduce_stock_value) == 0)) {
			return false;
		}


		$jsonData = json_encode(array('card_id' => $cardId, 'increase_stock_value' => intval($increase_stock_value), 'reduce_stock_value' => intval($reduce_stock_value)));
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/modifystock?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}

	public function wxCardQueryCode($code, $cardId = '')
	{
		$jsonData = json_encode(array('code' => $code, 'card_id' => $cardId));
		$wxAccessToken = $this->wxAccessToken();
		$url = 'https://api.weixin.qq.com/card/code/get?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		$jsoninfo = json_decode($result, true);
		return $jsoninfo;
	}
}


?>
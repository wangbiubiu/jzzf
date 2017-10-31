<?php
class AopClient
{
	public $appId;
	public $rsaPrivateKeyFilePath;
	public $gatewayUrl = 'https://openapi.alipay.com/gateway.do';
	public $format = 'json';
	public $apiVersion = '1.0';
	public $postCharset = 'UTF-8';
	public $notify_url = 'https://pay.yunjifu.net/merchants.php?m=Index&c=pay&a=alitradepaynotify';
	public $isajax = false;
	public $alipayPublicKey;
	public $debugInfo = false;
	private $fileCharset = 'UTF-8';
	private $RESPONSE_SUFFIX = '_response';
	private $ERROR_RESPONSE = 'error_response';
	private $SIGN_NODE_NAME = 'sign';
	protected $signType = 'RSA';
	protected $alipaySdkVersion = 'alipay-sdk-php-20130320';

	public function __construct($isajax = false)
	{
		$this->isajax = $isajax;
        
		if (!(defined('AOP_SDK_WORK_DIR'))) {
			define('AOP_SDK_WORK_DIR', dirname(CMSBASEDIR) . DIRECTORY_SEPARATOR . 'pay' . DIRECTORY_SEPARATOR . 'alipay' . DIRECTORY_SEPARATOR . 'log' . DIRECTORY_SEPARATOR);
		}
        
	}

	public function generateSign($params)
	{
		return $this->sign($this->getSignContent($params));
	}

	public function rsaSign($params)
	{
		return $this->sign($this->getSignContent($params));
	}

	protected function getSignContent($params)
	{
		ksort($params);
		
		
		
		$stringToBeSigned = '';
		$i = 0;

		foreach ($params as $k => $v ) {
			if ((false === $this->checkEmpty($v)) && ('@' != substr($v, 0, 1))) {
				$v = $this->characet($v, $this->postCharset);

				if ($i == 0) {
					$stringToBeSigned .= $k . '=' . $v;
				}
				 else {
					$stringToBeSigned .= '&' . $k . '=' . $v;
				}

				++$i;
			}

		}

		unset($k);
		unset($v);
		return $stringToBeSigned;
	}

	protected function sign($data)
	{  
	    
		$priKey = file_get_contents($this->rsaPrivateKeyFilePath);
		$res = openssl_pkey_get_private($priKey);
		openssl_sign($data, $sign, $res);
		openssl_free_key($res);
		$sign = base64_encode($sign);
		//$sign = base64_encode($priKey);
		return $sign;
	}

	protected function curl($url, $postFields = NULL)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$postBodyString = '';
		$encodeArray = array();  
		if (is_array($postFields) && (0 < count($postFields))) {
			$postMultipart = false;

			foreach ($postFields as $k => $v ) {
				if ('@' != substr($v, 0, 1)) {
					$postBodyString .= $k . '=' . urlencode($this->characet($v, $this->postCharset)) . '&';
				}
				 else {
					$postMultipart = true;
					$encodeArray[$k] = urlencode($this->characet($v, $this->postCharset));
				}
			}

			unset($k);
			unset($v);
			curl_setopt($ch, CURLOPT_POST, true);

			if ($postMultipart) {
				curl_setopt($ch, CURLOPT_POSTFIELDS, $encodeArray);
			}
			 else {
				curl_setopt($ch, CURLOPT_POSTFIELDS, substr($postBodyString, 0, -1));
			}
		}


		$headers = array('content-type: application/x-www-form-urlencoded;charset=' . $this->postCharset);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$reponse = curl_exec($ch);
		if (curl_errno($ch)) {
			throw new Exception(curl_error($ch), 0);
		}
		 else {
			$httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

			if (200 !== $httpStatusCode) {
				throw new Exception($reponse, $httpStatusCode);
			}

		}

		curl_close($ch);
		return $reponse;
	}

	protected function logCommunicationError($apiName, $requestUrl, $errorCode, $responseTxt)
	{
		$localIp = ((isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : 'CLI'));
		$logger = new LtLogger();
		$logger->conf['log_file'] = rtrim(AOP_SDK_WORK_DIR, '\\/') . '/' . 'logs/aop_comm_err_' . $this->appId . '_' . date('Y-m-d') . '.log';
		$logger->conf['separator'] = '^_^';
		$logData = array(date('Y-m-d H:i:s'), $apiName, $this->appId, $localIp, PHP_OS, $this->alipaySdkVersion, $requestUrl, $errorCode, str_replace("\n", '', $responseTxt));
		$logger->log($logData);
	}

	public function execute($request, $authToken = NULL)
	{
		if ($this->checkEmpty($this->postCharset)) {
			$this->postCharset = 'UTF-8';
		}


		$this->fileCharset = mb_detect_encoding($this->appId, 'UTF-8,GBK');

		if (strcasecmp($this->fileCharset, $this->postCharset)) {
			if ($this->isajax) {
				$this->dexit(array('error' => 1, 'msg' => '文件编码：[' . $this->fileCharset . '] 与表单提交编码：[' . $this->postCharset . ']两者不一致!'));
			}
			 else {
				throw new Exception('文件编码：[' . $this->fileCharset . '] 与表单提交编码：[' . $this->postCharset . ']两者不一致!');
				exit();
			}
		}


		$iv = NULL;

		if (!($this->checkEmpty($request->getApiVersion()))) {
			$iv = $request->getApiVersion();
		}
		 else {
			$iv = $this->apiVersion;
		}

		$sysParams['app_id'] = $this->appId;
		$sysParams['version'] = $iv;
		$sysParams['format'] = $this->format;
		$sysParams['sign_type'] = $this->signType;
		$sysParams['method'] = $request->getApiMethodName();//'alipay.trade.query';
		$sysParams['timestamp'] = date('Y-m-d H:i:s');
		$sysParams['alipay_sdk'] = $this->alipaySdkVersion;
		$sysParams['charset'] = $this->postCharset;
        $sysParams["app_auth_token"] = $authToken;
		!(empty($this->notify_url)) && ($sysParams['notify_url'] = $this->notify_url);
		
		$apiParams = $request->getApiParas();
		
		$sysParams['sign'] = $this->generateSign(array_merge($apiParams, $sysParams));
		$requestUrl = $this->gatewayUrl . '?';

		foreach ($sysParams as $sysParamKey => $sysParamValue ) {
			$requestUrl .= $sysParamKey . '=' . urlencode($this->characet($sysParamValue, $this->postCharset)) . '&';
		}

		$requestUrl = substr($requestUrl, 0, -1);
        
		try {
			$resp = $this->curl($requestUrl, $apiParams);
		}
		catch (Exception $e) {
			if ($this->isajax) {
				$this->dexit(array('error' => 1, 'msg' => 'HTTP_ERROR_' . $e->getCode() . $e->getMessage()));
			}
			 else {
				$this->logCommunicationError($sysParams['method'], $requestUrl, 'HTTP_ERROR_' . $e->getCode(), $e->getMessage());
				return false;
			}
		}

		$respWellFormed = false;
		$r = iconv($this->postCharset, $this->fileCharset . '//IGNORE', $resp);
		$signData = NULL;
		$respArr = array();

		if ('json' == $this->format) {
			$respObject = json_decode($r);
			$respArr = json_decode($r, true);

			if (NULL !== $respObject) {
				$respWellFormed = true;
				$signData = $this->parserJSONSignData($request, $resp, $respObject);
			}

		}
		 else if ('xml' == $this->format) {
			$respObject = @simplexml_load_string($resp);

			if (false !== $respObject) {
				$respWellFormed = true;
				$signData = $this->parserXMLSignData($request, $resp);
			}

		}


		if (!($this->checkEmpty($this->alipayPublicKey)) && false) {
			if (($signData == NULL) || $this->checkEmpty($signData->sign) || $this->checkEmpty($signData->signSourceData)) {
				if ($this->isajax) {
					$this->dexit(array('error' => 1, 'msg' => ' check sign Fail! The reason : signData is Empty'));
				}
				 else {
					throw new Exception(' check sign Fail! The reason : signData is Empty');
				}
			}


			if (!($this->checkEmpty($respObject->sub_code)) || ($this->checkEmpty($respObject->sub_code) && !($this->checkEmpty($signData->sign)))) {
				$checkResult = $this->verify($signData->signSourceData, $signData->sign, $this->alipayPublicKey);

				if (!($checkResult)) {
					if (0 < strpos($signData->signSourceData, '\\/')) {
						$signData->signSourceData = str_replace('\\/', '/', $signData->signSourceData);
						$checkResult = $this->verify($signData->signSourceData, $signData->sign, $this->alipayPublicKey);

						if (!($checkResult)) {
							if ($this->isajax) {
								$this->dexit(array('error' => 1, 'msg' => 'check sign Fail! [sign=' . $signData->sign . ', signSourceData=' . $signData->signSourceData . ']'));
							}
							 else {
								throw new Exception('check sign Fail! [sign=' . $signData->sign . ', signSourceData=' . $signData->signSourceData . ']');
							}
						}

					}
					 else if ($this->isajax) {
						$this->dexit(array('error' => 1, 'msg' => 'check sign Fail! [sign=' . $signData->sign . ', signSourceData=' . $signData->signSourceData . ']'));
					}
					 else {
						throw new Exception('check sign Fail! [sign=' . $signData->sign . ', signSourceData=' . $signData->signSourceData . ']');
					}
				}

			}

		}


		return $respArr;
	}

	protected function dexit($data = '')
	{
		if (is_array($data)) {
			echo json_encode($data);
		}
		 else {
			echo $data;
		}

		exit();
	}

	public function characet($data, $targetCharset)
	{
		if (!(empty($data))) {
			$fileType = $this->fileCharset;

			if (strcasecmp($fileType, $targetCharset) != 0) {
				$data = mb_convert_encoding($data, $targetCharset);
			}

		}


		return $data;
	}

	public function exec($paramsArray)
	{
		if (!(isset($paramsArray['method']))) {
			trigger_error('No api name passed');
		}


		$inflector = new LtInflector();
		$inflector->conf['separator'] = '.';
		$requestClassName = ucfirst($inflector->camelize(substr($paramsArray['method'], 7))) . 'Request';

		if (!(class_exists($requestClassName))) {
			trigger_error('No such api: ' . $paramsArray['method']);
		}


		$session = ((isset($paramsArray['session']) ? $paramsArray['session'] : NULL));
		$req = new $requestClassName();

		foreach ($paramsArray as $paraKey => $paraValue ) {
			$inflector->conf['separator'] = '_';
			$setterMethodName = $inflector->camelize($paraKey);
			$inflector->conf['separator'] = '.';
			$setterMethodName = 'set' . $inflector->camelize($setterMethodName);

			if (method_exists($req, $setterMethodName)) {
				$req->$setterMethodName($paraValue);
			}

		}

		return $this->execute($req, $session);
	}

	protected function checkEmpty($value)
	{
		if (!(isset($value))) {
			return true;
		}


		if ($value === NULL) {
			return true;
		}


		if (trim($value) === '') {
			return true;
		}


		return false;
	}

	public function rsaCheckV1($params, $rsaPublicKeyFilePath)
	{
		$sign = $params['sign'];
		$params['sign_type'] = NULL;
		$params['sign'] = NULL;
		return $this->verify($this->getSignContent($params), $sign, $rsaPublicKeyFilePath);
	}

	public function rsaCheckV2($params, $rsaPublicKeyFilePath)
	{
		$sign = $params['sign'];
		$params['sign'] = NULL;
		return $this->verify($this->getSignContent($params), $sign, $rsaPublicKeyFilePath);
	}

	public function verify($data, $sign, $rsaPublicKeyFilePath)
	{
		$pubKey = file_get_contents($rsaPublicKeyFilePath);
		$res = openssl_get_publickey($pubKey);
		$result = (bool) openssl_verify($data, base64_decode($sign), $res);
		openssl_free_key($res);
		return $result;
	}

	public function checkSignAndDecrypt($params, $rsaPublicKeyPem, $rsaPrivateKeyPem, $isCheckSign, $isDecrypt)
	{
		$charset = $params['charset'];
		$bizContent = $params['biz_content'];

		if ($isCheckSign) {
			if (!($this->rsaCheckV2($params, $rsaPublicKeyPem))) {
				echo '<br/>checkSign failure<br/>';
				exit();
			}
		}
		if ($isDecrypt) {
			return $this->rsaDecrypt($bizContent, $rsaPrivateKeyPem, $charset);
		}


		return $bizContent;
	}

	public function encryptAndSign($bizContent, $rsaPublicKeyPem, $rsaPrivateKeyPem, $charset, $isEncrypt, $isSign)
	{
		if ($isEncrypt && $isSign) {
			$encrypted = $this->rsaEncrypt($bizContent, $rsaPublicKeyPem, $charset);
			$sign = $this->sign($bizContent);
			$response = '<?xml version="1.0" encoding="' . $charset . '"?><alipay><response>' . $encrypted . '</response><encryption_type>RSA</encryption_type><sign>' . $sign . '</sign><sign_type>RSA</sign_type></alipay>';
			return $response;
		}


		if ($isEncrypt && !($isSign)) {
			$encrypted = $this->rsaEncrypt($bizContent, $rsaPublicKeyPem, $charset);
			$response = '<?xml version="1.0" encoding="' . $charset . '"?><alipay><response>' . $encrypted . '</response><encryption_type>RSA</encryption_type></alipay>';
			return $response;
		}


		if (!($isEncrypt) && $isSign) {
			$sign = $this->sign($bizContent);
			$response = '<?xml version="1.0" encoding="' . $charset . '"?><alipay><response>' . $bizContent . '</response><sign>' . $sign . '</sign><sign_type>RSA</sign_type></alipay>';
			return $response;
		}


		$response = '<?xml version="1.0" encoding="' . $charset . '"?>' . $bizContent;
		return $response;
	}

	public function rsaEncrypt($data, $rsaPublicKeyPem, $charset)
	{
		$pubKey = file_get_contents($rsaPublicKeyPem);
		$res = openssl_get_publickey($pubKey);
		$blocks = $this->splitCN($data, 0, 30, $charset);
		$_obfuscate_Y2hydGV4dMKg = NULL;
		$_obfuscate_ZW5jb2Rlc8Kg = array();

		foreach ($blocks as $n => $block ) {
			if (!(openssl_public_encrypt($block, $_obfuscate_Y2hydGV4dMKg, $res))) {
				echo '<br/>' . openssl_error_string() . '<br/>';
			}


			$encodes[] = $_obfuscate_Y2hydGV4dMKg;
		}

		$chrtext = implode(',', $encodes);
		return $chrtext;
	}

	public function rsaDecrypt($data, $rsaPrivateKeyPem, $charset)
	{
		$priKey = file_get_contents($rsaPrivateKeyPem);
		$res = openssl_get_privatekey($priKey);
		$decodes = explode(',', $data);
		$strnull = '';
		$dcyCont = '';

		foreach ($decodes as $n => $decode ) {
			if (!(openssl_private_decrypt($decode, $dcyCont, $res))) {
				echo '<br/>' . openssl_error_string() . '<br/>';
			}


			$strnull .= $dcyCont;
		}

		return $strnull;
	}

	public function splitCN($cont, $n = 0, $subnum, $charset)
	{
		$arrr = array();
		$i = $n;

		while ($i < strlen($cont)) {
			$res = $this->subCNchar($cont, $i, $subnum, $charset);

			if (!(empty($res))) {
				$arrr[] = $res;
			}


			$i += $subnum;
		}

		return $arrr;
	}

	public function subCNchar($str, $start = 0, $length, $charset = 'gbk')
	{
		if (strlen($str) <= $length) {
			return $str;
		}


		$re['utf-8'] = '/[' . "\x1" . '-]|[' . "\xc2" . '-' . "\xdf" . '][' . "\x80" . '-' . "\xbf" . ']|[' . "\xe0" . '-' . "\xef" . '][' . "\x80" . '-' . "\xbf" . ']{2}|[' . "\xf0" . '-' . "\xff" . '][' . "\x80" . '-' . "\xbf" . ']{3}/';
		$re['gb2312'] = '/[' . "\x1" . '-]|[' . "\xb0" . '-' . "\xf7" . '][' . "\xa0" . '-' . "\xfe" . ']/';
		$re['gbk'] = '/[' . "\x1" . '-]|[' . "\x81" . '-' . "\xfe" . '][@-' . "\xfe" . ']/';
		$re['big5'] = '/[' . "\x1" . '-]|[' . "\x81" . '-' . "\xfe" . ']([@-~]|' . "\xa1" . '-' . "\xfe" . '])/';
		preg_match_all($re[$charset], $str, $match);
		$slice = join('', array_slice($match[0], $start, $length));
		return $slice;
	}

	public function parserJSONSignData($request, $responseContent, $responseJSON)
	{
	    bpBase::loadOrg('Alipay/SignData');
		$signData = new SignData();
		$signData->sign = $this->parserJSONSign($responseJSON);
		$signData->signSourceData = $this->parserJSONSignSource($request, $responseContent);
		return $signData;
	}

	public function parserJSONSignSource($request, $responseContent)
	{
		$apiName = $request->getApiMethodName();
		$rootNodeName = str_replace('.', '_', $apiName) . $this->RESPONSE_SUFFIX;
		$rootIndex = strpos($responseContent, $rootNodeName);
		$errorIndex = strpos($responseContent, $this->ERROR_RESPONSE);

		if (0 < $rootIndex) {
			return $this->parserJSONSource($responseContent, $rootNodeName, $rootIndex);
		}


		if (0 < $errorIndex) {
			return $this->parserJSONSource($responseContent, $this->ERROR_RESPONSE, $errorIndex);
		}

	}

	public function parserJSONSource($responseContent, $nodeName, $nodeIndex)
	{
		$signDataStartIndex = $nodeIndex + strlen($nodeName) + 2;
		$signIndex = strpos($responseContent, '"' . $this->SIGN_NODE_NAME . '"');
		$signDataEndIndex = $signIndex - 1;
		$indexLen = $signDataEndIndex - $signDataStartIndex;

		if ($indexLen < 0) {
			return;
		}


		return substr($responseContent, $signDataStartIndex, $indexLen);
	}

	public function parserJSONSign($responseJSon)
	{
		return $responseJSon->sign;
	}

	public function parserXMLSignData($request, $responseContent)
	{
		$signData = new SignData();
		$signData->sign = $this->parserXMLSign($responseContent);
		$signData->signSourceData = $this->parserXMLSignSource($request, $responseContent);
		return $signData;
	}

	public function parserXMLSignSource($request, $responseContent)
	{
		$apiName = $request->getApiMethodName();
		$rootNodeName = str_replace('.', '_', $apiName) . $this->RESPONSE_SUFFIX;
		$rootIndex = strpos($responseContent, $rootNodeName);
		$errorIndex = strpos($responseContent, $this->ERROR_RESPONSE);
		$this->echoDebug('<br/>rootNodeName:' . $rootNodeName);
		$this->echoDebug('<br/> responseContent:<xmp>' . $responseContent . '</xmp>');

		if (0 < $rootIndex) {
			return $this->parserXMLSource($responseContent, $rootNodeName, $rootIndex);
		}


		if (0 < $errorIndex) {
			return $this->parserXMLSource($responseContent, $this->ERROR_RESPONSE, $errorIndex);
		}

	}

	public function parserXMLSource($responseContent, $nodeName, $nodeIndex)
	{
		$signDataStartIndex = $nodeIndex + strlen($nodeName) + 1;
		$signIndex = strpos($responseContent, '<' . $this->SIGN_NODE_NAME . '>');
		$signDataEndIndex = $signIndex - 1;
		$indexLen = ($signDataEndIndex - $signDataStartIndex) + 1;

		if ($indexLen < 0) {
			return;
		}


		return substr($responseContent, $signDataStartIndex, $indexLen);
	}

	public function parserXMLSign($responseContent)
	{
		$signNodeName = '<' . $this->SIGN_NODE_NAME . '>';
		$signEndNodeName = '</' . $this->SIGN_NODE_NAME . '>';
		$indexOfSignNode = strpos($responseContent, $signNodeName);
		$indexOfSignEndNode = strpos($responseContent, $signEndNodeName);
		if (($indexOfSignNode < 0) || ($indexOfSignEndNode < 0)) {
			return;
		}


		$nodeIndex = $indexOfSignNode + strlen($signNodeName);
		$indexLen = $indexOfSignEndNode - $nodeIndex;

		if ($indexLen < 0) {
			return;
		}


		return substr($responseContent, $nodeIndex, $indexLen);
	}

	public function echoDebug($content)
	{
		if ($this->debugInfo) {
			echo '<br/>' . $content;
		}

	}
}


?>
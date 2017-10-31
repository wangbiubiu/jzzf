<?php
class wxCardPack
{
	private $wxuser = '';
	private $_mid = '';
	public $error = array();

	public function __construct($wxuser, $mid = 0)
	{
		$this->wxuser = $wxuser;
		$this->_mid = $mid;
	}

	public function getSgin($access_token)
	{
		$wxuser = getCache('wx_' . $this->_mid . '_user');
		$errorarr = array();
		if (empty($wxuser) || !isset($wxuser['appid'])) {
			$wxuser = array('appid' => $this->wxuser['appid'], 'appsecret' => $this->wxuser['appSecret'], 'share_ticket' => '', 'share_dated' => 0);
			setCache('wx_' . $this->_mid . '_user', $wxuser);
		}


		$now = time();
		if (empty($wxuser['share_ticket']) || empty($wxuser['share_dated']) || (($wxuser['share_ticket'] != '') && ($wxuser['share_dated'] != '') && ($wxuser['share_dated'] < $now))) {
			$ticketData = $this->getTicket($access_token);

			if (0 < $ticketData['errcode']) {
				$errorarr['ticket_error'] = array('errcode' => $ticketData['errcode'], 'errmsg' => $ticketData['errmsg']);
			}
			 else {
				$wxuser['share_ticket'] = $ticketData['ticket'];
				$wxuser['share_dated'] = $now + $ticketData['expires_in'];
				setCache('wx_' . $this->_mid . '_user', $wxuser);
				$ticket = $ticketData['ticket'];
			}
		}
		 else {
			$ticket = $wxuser['share_ticket'];
		}

		$url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$sign_data = $this->addSign($ticket, $url);
		return $sign_data;
	}

	public function getError()
	{
		dump($this->error);
	}

	public function addSign($ticket, $url)
	{
		$timestamp = time();
		$nonceStr = rand(100000, 999999);
		$array = array('noncestr' => $nonceStr, 'jsapi_ticket' => $ticket, 'timestamp' => $timestamp, 'url' => $url);
		ksort($array);
		$signPars = '';

		foreach ($array as $k => $v ) {
			if (('' != $v) && ('sign' != $k)) {
				if ($signPars == '') {
					$signPars .= $k . '=' . $v;
				}
				 else {
					$signPars .= '&' . $k . '=' . $v;
				}
			}

		}

		$result = array('appId' => $this->wxuser['appid'], 'timestamp' => $timestamp, 'nonceStr' => $nonceStr, 'url' => $url, 'signature' => SHA1($signPars));
		return $result;
	}

	public function authorize_openid($redirecturl, $_sessionkey = 'my_Cashier_openid')
	{
	    
		if (empty($_GET['code'])) {
			$_SESSION['weixinstate'] = md5(uniqid());
			$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->wxuser['appid'] . '&redirect_uri=' . urlencode($redirecturl) . '&response_type=code&scope=snsapi_base&state=' . $_SESSION['weixinstate'] . '#wechat_redirect';
			header('Location: ' . $oauthUrl);
			exit();
		}
		 else if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixinstate'])) {
			unset($_SESSION['weixinstate']);
			$jsonrt = $this->https_request('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->wxuser['appid'] . '&secret=' . $this->wxuser['appSecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
			if ($jsonrt['errcode'] || empty($jsonrt['openid'])) {
				return array('error' => 1, 'msg' => '授权发生错误：' . $jsonrt['errcode']);
			}
                       

			if ($jsonrt['openid']) {
				$_SESSION[$_sessionkey] = $jsonrt['openid'];
				return array('error' => 0, 'openid' => $jsonrt['openid']);
			}

		}
		 else {
			return array('error' => 2);
		}
	}

	public function authorize_Web($redirecturl, $prefix = 'web')
	{
		if (empty($_GET['code'])) {
			$_SESSION['weixinstate'] = md5(uniqid());
			$oauthUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $this->wxuser['appid'] . '&redirect_uri=' . urlencode($redirecturl) . '&response_type=code&scope=snsapi_userinfo&state=' . $_SESSION['weixinstate'] . '#wechat_redirect';
			header('Location: ' . $oauthUrl);
			exit();
		}
		 else if (isset($_GET['code']) && isset($_GET['state']) && ($_GET['state'] == $_SESSION['weixinstate'])) {
			unset($_SESSION['weixinstate']);
			$jsonrt = $this->https_request('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . $this->wxuser['appid'] . '&secret=' . $this->wxuser['appSecret'] . '&code=' . $_GET['code'] . '&grant_type=authorization_code');
			if ($jsonrt['errcode'] || empty($jsonrt['openid']) || !isset($jsonrt['access_token'])) {
				return array('error' => 1, 'msg' => '授权发生错误：' . $jsonrt['errcode']);
			}
                       

			if ($jsonrt['openid']) {
				$_SESSION[$prefix . 'openid'] = $jsonrt['openid'];
				$_SESSION[$prefix . 'access_token'] = $jsonrt['access_token'];
				$_SESSION[$prefix . 'token_expires'] = time() + $jsonrt['expires_in'];
				return array('error' => 0, 'webopenid' => $jsonrt['openid'], 'webaccess_token' => $jsonrt['access_token']);
			}

		}
		 else {
			return array('error' => 2, 'msg' => '');
		}
	}
       

	public function GetWebWxUserInfo($webwxAccessToken, $webopenid)
	{
		$url = 'https://api.weixin.qq.com/sns/userinfo?access_token=' . $webwxAccessToken . '&openid=' . $webopenid . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url);
		return $result;
	}

	public function CheckTokenValid($webwxAccessToken, $webopenid)
	{
		$url = 'https://api.weixin.qq.com/sns/auth?access_token=' . $webwxAccessToken . '&openid=' . $webopenid;
		$result = $this->wxHttpsRequest($url);
		return $result;
	}

	public function getToken()
	{
            
		$access_token = getCache('Cache_access_token_' . $this->_mid);
                
//		if ($access_token && is_array($access_token) && (time() < $access_token['expires_in']) && ($access_token['appid'] == $this->wxuser['appid'])) {
//                       
//			return $access_token['access_token'];
//                        
//		}
                //dump($access_token['access_token']);exit;
                
		$SiteUrl = $_SERVER['HTTP_HOST'];
		$SiteUrl = strtolower($SiteUrl);

		if ((strpos($SiteUrl, 'http:') === false) && (strpos($SiteUrl, 'https:') === false)) {
			$SiteUrl = 'http://' . $SiteUrl;
		}


		$SiteUrl = rtrim($SiteUrl, '/');
		$locUrl = $SiteUrl . '/index.php?g=Home&m=OpenApi&a=get_access_token';
                
		$Tokenarr = $this->https_request($locUrl, array('appid' => $this->wxuser['appid']), true);
                
		$Tokenarr = (($Tokenarr && is_string($Tokenarr) ? json_decode($Tokenarr, 1) : false));
		if ($Tokenarr && isset($Tokenarr['access_token']) && !empty($Tokenarr['access_token'])) {
			return $Tokenarr['access_token'];
		}


		$url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $this->wxuser['appid'] . '&secret=' . $this->wxuser['appSecret'];
		$Tokenarr = $this->https_request($url);
                
		if (isset($Tokenarr['access_token'])) {
			$Tokenarr['expires_in'] = time() + $Tokenarr['expires_in'];
			$Tokenarr['appid'] = $this->wxuser['appid'];
			setCache('Cache_access_token_' . $this->_mid, $Tokenarr);
			return $Tokenarr['access_token'];
		}


		return false;
	}

	public function getTicket($token)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $token . '&type=jsapi';
		return $this->https_request($url);
	}

	public function getCardTicket($token)
	{
		$wxuser = getCache('wx_card_' . $this->_mid . '_ticket');
		$errorarr = array();
		$now = time();
		if (empty($wxuser['ticket']) || empty($wxuser['expires_in']) || (($wxuser['ticket'] != '') && ($wxuser['expires_in'] != '') && ($wxuser['expires_in'] < $now))) {
			$url = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=' . $token . '&type=wx_card';
			$ticketData = $this->https_request($url);

			if (0 < $ticketData['errcode']) {
				return array('errcode' => $ticketData['errcode'], 'errmsg' => $ticketData['errmsg']);
			}


			$wxuser['ticket'] = $ticketData['ticket'];
			$wxuser['expires_in'] = $now + $ticketData['expires_in'];
			setCache('wx_card_' . $this->_mid . '_ticket', $wxuser);
			$ticket = $ticketData['ticket'];
		}
		 else {
			$ticket = $wxuser['ticket'];
		}

		return $ticket;
	}

	public function wxCardColor($wxAccessToken)
	{
		$wxColorsList = getCache('Cache_wxColorsList');

		if (!empty($wxColorsList) && is_array($wxColorsList)) {
			return $wxColorsList;
		}


		$url = 'https://api.weixin.qq.com/card/getcolors?access_token=' . $wxAccessToken;
		$result = $this->https_request($url);

		if (isset($result['colors']) && !empty($result['colors'])) {
			setCache('Cache_wxColorsList', $result['colors']);
			return $result['colors'];
		}


		return array(
	array('name' => 'Color010', 'value' => '#63b359'),
	array('name' => 'Color020', 'value' => '#2c9f67'),
	array('name' => 'Color030', 'value' => '#509fc9'),
	array('name' => 'Color040', 'value' => '#5885cf'),
	array('name' => 'Color050', 'value' => '#9062c0'),
	array('name' => 'Color060', 'value' => '#d09a45'),
	array('name' => 'Color070', 'value' => '#e4b138'),
	array('name' => 'Color080', 'value' => '#ee903c'),
	array('name' => 'Color081', 'value' => '#f08500'),
	array('name' => 'Color082', 'value' => '#a9d92d'),
	array('name' => 'Color090', 'value' => '#dd6549'),
	array('name' => 'Color100', 'value' => '#cc463d'),
	array('name' => 'Color101', 'value' => '#cf3e36'),
	array('name' => 'Color102', 'value' => '#5E6671')
	);
	}

	public function wxCardUpdateImg($wxAccessToken, $imgpath)
	{
		//$data['buffer'] = '@' . $imgpath;
                
                if (class_exists('CURLFile')) {
                    $data = array(
                        'media' => new CURLFile($imgpath)
                    );
                } else {
                    $data = array(
                        'media' => '@' . $imgpath
                    );
                }
                
		$url = 'https://api.weixin.qq.com/cgi-bin/media/uploadimg?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $data);
		return $result;
	}

	public function wxUploadFile($wxAccessToken, $data)
	{
		$url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token=' . $wxAccessToken . '&type=' . $data['type'];
		$result = $this->wxHttpsRequest($url, array('media' => $data['media']));
		return $result;
	}

	public function wxCardCreated($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/create?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxCardShop($wxAccessToken, $jsonData)
	{
		$url = 'http://api.weixin.qq.com/cgi-bin/poi/addpoi?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxGetPoiList($wxAccessToken, $limit = '{"begin":0,"limit":50}')
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/poi/getpoilist?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $limit);
		return $result;
	}

	public function wxCardDelete($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/delete?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxCardQrCodeTicket($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/qrcode/create?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxCardQueryCode($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/code/get?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxCardConsume($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/code/consume?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxCardDecryptCode($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/code/decrypt?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxCardModifyStock($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/modifystock?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function GetwxUserInfoByOpenid($wxAccessToken, $openid)
	{
           
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token=' . $wxAccessToken . '&openid=' . $openid . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url);
                
		return $result;
	}

	public function GetwxUserInfoList($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info/batchget?access_token=' . $wxAccessToken . '&lang=zh_CN';
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function GetHtml($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/mpnews/gethtml?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function GetCardInfo($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/get?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function ActivateCard($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/membercard/activate?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function TestWhiteList($wxAccessToken, $jsonData = '{"openid":["oZrMms0Em_h17445dSccyK-ZdQmI","oZrMms12QuDmt_mCJOam85yNF0DI"]}')
	{
		$url = 'https://api.weixin.qq.com/card/testwhitelist/set?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function PayCell($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/paycell/set?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function ActivateUserForm($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/membercard/activateuserform/set?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function LandingPage($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/landingpage/create?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function MemberCardUserInfo($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/membercard/userinfo/get?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function GetApplyProtocol($wxAccessToken)
	{
		$url = 'http://api.weixin.qq.com/cgi-bin/poi/getwxcategory?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url);
		return $result;
	}

	public function GetSubCategroy($wxAccessToken)
	{
		$url = 'http://api.weixin.qq.com/card/getapplyprotocol?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url);
		return $result;
	}

	public function CreateSubMerchant($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/submerchant/submit?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function GetSubMerchant($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/submerchant/get?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function UpdateUserCard($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/card/membercard/updateuser?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function SendWxCard($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function delShop($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/poi/delpoi?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function isSubscribe($wxAccessToken, $openid)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/user/info?openid=' . $openid . '&access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url);

		if ($result['subscribe'] == 0) {
			return 0;
		}


		return 1;
	}

	public function qrcode($wxAccessToken, $jsonData)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url, $jsonData);
		return $result;
	}

	public function wxgetCallBackip($wxAccessToken)
	{
		$url = 'https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=' . $wxAccessToken;
		$result = $this->wxHttpsRequest($url);
		return $result;
	}

	protected function https_request($url, $data = NULL, $noprocess = false)
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.3; WOW64; rv:39.0) Gecko/20100101 Firefox/39.0');
		$header = array('Accept-Charset: utf-8');
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($curl, CURLOPT_HEADER, false);
		curl_setopt($curl, CURLINFO_HEADER_OUT, true);

		if (!empty($data)) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		}


		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$output = curl_exec($curl);

		if ($noprocess) {
			return $output;
		}


		$errorno = curl_errno($curl);

		if ($errorno) {
			return array('curl' => false, 'errorno' => $errorno);
		}


		$res = json_decode($output, 1);

		if ($res['errcode']) {
			return array('errcode' => $res['errcode'], 'errmsg' => $res['errmsg']);
		}


		return $res;
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
		$errorno = curl_errno($curl);
		curl_close($curl);

		if ($errorno) {
			return array('curl' => false, 'errorno' => $errorno);
		}


		$res = json_decode($output, 1);

		if ($res['errcode']) {
			return array('errcode' => $res['errcode'], 'errmsg' => $res['errmsg']);
		}

                
		return $res;
	}
}


?>
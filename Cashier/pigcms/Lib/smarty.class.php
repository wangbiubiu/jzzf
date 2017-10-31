<?php
$session_storage = getSessionStorageType();
bpBase::loadSysClass($session_storage);
bpBase::loadSysFunc('front');
class smarty_controller
{
	static 	public $smarty;
	public $site_info = array();
	public $SiteUrl;
	public $RlStaticResource;
	public $ResourceUrl = '';

	public function __construct()
	{
		if (smarty_controller::$smarty == '') {
			ini_set('include_path', ABS_PATH . 'vendor' . DIRECTORY_SEPARATOR . 'smarty' . PATH_SEPARATOR . ini_get('include_path'));
			require_once 'Smarty.class.php';
			$smartyInstance = new smarty();
			$smartyInstance->compile_dir = ABS_PATH . 'smarty' . DIRECTORY_SEPARATOR . 'templates_c' . DIRECTORY_SEPARATOR;
			$smartyInstance->config_dir = ABS_PATH . 'smarty' . DIRECTORY_SEPARATOR . 'configs' . DIRECTORY_SEPARATOR;
			$smartyInstance->cache_dir = ABS_PATH . 'smarty' . DIRECTORY_SEPARATOR . 'cache' . DIRECTORY_SEPARATOR;
			$smartyInstance->use_sub_dirs = true;
			smarty_controller::$smarty = $smartyInstance;
		}


		$this->site_info = loadConfig('info');

		if (!empty($this->site_info['SITE_URL'])) {
			$this->SiteUrl = rtrim($this->site_info['SITE_URL'], '/');
		}
		 else {
			$this->SiteUrl = $_SERVER['HTTP_HOST'];
			$this->SiteUrl = strtolower($this->SiteUrl);

			if ((strpos($this->SiteUrl, 'http:') === false) && (strpos($this->SiteUrl, 'https:') === false)) {
				$this->SiteUrl = 'http://' . $this->SiteUrl;
			}


			$this->SiteUrl = rtrim($this->SiteUrl, '/');
		}

		if (!defined('SITEURL')) {
			define('SITEURL', $this->SiteUrl);
		}


		isset($this->site_info['ResourceUrl']) && !empty($this->site_info['ResourceUrl']) && ($this->ResourceUrl = rtrim($this->site_info['ResourceUrl'], '/'));
		$this->RlStaticResource = ((!empty($this->ResourceUrl) ? $this->ResourceUrl . ltrim(PIGCMS_STATIC_PATH, '.') : RL_PIGCMS_STATIC_PATH));

		if (!defined('RlStaticResource')) {
			define('RlStaticResource', $this->RlStaticResource);
		}


		if (!defined('RESOURCEURL')) {
			define('RESOURCEURL', $this->ResourceUrl);
		}


		$this->assign('SiteUrl', $this->SiteUrl);
		$this->assign('tplHome', ABS_PATH . PIGCMS_TPL_PATH . APP_NAME);
		$this->assign('route_Model', ROUTE_MODEL);
		$this->assign('route_Control', ROUTE_CONTROL);
		$this->assign('route_Action', ROUTE_ACTION);
	}

	final static public function display($file = '', $m = '', $c = '')
	{
		$file = ((empty($file) ? ROUTE_ACTION : $file));
		$m = ((empty($m) ? ROUTE_MODEL : $m));
		$c = ((empty($c) ? ROUTE_CONTROL : $c));

		if (empty($m)) {
			return false;
		}


		if (defined('PIGCMS_TPL_PATH')) {
			if (!defined('PIGCMS_TPL_STATIC_PATH')) {
				$tmppath = PIGCMS_TPL_PATH . APP_NAME . '/' . 'Static' . '/';

				if (RESOURCEURL) {
					$PIGCMS_TPL_PATH = ((defined('OPIGCMS_TPL_PATH') ? OPIGCMS_TPL_PATH : PIGCMS_TPL_PATH));
					$tmppath = $PIGCMS_TPL_PATH . APP_NAME . '/' . 'Static' . '/';
					$tmppath = RESOURCEURL . ltrim($tmppath, '.');
				}


				define('PIGCMS_TPL_STATIC_PATH', $tmppath);
				unset($tmppath);
			}


			$tpl = ABS_PATH . PIGCMS_TPL_PATH . APP_NAME . '/' . $m . '/' . $c . '/' . $file . '.tpl.php';
		}
		 else {
			if (!defined('PIGCMS_TPL_STATIC_PATH')) {
				define('PIGCMS_TPL_STATIC_PATH', PIGCMS_CORE_PATH . 'Lib' . '/' . APP_NAME . '/' . $m . '/' . 'templates' . '/' . 'Static' . '/');
			}


			$tpl = ABS_PATH . PIGCMS_CORE_PATH . 'Lib' . '/' . APP_NAME . '/' . $m . '/' . 'templates' . '/' . $file . '.tpl.php';
		}

		return smarty_controller::$smarty->fetch($tpl, $cache_id = NULL, $compile_id = NULL, true);
	}

	public function resultDisplay($tpl = '', $includeMeta = 1)
	{
		return smarty_controller::$smarty->fetch($tpl, $cache_id = NULL, $compile_id = NULL, true);
	}

	public function assign($k, $v = '')
	{
		return smarty_controller::$smarty->assign($k, $v);
	}

	public function fetch($tpl)
	{
		return smarty_controller::$smarty->fetch($tpl);
	}

	public function append($tpl_var, $value = NULL, $merge = false)
	{
		return smarty_controller::$smarty->append($tpl_var, $value = NULL, $merge = false);
	}

	final public function dispatchJump($message, $status = 1, $jumpUrl = '')
	{
		$PIGCMS_TPL_PATH = ((defined('OPIGCMS_TPL_PATH') ? OPIGCMS_TPL_PATH : PIGCMS_TPL_PATH));

		if (isset($_GET['closeWin'])) {
			$jumpUrl = 'javascript:window.close();';
		}
		if ($status) {
			$s_message = $message;

			if (!isset($_GET['waitSecond'])) {
				$waitSecond = 1;
			}


			if (empty($jumpUrl)) {
				$jumpUrl = $_SERVER['HTTP_REFERER'];
			}


			include ABS_PATH . $PIGCMS_TPL_PATH . '/dispatch_jump.php';
		}
		 else {
			$e_message = $message;

			if (!isset($_GET['waitSecond'])) {
				$waitSecond = 3;
			}


			if (empty($jumpUrl)) {
				$jumpUrl = 'javascript:history.back(-1);';
			}


			include ABS_PATH . $PIGCMS_TPL_PATH . '/dispatch_jump.php';
			exit();
		}
	}

	protected function successTip($message, $jumpUrl = '')
	{
		$this->dispatchJump($message, 1, $jumpUrl);
	}

	protected function errorTip($message, $jumpUrl = '')
	{
		$this->dispatchJump($message, 0, $jumpUrl);
	}

	protected function toPassword($password, $salt)
	{
		$password_code = md5(md5($password . '_' . $salt) . $salt);
		return $password_code;
	}

	public function error($tip = '', $url = '', $time = 3)
	{
		$this->assign('tip', $tip);
		$this->assign('url', $url);
		$this->assign('time', $time);
		$this->resultDisplay('wap' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'jump.tpl', 0);
		exit();
	}

	public function success($tip = '', $url = '', $time = 3)
	{
		$this->assign('success', 1);
		$this->assign('tip', $tip);
		$this->assign('url', $url);
		$this->assign('time', $time);
		$this->resultDisplay('wap' . DIRECTORY_SEPARATOR . 'default' . DIRECTORY_SEPARATOR . 'jump.tpl', 0);
		exit();
	}

	final public function curlGet($url)
	{
		$ch = curl_init();
		$header = 'Accept-Charset: utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		return $temp;
	}

	final public function clear_html($array)
	{
		if (!is_array($array)) {
			return trim(htmlspecialchars($array, ENT_QUOTES));
		}


		foreach ($array as $key => $value ) {
			if (is_array($value)) {
				$this->clear_html($value);
			}
			 else {
				$array[$key] = trim(htmlspecialchars($value, ENT_QUOTES));
			}
		}

		return $array;
	}

	final public function decode_html($array, $flage = false)
	{
		if (is_array($array)) {
			foreach ($array as $key => $value ) {
				if (is_array($value)) {
					$array[$key] = $this->decode_html($value, $flage);
				}
				 else {
					if ($flage && stripos($value, 's_#|')) {
						$value = str_replace('is_#|', '', $value);
						$value = base64_decode($value);
					}


					$array[$key] = htmlspecialchars_decode($value, ENT_QUOTES);
				}
			}

			return $array;
		}


		return htmlspecialchars_decode($array, ENT_QUOTES);
	}

	final public function _add($model, $data)
	{
		$data = $this->clear_html($data);
		$r_id = $model->insert($data, 1);
		return $r_id;
	}

	final public function _save($model, $data)
	{
		$info = $model->getPK();
		$data = $this->clear_html($data);
		$condition = array();

		foreach ($data as $key => $val ) {
			if ($key == $info['name']) {
				$condition[$key] = $val;
				unset($data[$key]);
			}

		}

		if (empty($condition)) {
			$return['status'] = 0;
			$return['msg'] = '没有主键字段';
			return $return;
		}


		if ($model->update($data, $condition)) {
			$return['status'] = 1;
			$return['msg'] = '修改成功';
		}
		 else {
			$return['status'] = 0;
			$return['msg'] = '修改失败';
		}

		return $return;
	}

	final public function _delAll($model, $data)
	{
		$pk = $model->getPK();

		if (is_array($data)) {
			$condition = to_sqls($data, '', $pk['name']);
		}
		 else {
			$condition = $pk['name'] . ' in (' . $data . ')';
		}

		if ($model->delete($condition)) {
			$return['status'] = 1;
			$return['msg'] = '删除成功';
		}
		 else {
			$return['status'] = 0;
			$return['msg'] = '删除失败';
		}

		return $return;
	}

	final public function _del($model, $data, $extsql = '')
	{
		$pk = $model->getPK();
		$condition = $pk['name'] . ' = ' . $data;

		if (!empty($extsql)) {
			$condition .= ' AND ' . $extsql;
		}


		if ($model->delete($condition)) {
			$return['status'] = 1;
			$return['msg'] = '删除成功';
		}
		 else {
			$return['status'] = 0;
			$return['msg'] = '删除失败';
		}

		return $return;
	}

	final public function _uplode($ext = '', $size = 0, $saveRule = 'uniqid')
	{
		$uploadConfig = loadConfig('upload');

		if ($ext == '') {
			$ext = uploadExt;
		}


		if ($size == 0) {
			$size = maxUploadSize;
		}


		$uploadType = uploadType;
		$config = array('maxSize' => $size, 'allowExts' => $ext, 'saveRule' => $saveRule);

		if ($uploadType == 'Local') {
			$config['savePath'] = uploadPath;
		}


		bpBase::loadOrg('UploadOauth');
		$upload = new UploadOauth($config);
		$return = $upload->$uploadType($uploadConfig[$uploadType]);
		return $return;
	}

	public function oldUploadFile($filemulu = 'images', $token = '')
	{
		$token = ((!empty($token) ? $token : date('Ymd')));
		bpBase::loadOrg('UploadFile');
		$getupload_dir = '/upload/' . $filemulu . '/' . $token . '/' . date('Ymd') . '/';

		if (defined('ABS_UPLOAD_PATH')) {
			$getupload_dir = ABS_UPLOAD_PATH . $getupload_dir;
		}


		$upload_dir = '.' . $getupload_dir;

		if (!is_dir($upload_dir)) {
			mkdir($upload_dir, 511, true);
		}


		$upload = new UploadFile();
		$upload->maxSize = 10 * 1024 * 1024;
		$upload->allowExts = array('jpeg', 'jpg', 'png', 'mp3', 'gif', 'pem');
		$upload->savePath = $upload_dir;
		$upload->thumb = false;
		$upload->saveRule = 'uniqid';

		if ($upload->upload()) {
			$uploadList = $upload->getUploadFileInfo();
			return array('error' => 0, 'imgurl' => $getupload_dir, 'data' => $uploadList);
		}


		return array('error' => 1, 'imgurl' => $getupload_dir, 'data' => $upload->getErrorMsg());
	}

	public function sendaSms($mobile, $mid = 0, $prefix = '')
	{
		$_SESSION[$prefix . 'phone' . $mobile] = '';
		$string = '0123456789';
		$count = strlen($string) - 1;
		$rand_num = '';
		$i = 0;

		while ($i < 7) {
			$rand_num .= $string[mt_rand(0, $count)];
			++$i;
		}

		$rand_num = str_shuffle($rand_num);
		$_SESSION[$prefix . 'phone' . $mobile] = json_encode(array('randnum' => $rand_num, 'generatetime' => $_SERVER['REQUEST_TIME']));
		bpBase::loadOrg('Sms');
		$return_status = Sms::sendSms($mid, '您的验证码是：' . $rand_num . '。 此验证码10分钟内有效，请不要把验证码泄露给其他人。如非本人操作，可不用理会！', $mobile);

		if (($return_status == 0) && (strlen($return_status) == 1)) {
			$this->dexit(array('error' => 0));
		}
		 else if ($return_status == NULL) {
			$this->dexit(array('error' => 1, 'msg' => '没有购买'));
		}
		 else {
			$this->dexit(array('error' => 1, 'msg' => '短信发送失败,请稍后再试' . $return_status));
		}
	}

	public function _setField($model, $data)
	{
		$info = $model->getPK();
		$data = $this->clear_html($data);
		$condition = array();

		foreach ($data as $key => $val ) {
			if ($key == $info['name']) {
				$condition[$key] = $val;
			}

		}

		if (empty($condition)) {
			if ($this->_add($model, $data)) {
				$return['status'] = 1;
				$return['msg'] = '修改成功';
			}
			 else {
				$return['status'] = 0;
				$return['msg'] = '修改失败';
			}
		}
		 else {
			$return = $this->_save($model, $data);
		}

		return $return;
	}

	final public function dexit($data = '')
	{
		if (is_array($data)) {
			echo json_encode($data);
		}
		 else {
			echo $data;
		}

		exit();
	}

	final public function httpRequest($url, $method, $postfields = NULL, $headers = array(), $debug = false)
	{
		$method = strtoupper($method);
		$ci = curl_init();
		curl_setopt($ci, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
		curl_setopt($ci, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.2; WOW64; rv:34.0) Gecko/20100101 Firefox/34.0');
		curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 60);
		curl_setopt($ci, CURLOPT_TIMEOUT, 7);
		curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

		switch ($method) {
		case 'POST':
			curl_setopt($ci, CURLOPT_POST, true);

			if (!empty($postfields)) {
				$tmpdatastr = ((is_array($postfields) ? http_build_query($postfields) : $postfields));
				curl_setopt($ci, CURLOPT_POSTFIELDS, $tmpdatastr);
			}


			break;

		default:
			curl_setopt($ci, CURLOPT_CUSTOMREQUEST, $method);
			break;
			$ssl = ((preg_match('/^https:\\/\\//i', $url) ? true : false));
			curl_setopt($ci, CURLOPT_URL, $url);

			if ($ssl) {
				curl_setopt($ci, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ci, CURLOPT_SSL_VERIFYHOST, false);
			}


			curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($ci, CURLOPT_MAXREDIRS, 2);
			curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ci, CURLINFO_HEADER_OUT, true);
			$response = curl_exec($ci);
			$requestinfo = curl_getinfo($ci);
			$http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

			if ($debug) {
				echo '=====post data======' . "\r\n";
				var_dump($postfields);
				echo '=====info===== ' . "\r\n";
				print_r($requestinfo);
				echo '=====response=====' . "\r\n";
				print_r($response);
			}


			curl_close($ci);
		}
	}
}


?>
<?php
bpBase::loadSysFunc('front');
class base_controller
{
	public $site_info = array();
	public $SiteUrl;
	public $RlStaticResource;
	public $ResourceUrl = '';

	public function __construct()
	{
	    
		$this->site_info = loadConfig('info');
		
		if (!empty($this->site_info['SITE_URL'])) {
			$this->SiteUrl = rtrim($this->site_info['SITE_URL'], '/');
		}
		 else {
			$this->SiteUrl = $_SERVER['HTTP_HOST'];
			$this->SiteUrl = strtolower($this->SiteUrl);

			if ((strpos($this->SiteUrl, 'http:') === false) && (strpos($this->SiteUrl, 'https:') === false)) {
				$this->SiteUrl = 'https://' . $this->SiteUrl;
			}


			$this->SiteUrl = rtrim($this->SiteUrl, '/');
		}

		if (!defined('SITEURL')) {
			define('SITEURL', $this->SiteUrl);
		}


		isset($this->site_info['ResourceUrl']) && !empty($this->site_info['ResourceUrl']) && ($this->ResourceUrl = rtrim($this->site_info['ResourceUrl'], '/'));
		$this->RlStaticResource = ((!empty($this->ResourceUrl) ? $this->ResourceUrl . ltrim(PIGCMS_STATIC_PATH, '.') : RL_PIGCMS_STATIC_PATH));
		
		if (!defined('RESOURCEURL')) {
			define('RESOURCEURL', $this->ResourceUrl);
		}

	}

	final static public function showTpl($file = '', $m = '', $c = '')
	{
		$file = ((empty($file) ? ROUTE_ACTION : $file));
		$m = ((empty($m) ? ROUTE_MODEL : $m));
		$c = ((empty($c) ? ROUTE_CONTROL : $c));

		if (empty($m)) {
			return false;
		}


		if (defined('PIGCMS_TPL_PATH')) {
			$PIGCMS_TPL_PATH = ((defined('OPIGCMS_TPL_PATH') ? OPIGCMS_TPL_PATH : RL_PIGCMS_TPL_PATH));

			if (!defined('PIGCMS_TPL_STATIC_PATH')) {
				$tmppath = $PIGCMS_TPL_PATH . APP_NAME . '/' . 'Static' . '/';

				if (RESOURCEURL) {
					$PIGCMS_TPL_PATH = ((defined('OPIGCMS_TPL_PATH') ? OPIGCMS_TPL_PATH : PIGCMS_TPL_PATH));
					$tmppath = $PIGCMS_TPL_PATH . APP_NAME . '/' . 'Static' . '/';
					$tmppath = RESOURCEURL . ltrim($tmppath, '.');
				}


				define('PIGCMS_TPL_STATIC_PATH', $tmppath);
				unset($tmppath);
			}


			$tmpPIGCMS_TPL_PATH = ((defined('OPIGCMS_TPL_PATH') ? OPIGCMS_TPL_PATH : PIGCMS_TPL_PATH));
			return ABS_PATH . $tmpPIGCMS_TPL_PATH . APP_NAME . '/' . $m . '/' . $c . '/' . $file . '.tpl.php';
		}


		if (!defined('PIGCMS_TPL_STATIC_PATH')) {
			$tmppath = RL_PIGCMS_CORE_PATH . 'Lib' . '/' . APP_NAME . '/' . $m . '/' . 'templates' . '/' . 'Static' . '/';

			if (RESOURCEURL) {
				$tmppath = RESOURCEURL . ltrim($tmppath, '.');
			}


			define('PIGCMS_TPL_STATIC_PATH', $tmppath);
			unset($tmppath);
		}


		return ABS_PATH . PIGCMS_CORE_PATH . 'Lib' . '/' . APP_NAME . '/' . $m . '/' . 'templates' . '/' . $file . '.tpl.php';
	}

	final public function dispatchJump($message, $status = 1, $jumpUrl = '', $wSecond = 0)
	{
		$PIGCMS_TPL_PATH = ((defined('OPIGCMS_TPL_PATH') ? OPIGCMS_TPL_PATH : PIGCMS_TPL_PATH));

		if (isset($_GET['closeWin'])) {
			$jumpUrl = 'javascript:window.close();';
		}
		if ($status) {
			$s_message = $message;
			$waitSecond = $wSecond;

			if (!0 < $waitSecond) {
				$waitSecond = 2;
			}


			if (empty($jumpUrl)) {
				$jumpUrl = $_SERVER['HTTP_REFERER'];
			}


			include ABS_PATH . $PIGCMS_TPL_PATH . '/dispatch_jump.php';
		}
		 else {
			$e_message = $message;
			$waitSecond = $wSecond;

			if (!0 < $waitSecond) {
				$waitSecond = 3;
			}


			if (empty($jumpUrl)) {
				$jumpUrl = 'javascript:history.back(-1);';
			}


			include ABS_PATH . $PIGCMS_TPL_PATH . '/dispatch_jump.php';
			exit();
		}
	}

	protected function successTip($message, $jumpUrl = '', $waitSecond = 2)
	{
		$this->dispatchJump($message, 1, $jumpUrl, $waitSecond);
	}

	protected function errorTip($message, $jumpUrl = '', $waitSecond = 3)
	{
		$this->dispatchJump($message, 0, $jumpUrl, $waitSecond);
	}

	protected function toPassword($password, $salt)
	{
		$password_code = md5(md5($password . '_' . $salt) . $salt);
		return $password_code;
	}

	final public function authority($info)
	{
		$data = strtolower(APP_NAME . '/' . ROUTE_MODEL . '/' . ROUTE_CONTROL . '/' . ROUTE_ACTION);
		$allowAuthority = explode(',', strtolower($info));
		$status = false;

		foreach ($allowAuthority as $key => $val ) {
			$num = $this->comparison($val, $data);

			if (3 < $num) {
				$status = true;
			}

		}

		if ($status == false) {
			return false;
		}


		return true;
	}

	final public function comparison($info, $data)
	{
		$info = explode('/', $info);
		$data = explode('/', $data);
		$num = 0;

		foreach ($info as $key => $val ) {
			if (1 < count(explode('|', $val))) {
				foreach (explode('|', $val) as $ke => $va ) {
					if (in_array($va, $data)) {
						$num += 1;
					}

				}
			}
			 else if (in_array($val, $data)) {
				$num += 1;
			}

		}

		return $num;
	}

	final public function curlGet($url)
	{
		$ch = curl_init();
		$header = 'Accept-Charset: utf-8';
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
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
			mkdir($upload_dir, 777, true);
		}

               
		$upload = new UploadFile();
		$upload->maxSize = 30 * 1024 * 1024;
		$upload->allowExts = array('jpeg', 'jpg', 'png', 'mp3', 'gif', 'pem');
		$upload->savePath = $upload_dir;
		$upload->thumb = false;
		$upload->saveRule = 'uniqid';

		if ($upload->upload()) {
			$uploadList = $upload->getUploadFileInfo();
                        //dump($uploadList);exit;
			return array('error' => 0, 'imgurl' => $getupload_dir, 'data' => $uploadList);
		}


		return array('error' => 1, 'imgurl' => $getupload_dir, 'data' => $upload->getErrorMsg());
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

	protected function getEmployeeByid($eid = 0, $mid = 0)
	{
		$cashier_employeeDb = M('cashier_employee');
		$tmpEmployee = array();

		if ((0 < $eid) && (0 < $mid)) {
			$whereArr = array('eid' => $eid, 'mid' => $mid);
			$tmpEmployee = $cashier_employeeDb->get_one($whereArr, 'eid,mid,username,account,storeid,phone,thirdstoreid');
		}


		return $tmpEmployee;
	}

	protected function getAllEmployee($mid = 0, $idsArr = false, $storeid = false)
	{
		$cashier_employeeDb = M('cashier_employee');
		$tmpEmployee = array();

		if (0 < $mid) {
			$whereStr = 'mid=' . $mid;

			if (!empty($idsArr) && is_array($idsArr)) {
				$whereStr .= ' AND eid in(' . implode(',', $idsArr) . ')';
			}
			 else if (0 < $storeid) {
				$whereStr .= ' AND storeid =' . $storeid;
			}


			$tmpEmployee = $cashier_employeeDb->select($whereStr, 'eid,mid,username,account,storeid,phone', '', '');

			if (!empty($tmpEmployee)) {
				$EmployeeArr = array();

				foreach ($tmpEmployee as $evv ) {
					$EmployeeArr[$evv['eid']] = $evv;
				}

				$tmpEmployee = $EmployeeArr;
				unset($EmployeeArr);
			}

		}


		return $tmpEmployee;
	}

	protected function getAllStore($mid = 0, $idsArr = false)
	{
		$cashier_storesDb = M('cashier_stores');
		$tmpStores = array();

		if (0 < $mid) {
			$whereStr = 'mid=' . $mid;

			if (!empty($idsArr) && is_array($idsArr)) {
				$whereStr .= ' AND id in(' . implode(',', $idsArr) . ')';
			}


			$tmpStores = $cashier_storesDb->select($whereStr, 'id,mid,poi_id,business_name,branch_name,telephone', '', '');

			if (!empty($tmpStores)) {
				$StoreArr = array();

				foreach ($tmpStores as $svv ) {
					$StoreArr[$svv['id']] = $svv;
				}

				$tmpStores = $StoreArr;
				unset($StoreArr);
			}

		}


		return $tmpStores;
	}

	protected function getStoreByid($storeid = 0, $mid = 0)
	{
		$cashier_storesDb = M('cashier_stores');
		$tmpStores = array();

		if ((0 < $storeid) && (0 < $mid)) {
			$whereArr = array('id' => $storeid, 'mid' => $mid);
			$tmpStores = $cashier_storesDb->get_one($whereArr, 'id,mid,poi_id,business_name,branch_name,available_state');
		}


		return $tmpStores;
	}

	protected function getMerBymid($mid = 0)
	{
		$tmpMer = array();

		if (0 < $mid) {
			$tmpMer = M('cashier_merchants')->get_one(array('mid' => $mid), 'mid,username,thirduserid,wxname,weixin,source,status,thirdmid');
		}


		return $tmpMer;
	}

	protected function ProcssOdata($odata = array(), $mid)
	{
		$storeArr = $empArr = array();

		if (!empty($odata)) {
			$storeidArr = $eidArr = array();

			foreach ($odata as $okk => $ovv ) {
				if (0 < $ovv['storeid']) {
					$storeidArr[] = $ovv['storeid'];
				}


				if (0 < $ovv['eid']) {
					$eidArr[] = $ovv['eid'];
				}


				$odata[$okk]['storename'] = '无';
				$odata[$okk]['optername'] = '商家自己';
			}

			if (!empty($storeidArr)) {
				$storeidArr = array_unique($storeidArr);
				$storeArr = $this->getAllStore($mid, $storeidArr);

				if (!is_array($storeArr)) {
					$storeArr = array();
				}

			}


			if (!empty($eidArr)) {
				$eidArr = array_unique($eidArr);
				$empArr = $this->getAllEmployee($mid, $eidArr);

				if (!is_array($empArr)) {
					$empArr = array();
				}

			}


			foreach ($odata as $okk => $ovv ) {
				if (!empty($storeArr) && isset($storeArr[$ovv['storeid']])) {
					$odata[$okk]['storename'] = $storeArr[$ovv['storeid']]['business_name'] . $storeArr[$ovv['storeid']]['branch_name'];
				}


				if (!empty($empArr) && isset($empArr[$ovv['eid']])) {
					$odata[$okk]['optername'] = $empArr[$ovv['eid']]['username'];
				}

			}
		}


		return $odata;
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

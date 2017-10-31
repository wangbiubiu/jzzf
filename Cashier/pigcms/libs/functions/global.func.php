<?php




if (!function_exists('iconv')) {
function iconv($in_charset, $out_charset, $str)
{
	$in_charset = strtoupper($in_charset);
	$out_charset = strtoupper($out_charset);

	if (function_exists('mb_convert_encoding')) {
		return mb_convert_encoding($str, $out_charset, $in_charset);
	}


	bpBase::loadSysFunc('iconv');
	$in_charset = strtoupper($in_charset);
	$out_charset = strtoupper($out_charset);

	if (($in_charset == 'UTF-8') && (($out_charset == 'GBK') || ($out_charset == 'GB2312'))) {
		return utf8_to_gbk($str);
	}


	if ((($in_charset == 'GBK') || ($in_charset == 'GB2312')) && ($out_charset == 'UTF-8')) {
		return gbk_to_utf8($str);
	}


	return $str;
}
}




if (!function_exists('randStr')) {
function randStr($randLength, $hasnum = false)
{
	$randLength = intval($randLength);
	$chars = 'ABCDEFGHJKLMNPQRTUVWXYZabcdefghjkmnpqrstuvwxyz';

	if ($hasnum) {
		$chars = $chars . '0123456789A';
	}


	$len = strlen($chars);
	$randStr = '';
	$i = 0;

	while ($i < $randLength) {
		$randStr .= $chars[rand(0, $len - 1)];
		++$i;
	}

	return $randStr;
}
}

class runtime
{
	public $StartTime = 0;
	public $StopTime = 0;

	public function get_microtime()
	{
		list($usec, $sec) = explode(' ', microtime());
		return (double) $usec + (double) $sec;
	}

	public function start()
	{
		$this->StartTime = $this->get_microtime();
	}

	public function stop()
	{
		$this->StopTime = $this->get_microtime();
	}

	public function spent()
	{
		return round(($this->StopTime - $this->StartTime) * 1000, 1);
	}
}


function isMobile($p)
{
	if (preg_match('/^1[0-9]{2}[0-9]{8}$/', $p)) {
		return true;
	}


	return false;
}


function isQQ($qq)
{
	if (preg_match('/^[1-9][0-9]{4,20}$/', $qq)) {
		return true;
	}


	return false;
}

function isIP($ip)
{
	if (preg_match('/^(([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5]).){3}([1-9]?[0-9]|1[0-9]{2}|2[0-4][0-9]|25[0-5])$/', $ip)) {
		return true;
	}


	return false;
}

function isDomain($domain)
{
	if (preg_match('/^[a-z0-9.\\-]{1,50}$/', trim($domain))) {
		return true;
	}


	return false;
}




function isAjax()
{
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		if ('xmlhttprequest' == strtolower($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return true;
		}

	}


	return false;
}

function convertToMobile($str)
{
	$str = str_replace(array('width="', 'height="', '<a', '</a>', '.jpg" style="'), array('owidth="', '"', '<span', '</span>', '.jpg" ostyle="'), $str);
	return $str;
}

function toCacheClearUrl($parms)
{
	if ($parms) {
		$parmStr = '?';
		$comma = '';

		foreach ($parms as $k => $v ) {
			$parmStr .= $comma . $k . '=' . $v;
			$comma = '&';
		}
	}


	header('Location:cachesAction.php' . $parmStr);
}

function format_bracket($text)
{
	$text = str_replace('<', '&lt;', $text);
	$text = str_replace('>', '&gt;', $text);
	return $text;
}

function add_special_char(&$value)
{
	if (('*' == $value) || (false !== strpos($value, '(')) || (false !== strpos($value, '.')) || (false !== strpos($value, '`'))) {
	}
	 else {
		$value = '`' . trim($value) . '`';
	}

	return $value;
}

function escape_string(&$value, $key = '', $quotation = 1)
{
	if ($quotation) {
		$q = '\'';
	}
	 else {
		$q = '';
	}

	$value = $q . $value . $q;
	return $value;
}

function uploadPhotoErrors()
{
	return array(-1 => '你上传的不是图片', -2 => '文件不能超过2M', -3 => '图片地址不正确');
}

function escape($str)
{
	preg_match_all('/[' . "\x80" . '-' . "\xff" . '].|[' . "\x1" . '-]+/', $str, $r);
	$ar = $r[0];

	foreach ($ar as $k => $v ) {
		if (ord($v[0]) < 128) {
			$ar[$k] = rawurlencode($v);
		}
		 else {
			$ar[$k] = '%u' . bin2hex(iconv('GB2312', 'UCS-2', $v));
		}
	}

	return join('', $ar);
}

function loadExtension($functionName, $parms = '')
{
	$extensionClassName = 'extension_' . SUB_SKIN;
	$extension = bpBase::loadAppClass($extensionClassName, ROUTE_MODEL);

	if ($extension) {
		$extension->$functionName($parms);
	}
	 else {
		return false;
	}
}

function isMp($mobile)
{
	return preg_match('/^13[0-9]{9}$|^15[0-9]{9}$|^18[0-9]{9}$/', $mobile);
}

function clearHtmlTagA(&$body, $allow_urls = array())
{
	$host_rule = join('|', $allow_urls);
	$host_rule = preg_replace('#[' . "\n\r" . ']#', '', $host_rule);
	$host_rule = str_replace('.', '\\.', $host_rule);
	$host_rule = str_replace('/', '\\/', $host_rule);
	$arr = '';
	preg_match_all('#<a([^>]*)>(.*)<\\/a>#iU', $body, $arr);

	if (is_array($arr[0])) {
		$rparr = array();
		$tgarr = array();

		foreach ($arr[0] as $i => $v ) {
			if (($host_rule != '') && preg_match('#' . $host_rule . '#i', $arr[1][$i])) {
				continue;
			}


			$rparr[] = $v;
			$tgarr[] = $arr[2][$i];
		}

		if (!empty($rparr)) {
			$body = str_replace($rparr, $tgarr, $body);
		}

	}


	$arr = $rparr = $tgarr = '';
	return $body;
}

function createUploadFolders($time, $sitedir = '')
{
	$year = date('Y', $time);
	$month = date('m', $time);
	$day = date('d', $time);

	if (!strlen($sitedir)) {
		$siteAbsPath = ABS_PATH;
	}
	 else {
		$siteAbsPath = ABS_PATH . $sitedir;

		if (!file_exists($siteAbsPath) && !is_dir($siteAbsPath)) {
			mkdir($siteAbsPath, 511);
		}

	}

	$yearFolder = $siteAbsPath . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $year;
	$monthFolder = $siteAbsPath . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month;
	$dayFolder = $siteAbsPath . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $year . DIRECTORY_SEPARATOR . $month . DIRECTORY_SEPARATOR . $day;

	if (!file_exists($siteAbsPath . DIRECTORY_SEPARATOR . 'upload') && !is_dir($siteAbsPath . DIRECTORY_SEPARATOR . 'upload')) {
		mkdir($siteAbsPath . DIRECTORY_SEPARATOR . 'upload', 511);
	}


	if (!file_exists($siteAbsPath . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images') && !is_dir($siteAbsPath . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images')) {
		mkdir($siteAbsPath . DIRECTORY_SEPARATOR . 'upload' . DIRECTORY_SEPARATOR . 'images', 511);
	}


	if (!file_exists($yearFolder) && !is_dir($yearFolder)) {
		mkdir($yearFolder, 511);
	}


	if (!file_exists($monthFolder) && !is_dir($monthFolder)) {
		mkdir($monthFolder, 511);
	}


	if (!file_exists($dayFolder) && !is_dir($dayFolder)) {
		mkdir($dayFolder, 511);
	}


	return $dayFolder;
}

function L($language = 'no_language', $pars = array(), $modules = '')
{
	static $LANG = array();
	static $LANG_MODULES = array();
	static $lang = 'zh-cn';

	if (!$LANG) {
		require_once ABS_PATH . MANAGE_DIR . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . 'system.lang.php';

		if (file_exists(ABS_PATH . MANAGE_DIR . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . ROUTE_M . '.lang.php')) {
			require ABS_PATH . MANAGE_DIR . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . ROUTE_M . '.lang.php';
		}

	}


	if (!empty($modules)) {
		$modules = explode(',', $modules);

		foreach ($modules as $m ) {
			if (!isset($LANG_MODULES[$m])) {
				require ABS_PATH . MANAGE_DIR . DIRECTORY_SEPARATOR . 'languages' . DIRECTORY_SEPARATOR . $lang . DIRECTORY_SEPARATOR . $m . '.lang.php';
			}

		}
	}


	if (!array_key_exists($language, $LANG)) {
		return $language;
	}


	$language = $LANG[$language];

	if ($pars) {
		foreach ($pars as $_k => $_v ) {
			$language = str_replace('{' . $_k . '}', $_v, $language);
		}
	}


	return $language;
}

function array2Objects($array)
{
	$objs = array();

	if ($array) {
		$i = 0;

		foreach ($array as $a ) {
			foreach ($a as $k => $v ) {
				$objs[$i]->$k = $v;
			}

			++$i;
		}
	}


	return $objs;
}

function bpAddslashes($string, $type = '')
{
	if (!is_array($string)) {
		if ($type == 'get') {
			$string = str_replace(array('\'', '"', '<', '>', '(', ')', '?'), '', $string);
		}


		return htmlspecialchars(addslashes($string));
	}


	foreach ($string as $key => $val ) {
		$string[$key] = bpAddslashes($val, $type);
	}

	return $string;
}

function bpStripslashes($string)
{
	if (!is_array($string)) {
		return stripslashes($string);
	}


	foreach ($string as $key => $val ) {
		$string[$key] = bpStripslashes($val);
	}

	return $string;
}

function toPassword($pw, $salt)
{
	$password = md5($pw);
	$password = md5($password . $salt);
	return $password;
}

function bpHtmlSpecialChars($string)
{
	if (!is_array($string)) {
		return htmlspecialchars($string, ENT_COMPAT, 'GB2312');
	}


	foreach ($string as $key => $val ) {
		$string[$key] = bpHtmlSpecialChars($val);
	}

	return $string;
}

function bpSafeReplace($string)
{
	$string = str_replace('%20', '', $string);
	$string = str_replace('%27', '', $string);
	$string = str_replace('%2527', '', $string);
	$string = str_replace('*', '', $string);
	$string = str_replace('"', '&quot;', $string);
	$string = str_replace('\'', '', $string);
	$string = str_replace('"', '', $string);
	$string = str_replace(';', '', $string);
	$string = str_replace('<', '&lt;', $string);
	$string = str_replace('>', '&gt;', $string);
	$string = str_replace('{', '', $string);
	$string = str_replace('}', '', $string);
	$string = str_replace('\\', '', $string);
	return $string;
}

function formatTextarea($string)
{
	$string = nl2br(str_replace(' ', '&nbsp;', $string));
	return $string;
}

function formatJs($string, $isjs = 1)
{
	$string = addslashes(str_replace(array("\r", "\n", "\t"), array('', '', ''), $string));
	return ($isjs ? 'document.write("' . $string . '");' : $string);
}

function ip()
{
	if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
		$ip = getenv('HTTP_CLIENT_IP');
	}
	 else {
		if (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		}
		 else {
			if (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
				$ip = getenv('REMOTE_ADDR');
			}
			 else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
				$ip = $_SERVER['REMOTE_ADDR'];
			}

		}
	}

	$ip = ((preg_match('/[\\d\\.]{7,15}/', $ip, $matches) ? $matches[0] : ''));

	if (strExists($ip, '192.168.')) {
		$ip = get_real_ip();
	}


	return $ip;
}

function get_real_ip()
{
	$ip = false;

	if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}


	if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ips = explode(', ', $_SERVER['HTTP_X_FORWARDED_FOR']);

		if ($ip) {
			array_unshift($ips, $ip);
			$ip = false;
		}


		$i = 0;

		while ($i < count($ips)) {
			if (!eregi('^(10|172\\.16|192\\.168)\\.', $ips[$i])) {
				$ip = $ips[$i];
				break;
			}


			++$i;
		}
	}
	return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

function getCostTime()
{
	$microtime = microtime(true);
	return $microtime - SYS_START_TIME;
}

function executeTime()
{
	$stime = explode(' ', SYS_START_TIME);
	$etime = explode(' ', microtime());
	return number_format(($etime[1] + $etime[0]) - $stime[1] - $stime[0], 6);
}

function strExists($haystack, $needle)
{
	return !strpos($haystack, $needle) === false;
}

function fileExt($filename)
{
	return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
}

function isEmail($email)
{
	return (6 < strlen($email)) && preg_match('/^[\\w\\-\\.]+@[\\w\\-\\.]+(\\.\\w+)+$/', $email);
}

function isIe()
{
	$useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
	if ((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false)) {
		return false;
	}


	if (strpos($useragent, 'msie ') !== false) {
		return true;
	}


	return false;
}

function createRandomstr($lenth = 6)
{
	$str = '123456789abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ';
	$return = '';
	$i = 1;

	while ($i <= 6) {
		$num = mt_rand(0, 58);
		$return .= $str[$num];
		++$i;
	}

	return $return;
}

function getmicrotime()
{
	list($usec, $sec) = explode(' ', microtime());
	return (double) $usec + (double) $sec;
}

function bpFileGetContents($url, $timeout = 30)
{
	$stream = stream_context_create(array(
	'http' => array('timeout' => $timeout)
	));
	return @file_get_contents($url, 0, $stream);
}

function to_sqls($data, $front = ' AND ', $in_column = false)
{
	if ($in_column && is_array($data)) {
		$ids = '\'' . implode('\',\'', $data) . '\'';
		$sql = $in_column . ' IN (' . $ids . ')';
		return $sql;
	}


	if ($front == '') {
		$front = ' AND ';
	}


	if (is_array($data) && (0 < count($data))) {
		$sql = '';

		foreach ($data as $key => $val ) {
			$sql .= (($sql ? ' ' . $front . ' `' . $key . '` = \'' . $val . '\' ' : ' `' . $key . '` = \'' . $val . '\' '));
		}

		return $sql;
	}


	return $data;
}

function loadConfig($file, $key = '', $default = '', $reload = false)
{
    
	static $configs = array();

	if (!$reload && isset($configs[$file])) {
		if (empty($key)) {
			return $configs[$file];
		}


		if (isset($configs[$file][$key])) {
			return $configs[$file][$key];
		}


		return $default;
	}


	$path = ABS_PATH . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $file . '.config.php';
        
	if (file_exists($path)) {
		$configs[$file] = include $path;
	}


	if (empty($key)) {
		return $configs[$file];
	}


	if (isset($configs[$file][$key])) {
		return $configs[$file][$key];
	}


	return $default;
}

function to_safe($string)
{
	$string = trim($string);
	$string = str_replace(chr(10), '', $string);
	$string = str_replace(chr(13), '', $string);
	return $string;
}

function validEmail($email)
{
	$regex = '/^[\\w-]+(?:\\.[\\w-]+)*@(?:[\\w-]+\\.)+[a-zA-Z]{2,7}$/i';

	if (!preg_match($regex, $email)) {
		return false;
	}


	return true;
}

function format_to_html($text)
{
	$text = str_replace('t', '\\n', $text);
	$text = str_replace('\\r', '', $text);
	$text = str_replace('\\t', '', $text);
	$text = str_replace('\\0', '', $text);
	$text = str_replace('\\x0B', '', $text);
	$text = str_replace(' ', '&nbsp;', $text);
	return $text;
}

function getFirstSecondOfTheDay($timeStamp)
{
	$timeStamp = intval($timeStamp);
	$month = date('m', $timeStamp);
	$day = date('d', $timeStamp);
	$year = date('Y', $timeStamp);
	return mktime(0, 0, 0, $month, $day, $year);
}

function remove_html_tag($str)
{
	$str = trim($str);
	$str = @preg_replace('/<script[^>]*?>(.*?)<\\/script>/si', '', $str);
	$str = @preg_replace('/<style[^>]*?>(.*?)<\\/style>/si', '', $str);
	$str = @strip_tags($str, '');
	$str = @ereg_replace("\t", '', $str);
	$str = @ereg_replace("\r\n", '', $str);
	$str = @ereg_replace("\r", '', $str);
	$str = @ereg_replace("\n", '', $str);
	$str = @ereg_replace(' ', '', $str);
	$str = @ereg_replace('&nbsp;', '', $str);
	return trim($str);
}

function remove_h_tag($text)
{
	$p[0] = '/(<\\/h([0-9]+)>)/i';
	$p[1] = '/(<h([0-9]+)>)/i';
	$r[0] = '';
	$r[1] = '';
	$text = preg_replace($p, $r, $text);
	return $text;
}

function deldir($dir)
{
	$dh = opendir($dir);

	while ($file = readdir($dh)) {
		if (($file != '.') && ($file != '..')) {
			$fullpath = $dir . '/' . $file;

			if (!is_dir($fullpath)) {
				unlink($fullpath);
			}
			 else {
				deldir($fullpath);
			}
		}

	}

	closedir($dh);

	if (rmdir($dir)) {
		return true;
	}


	return false;
}

function array2sort($a, $sort, $d = '')
{
	$num = count($a);

	if (!$d) {
		$i = 0;

		while ($i < $num) {
			$j = 0;

			while ($j < ($num - 1)) {
				if ($a[$j + 1][$sort] < $a[$j][$sort]) {
					foreach ($a[$j] as $key => $temp ) {
						$t = $a[$j + 1][$key];
						$a[$j + 1][$key] = $a[$j][$key];
						$a[$j][$key] = $t;
					}
				}


				++$j;
			}

			++$i;
		}
	}
	 else {
		$i = 0;

		while ($i < $num) {
			$j = 0;

			while ($j < ($num - 1)) {
				if ($a[$j][$sort] < $a[$j + 1][$sort]) {
					foreach ($a[$j] as $key => $temp ) {
						$t = $a[$j + 1][$key];
						$a[$j + 1][$key] = $a[$j][$key];
						$a[$j][$key] = $t;
					}
				}


				++$j;
			}

			++$i;
		}
	}

	return $a;
}

function sortObjects($a, $keyName, $d = '')
{
	$num = count($a);

	if (!$d) {
		$i = 0;

		while ($i < $num) {
			$j = 0;

			while ($j < ($num - 1)) {
				if ($a[$j + 1]->$keyName < $a[$j]->$keyName) {
					$t = $a[$j + 1];
					$a[$j + 1] = $a[$j];
					$a[$j] = $t;
				}


				++$j;
			}

			++$i;
		}
	}
	 else {
		$i = 0;

		while ($i < $num) {
			$j = 0;

			while ($j < ($num - 1)) {
				if ($a[$j]->$keyName < $a[$j + 1]->$keyName) {
					$t = $a[$j + 1];
					$a[$j + 1] = $a[$j];
					$a[$j] = $t;
				}


				++$j;
			}

			++$i;
		}
	}

	return $a;
}

function sort2DArray($ArrayData, $KeyName1, $SortOrder1 = 'SORT_ASC', $SortType1 = 'SORT_REGULAR')
{
	if (!is_array($ArrayData)) {
		return $ArrayData;
	}


	$ArgCount = func_num_args();
	$I = 1;

	while ($I < $ArgCount) {
		$Arg = func_get_arg($I);

		if (!@eregi('SORT', $Arg)) {
			$KeyNameList[] = $Arg;
			$SortRule[] = '$' . $Arg;
		}
		 else {
			$SortRule[] = $Arg;
		}

		++$I;
	}

	foreach ($ArrayData as $Key => $Info ) {
		foreach ($KeyNameList as $KeyName ) {
			$$KeyName[$Key] = $Info[$KeyName];
		}
	}

	$EvalString = 'array_multisort(' . join(',', $SortRule) . ',$ArrayData);';
	eval($EvalString);
	return $ArrayData;
}

function createFolderByPath($path)
{
	$folders = explode(DIRECTORY_SEPARATOR, $path);
	$foldersCount = count($folders);
	$relatePath = ABS_PATH;
	$i = 1;

	while ($i < $foldersCount) {
		$relatePath .= DIRECTORY_SEPARATOR . $folders[$i];

		if (!file_exists($relatePath) && !is_dir($relatePath)) {
			mkdir($relatePath, 511);
		}


		++$i;
	}
}

function getPageCount($total, $pageSize)
{
	if ($pageSize) {
		return intval($total / $pageSize) + 1;
	}


	return 1;
}

function httpCopy($url, $file = '', $timeout = 15)
{
	$getMethod = loadconfig('system', 'fileGetMethod');
	$getMethod = (($getMethod ? $getMethod : 'file_get_contents'));
	$file = ((empty($file) ? pathinfo($url, PATHINFO_BASENAME) : $file));
	$dir = pathinfo($file, PATHINFO_DIRNAME);
	!is_dir($dir) && @mkdir($dir, 493, true);
	$url = str_replace(' ', '%20', $url);

	if (($getMethod == 'curl') && function_exists('curl_init') && !is_null(curl_init())) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_REFERER, $url);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$temp = curl_exec($ch);
		if (@file_put_contents($file, $temp) && !curl_error($ch)) {
			return $file;
		}


		return false;
	}


	if ($getMethod == 'file_get_contents') {
		$urlInfo = parse_url($url);
		$option = array(
			'http' => array('header' => 'referer:' . $urlInfo['scheme'] . '://' . $urlInfo['host'])
			);
		$context = stream_context_create($option);
		$get_file = file_get_contents($url, false, $context);
		$fp = @fopen($file, 'w');
		@fwrite($fp, $get_file);
		fclose($fp);
	}
	 else {
		getImg($url, $file);
	}
}

function getImg($url = '', $filename = '')
{
	if (is_dir(basename($filename))) {
		echo 'The Dir was not exits';
		return false;
	}


	$url = preg_replace('/(?:^[\'"]+|[\'"\\/]+$)/', '', $url);

	if (!extension_loaded('sockets')) {
		return false;
	}


	preg_match('/http:\\/\\/([^\\/\\:]+(\\:\\d{1,5})?)(.*)/i', $url, $matches);

	if (!$matches) {
		return false;
	}


	$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if (!@socket_connect($sock, $matches[1], ($matches[2] ? substr($matches[2], 1) : 80))) {
		return false;
	}


	$msg = 'GET ' . $matches[3] . ' HTTP/1.1' . "\r\n";
	$msg .= 'Host: ' . $matches[1] . "\r\n";
	$msg .= 'Connection: Close' . "\r\n\r\n";
	socket_write($sock, $msg);
	$bin = '';

	while ($tmp = socket_read($sock, 10)) {
		$bin .= $tmp;
		$tmp = '';
	}

	$bin = explode("\r\n\r\n", $bin);
	$img = $bin[1];
	$h = fopen($filename, 'wb');
	$res = ((fwrite($h, $img) === false ? false : true));
	@socket_close($sock);
	return $res;
}

function upFileFolders($time, $type = 'images', $sitedir = '')
{
	$year = date('Y', $time);
	$month = date('m', $time);
	$day = date('d', $time);

	if (!strlen($sitedir)) {
		$siteAbsPath = ABS_PATH;
	}
	 else {
		$siteAbsPath = ABS_PATH . $sitedir . DIRECTORY_SEPARATOR;

		if (!file_exists($siteAbsPath) && !is_dir($siteAbsPath)) {
			mkdir($siteAbsPath, 511);
		}

	}

	$yearFolder = $siteAbsPath . 'upload' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $year;
	$monthFolder = $yearFolder . DIRECTORY_SEPARATOR . $month;
	$dayFolder = $monthFolder . DIRECTORY_SEPARATOR . $day;

	if (!file_exists($siteAbsPath . 'upload') && !is_dir($siteAbsPath . 'upload')) {
		mkdir($siteAbsPath . 'upload', 511);
	}


	if (!file_exists($siteAbsPath . 'upload' . DIRECTORY_SEPARATOR . $type) && !is_dir($siteAbsPath . 'upload' . DIRECTORY_SEPARATOR . $type)) {
		mkdir($siteAbsPath . 'upload' . DIRECTORY_SEPARATOR . $type, 511);
	}


	if (!file_exists($yearFolder) && !is_dir($yearFolder)) {
		mkdir($yearFolder, 511);
	}


	if (!file_exists($monthFolder) && !is_dir($monthFolder)) {
		mkdir($monthFolder, 511);
	}


	if (!file_exists($dayFolder) && !is_dir($dayFolder)) {
		mkdir($dayFolder, 511);
	}


	return array('path' => $dayFolder . DIRECTORY_SEPARATOR, 'url' => '/upload/' . $type . '/' . $year . '/' . $month . '/' . $day . '/');
}

function getSessionStorageType()
{
	$loadSessionStorageType = loadconfig('system', 'session_storage');
	$sessionStorageType = $loadSessionStorageType;
	$session_storage = 'session_' . $sessionStorageType;
	return $session_storage;
}

function getTimeStamp($date, $last = 0)
{
	$dates = explode('-', $date);

	if ($last) {
		return mktime(23, 59, 59, intval($dates[1]), intval($dates[2]), intval($dates[0]));
	}


	return mktime(0, 0, 0, intval($dates[1]), intval($dates[2]), intval($dates[0]));
}

function getBrowser($Agent)
{
	$browseragent = '';
	$browserversion = '';

	if (@ereg('MSIE ([0-9].[0-9]{1,2})', $Agent, $version)) {
		$browserversion = $version[1];
		$browseragent = 'Internet Explorer';
	}
	 else if (@ereg('Opera/([0-9]{1,2}.[0-9]{1,2})', $Agent, $version)) {
		$browserversion = $version[1];
		$browseragent = 'Opera';
	}
	 else if (@ereg('Firefox/([0-9.]{1,5})', $Agent, $version)) {
		$browserversion = $version[1];
		$browseragent = 'Firefox';
	}
	 else if (@ereg('Chrome/([0-9.]{1,3})', $Agent, $version)) {
		$browserversion = $version[1];
		$browseragent = 'Chrome';
	}
	 else if (@ereg('Safari/([0-9.]{1,3})', $Agent, $version)) {
		$browseragent = 'Safari';
		$browserversion = '';
	}
	 else {
		$browserversion = '';
		$browseragent = 'Unknown';
	}

	return $browseragent . ' ' . $browserversion;
}

function getPlatform($Agent)
{
	$browserplatform = '';
	if (@eregi('win', $Agent) && strpos($Agent, '95')) {
		$browserplatform = 'Windows 95';
	}
	 else {
		if (@eregi('win 9x', $Agent) && strpos($Agent, '4.90')) {
			$browserplatform = 'Windows ME';
		}
		 else {
			if (@eregi('win', $Agent) && @ereg('98', $Agent)) {
				$browserplatform = 'Windows 98';
			}
			 else {
				if (@eregi('win', $Agent) && @eregi('nt 5.0', $Agent)) {
					$browserplatform = 'Windows 2000';
				}
				 else {
					if (@eregi('win', $Agent) && @eregi('nt 5.1', $Agent)) {
						$browserplatform = 'Windows XP';
					}
					 else {
						if (@eregi('win', $Agent) && @eregi('nt 6.0', $Agent)) {
							$browserplatform = 'Windows Vista';
						}
						 else {
							if (@eregi('win', $Agent) && @eregi('nt 6.1', $Agent)) {
								$browserplatform = 'Windows 7';
							}
							 else {
								if (@eregi('win', $Agent) && @ereg('32', $Agent)) {
									$browserplatform = 'Windows 32';
								}
								 else {
									if (@eregi('win', $Agent) && @eregi('nt', $Agent)) {
										$browserplatform = 'Windows NT';
									}
									 else if (@eregi('Mac OS', $Agent)) {
										$browserplatform = 'Mac OS';
									}
									 else if (@eregi('linux', $Agent)) {
										$browserplatform = 'Linux';
									}
									 else if (@eregi('unix', $Agent)) {
										$browserplatform = 'Unix';
									}
									 else {
										if (@eregi('sun', $Agent) && @eregi('os', $Agent)) {
											$browserplatform = 'SunOS';
										}
										 else {
											if (@eregi('ibm', $Agent) && @eregi('os', $Agent)) {
												$browserplatform = 'IBM OS/2';
											}
											 else {
												if (@eregi('Mac', $Agent) && @eregi('PC', $Agent)) {
													$browserplatform = 'Macintosh';
												}
												 else if (@eregi('PowerPC', $Agent)) {
													$browserplatform = 'PowerPC';
												}
												 else if (@eregi('AIX', $Agent)) {
													$browserplatform = 'AIX';
												}
												 else if (@eregi('HPUX', $Agent)) {
													$browserplatform = 'HPUX';
												}
												 else if (@eregi('NetBSD', $Agent)) {
													$browserplatform = 'NetBSD';
												}
												 else if (@eregi('BSD', $Agent)) {
													$browserplatform = 'BSD';
												}
												 else if (@ereg('OSF1', $Agent)) {
													$browserplatform = 'OSF1';
												}
												 else if (@ereg('IRIX', $Agent)) {
													$browserplatform = 'IRIX';
												}
												 else if (@eregi('FreeBSD', $Agent)) {
													$browserplatform = 'FreeBSD';
												}

											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}

	if ($browserplatform == '') {
		$browserplatform = 'Unknown';
	}


	return $browserplatform;
}

function setCache($name, $data, $filepath = '', $timeout = 0)
{
	bpBase::loadSysClass('cache_factory', '', 0);
	$cacheconfig = loadconfig('cache');
	$cache = cache_factory::get_instance($cacheconfig)->load($cacheconfig['type']);
	return $cache->set($name, $data, $timeout, '', $filepath);
}

function setZendCache($data, $name, $filepath = '', $timeout = 0)
{
	bpBase::loadSysClass('cache_factory', '', 0);
	$cacheconfig = loadconfig('cache');
	$cache = cache_factory::get_instance($cacheconfig)->load($cacheconfig['type']);
	return $cache->set($name, $data, $timeout, '', $filepath);
}

function getCache($name, $filepath = '')
{
	bpBase::loadSysClass('cache_factory', '', 0);
	$cacheconfig = loadconfig('cache');
	$cache = cache_factory::get_instance($cacheconfig)->load($cacheconfig['type']);
	return $cache->get($name, '', '', $filepath);
}

function delCache($name, $filepath = '')
{
	bpBase::loadSysClass('cache_factory', '', 0);
	$cacheconfig = loadconfig('cache');
	$cache = cache_factory::get_instance($cacheconfig)->load($cacheconfig['type']);
	return $cache->delete($name, '', '', $filepath);
}

function delCacheByMid($mid = 0)
{
	bpBase::loadSysClass('cache_factory', '', 0);
	$cacheconfig = loadconfig('cache');
	$cache = cache_factory::get_instance($cacheconfig)->load($cacheconfig['type']);
	$name = array('wx_' . $mid . '_user', 'configData_card' . $mid, 'configData_' . $mid, 'configData_pf' . $mid, 'Cache_access_token_' . $mid, 'configData_alipay' . $mid, 'configData_pxy' . $mid, 'configData_alipf' . $mid);
	return $cache->delete($name, '', '', '');
}

function getCacheInfo($name, $filepath = '')
{
	bpBase::loadSysClass('cache_factory', '', 0);
	$cacheconfig = loadconfig('cache');
	$cache = cache_factory::get_instance($cacheconfig)->load($cacheconfig['type']);
	return $cache->cacheinfo($name, '', '', $filepath);
}

function new_addslashes($string)
{
	if (!is_array($string)) {
		return addslashes($string);
	}


	foreach ($string as $key => $val ) {
		$string[$key] = new_addslashes($val);
	}

	return $string;
}

function objectsToArrByKey($objects, $key = 'id')
{
	$arr = array();

	if ($objects) {
		foreach ($objects as $o ) {
			foreach ($o as $k => $v ) {
				$arr[$o->$key][$k] = $v;
			}
		}
	}


	return $arr;
}

function arrToArrByKey($array, $key = 'id')
{
	$arr = array();

	if ($array) {
		foreach ($array as $o ) {
			$arr[$o[$key]] = $o;
		}
	}


	return $arr;
}

function recurse_copy($src, $dst)
{
	$dir = opendir($src);
	@mkdir($dst);

	while (false !== $file = readdir($dir)) {
		if (($file != '.') && ($file != '..')) {
			if (is_dir($src . '/' . $file)) {
				recurse_copy($src . '/' . $file, $dst . '/' . $file);
			}
			 else {
				copy($src . '/' . $file, $dst . '/' . $file);
			}
		}

	}

	closedir($dir);
}

function Encryptioncode($string, $operation = 'DECODE', $key = '', $expiry = 0)
{
	$ckey_length = 4;
	$key = md5(($key != '' ? $key : 'lhs_simple_encryption_code_87063'));
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = (($ckey_length ? (($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length))) : ''));
	$cryptkey = $keya . md5($keya . $keyc);
	$key_length = strlen($cryptkey);
	$string = (($operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', ($expiry ? $expiry + time() : 0)) . substr(md5($string . $keyb), 0, 16) . $string));
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	$i = 0;

	while ($i <= 255) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		++$i;
	}

	$j = $i = 0;

	while ($i < 256) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
		++$i;
	}

	$a = $j = $i = 0;

	while ($i < $string_length) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ $box[($box[$a] + $box[$j]) % 256]);
		++$i;
	}

	if ($operation == 'DECODE') {
		if (((substr($result, 0, 10) == 0) || (0 < (substr($result, 0, 10) - time()))) && (substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16))) {
			return substr($result, 26);
		}


		return '';
	}


	return $keyc . str_replace('=', '', base64_encode($result));
}

function msubstr($str, $start = 0, $length, $charset = 'utf-8', $suffix = true)
{
	if (function_exists('mb_substr')) {
		$slice = mb_substr($str, $start, $length, $charset);
	}
	 else if (function_exists('iconv_substr')) {
		$slice = iconv_substr($str, $start, $length, $charset);
	}
	 else {
		$re['utf-8'] = '/[' . "\x1" . '-]|[' . "\xc2" . '-' . "\xdf" . '][' . "\x80" . '-' . "\xbf" . ']|[' . "\xe0" . '-' . "\xef" . '][' . "\x80" . '-' . "\xbf" . ']{2}|[' . "\xf0" . '-' . "\xff" . '][' . "\x80" . '-' . "\xbf" . ']{3}/';
		$re['gb2312'] = '/[' . "\x1" . '-]|[' . "\xb0" . '-' . "\xf7" . '][' . "\xa0" . '-' . "\xfe" . ']/';
		$re['gbk'] = '/[' . "\x1" . '-]|[' . "\x81" . '-' . "\xfe" . '][@-' . "\xfe" . ']/';
		$re['big5'] = '/[' . "\x1" . '-]|[' . "\x81" . '-' . "\xfe" . ']([@-~]|' . "\xa1" . '-' . "\xfe" . '])/';
		preg_match_all($re[$charset], $str, $match);
		$slice = join('', array_slice($match[0], $start, $length));
	}

	return ($suffix ? $slice . '...' : $slice);
}

function array_restructure($array, $field)
{
	$return = array();

	foreach ($array as $key => $val ) {
		$return[$val[$field]] = $val;
	}

	return $return;
}

function GetIpLookup($ip = '', $field = '')
{
	if (empty($ip)) {
		$ip = ip();
	}


	$cache_name = md5($ip . '_pigcms');
	$json = getcache($cache_name);

	if (!$json) {
		$res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);

		if (empty($res)) {
			return false;
		}


		$jsonMatches = array();
		preg_match('#\\{.+?\\}#', $res, $jsonMatches);

		if (!isset($jsonMatches[0])) {
			return false;
		}


		$json = json_decode($jsonMatches[0], true);

		if (isset($json['ret']) && ($json['ret'] == 1)) {
			$json['ip'] = $ip;
			unset($json['ret']);
		}
		 else {
			return false;
		}

		setcache($cache_name, serialize($json));
	}
	 else {
		$json = unserialize($json);
	}

	if ($field != '') {
		$return = '';
		$arr = explode(',', $field);

		foreach ($arr as $key => $val ) {
			$return .= $json[$val];
		}

		return $return;
	}


	return $json;
}

function array_swap($array, $field = '')
{
	$field = (($field == '' ? 'id' : $field));
	$new_array = array();

	foreach ($array as $key => $val ) {
		$new_array[$val[$field]] = $val;
	}

	return $new_array;
}



function p ($var) {
	if (is_bool($var)) {
		dump($var);
	} else if (is_null($var)){
		dump(NULL);
	}else {
		echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;opacity:0.9;line-height:18px'>".print_r($var,true).'</pre>';
	}

}


function dump($var, $echo = true, $label = NULL, $strict = true)
{
	$label = (($label === NULL ? '' : rtrim($label) . ' '));

	if (!$strict) {
		if (ini_get('html_errors')) {
			$output = print_r($var, true);
			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
		}
		 else {
			$output = $label . print_r($var, true);
		}
	}
	 else {
		ob_start();
		var_dump($var);
		$output = ob_get_clean();

		if (!extension_loaded('xdebug')) {
			$output = preg_replace('/\\]\\=\\>' . "\n" . '(\\s+)/m', '] => ', $output);
			$output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
		}
	}

	if ($echo) {
		echo $output;
		return;
	}


	return $output;
}


?>
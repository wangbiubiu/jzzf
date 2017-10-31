<?php
final class Sms
{
	public $topdomain;
	public $key;
	public $smsapi_url;

	public function __construct()
	{
	}

	static public function checkmobile($mobilephone)
	{
		$mobilephone = trim($mobilephone);

		if (preg_match('/^1[0-9]{10}$/', $mobilephone)) {
			return $mobilephone;
		}


		return false;
	}

	static public function sendSms($mid, $content = '', $mobile = '', $send_time = '', $charset = 'utf-8', $id_code = '')
	{
		if (empty($mobile)) {
			return 'phone is right';
		}


		if (is_array($mobile)) {
			$mobile = implode(',', $mobile);
		}


		$content = Sms::_safe_replace($content);
		$sms_config = loadConfig('sms');

		if (empty($sms_config)) {
			return;
		}


		$data = array('topdomain' => $sms_config['sms_topdomain'], 'key' => $sms_config['sms_key'], 'token' => $mid . 'cashier', 'content' => $content, 'mobile' => $mobile, 'sign' => $sms_config['sms_sign']);
		$post = '';

		foreach ($data as $k => $v ) {
			$post .= $k . '=' . $v . '&';
		}

		$smsapi_senturl = 'http://up.pigcms.cn/oa/admin.php?m=sms&c=sms&a=send';
		$return = Sms::_post($smsapi_senturl, 0, $post);
		return $return;
	}

	static private function _post($url, $limit = 0, $post = '', $cookie = '', $ip = '', $timeout = 15, $block = true)
	{
		$return = '';
		$url = str_replace('&amp;', '&', $url);
		$matches = parse_url($url);
		$host = $matches['host'];
		$path = (($matches['path'] ? $matches['path'] . (($matches['query'] ? '?' . $matches['query'] : '')) : '/'));
		$port = ((!empty($matches['port']) ? $matches['port'] : 80));
		$siteurl = Sms::_get_url();

		if ($post) {
			$out = 'POST ' . $path . ' HTTP/1.1' . "\r\n";
			$out .= 'Accept: */*' . "\r\n";
			$out .= 'Referer: ' . $siteurl . "\r\n";
			$out .= 'Accept-Language: zh-cn' . "\r\n";
			$out .= 'Content-Type: application/x-www-form-urlencoded' . "\r\n";
			$out .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
			$out .= 'Host: ' . $host . "\r\n";
			$out .= 'Content-Length: ' . strlen($post) . "\r\n";
			$out .= 'Connection: Close' . "\r\n";
			$out .= 'Cache-Control: no-cache' . "\r\n";
			$out .= 'Cookie: ' . $cookie . "\r\n\r\n";
			$out .= $post;
		}
		 else {
			$out = 'GET ' . $path . ' HTTP/1.1' . "\r\n";
			$out .= 'Accept: */*' . "\r\n";
			$out .= 'Referer: ' . $siteurl . "\r\n";
			$out .= 'Accept-Language: zh-cn' . "\r\n";
			$out .= 'User-Agent: ' . $_SERVER['HTTP_USER_AGENT'] . "\r\n";
			$out .= 'Host: ' . $host . "\r\n";
			$out .= 'Connection: Close' . "\r\n";
			$out .= 'Cookie: ' . $cookie . "\r\n\r\n";
		}

		$fp = @fsockopen(($ip ? $ip : $host), $port, $errno, $errstr, $timeout);

		if (!$fp) {
			return '';
		}


		stream_set_blocking($fp, $block);
		stream_set_timeout($fp, $timeout);
		@fwrite($fp, $out);
		$status = stream_get_meta_data($fp);

		if ($status['timed_out']) {
			return '';
		}


		while (!feof($fp)) {
			if (($header = @fgets($fp)) && (($header == "\r\n") || ($header == "\n"))) {
				break;
			}

		}

		$stop = false;

		while (($header == "\n") && !($fp) && !$stop) {
			$data = fread($fp, (($limit == 0) || (8192 < $limit) ? 8192 : $limit));
			$return .= $data;

			if ($limit) {
				$limit -= strlen($data);
				$stop = $limit <= 0;
			}

		}
		@fclose($fp);
		$return_arr = explode("\n", $return);

		if (isset($return_arr[1])) {
			$return = trim($return_arr[1]);
		}


		unset($return_arr);
		return $return;
	}

	static private function _get_url()
	{
		$sys_protocal = ((isset($_SERVER['SERVER_PORT']) && ($_SERVER['SERVER_PORT'] == '443') ? 'https://' : 'http://'));
		$php_self = (($_SERVER['PHP_SELF'] ? Sms::_safe_replace($_SERVER['PHP_SELF']) : Sms::_safe_replace($_SERVER['SCRIPT_NAME'])));
		$path_info = ((isset($_SERVER['PATH_INFO']) ? Sms::_safe_replace($_SERVER['PATH_INFO']) : ''));
		$relate_url = ((isset($_SERVER['REQUEST_URI']) ? Sms::_safe_replace($_SERVER['REQUEST_URI']) : $php_self . ((isset($_SERVER['QUERY_STRING']) ? '?' . Sms::_safe_replace($_SERVER['QUERY_STRING']) : $path_info))));
		return $sys_protocal . ((isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '')) . $relate_url;
	}

	static private function _safe_replace($string)
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
}


?>
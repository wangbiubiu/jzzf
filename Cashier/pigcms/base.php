<?php
define('SYS_TIME', time());
define('SYS_START_TIME', microtime());
define('CMSBASEDIR', dirname(__FILE__));

if (!defined('CACHE_PATH')) {
	define('CACHE_PATH', ABS_PATH . 'cache' . DIRECTORY_SEPARATOR);
}

if (!defined('PIGCMS_CORE_PATH_FOLDER')) {
	define('RL_PIGCMS_CORE_PATH', PIGCMS_CORE_PATH);
}
 else {
	define('RL_PIGCMS_CORE_PATH', PIGCMS_CORE_PATH_FOLDER);
}


if (!defined('PIGCMS_TPL_PATH_FOLDER')) {
	define('RL_PIGCMS_TPL_PATH', PIGCMS_TPL_PATH);
}
 else {
	define('RL_PIGCMS_TPL_PATH', PIGCMS_TPL_PATH_FOLDER);
}


if (!defined('PIGCMS_STATIC_PATH_FOLDER')) {
	define('RL_PIGCMS_STATIC_PATH', PIGCMS_STATIC_PATH);
}
 else {
	define('RL_PIGCMS_STATIC_PATH', PIGCMS_STATIC_PATH_FOLDER);
}


bpBase::loadSysFunc('global');
bpBase::loadSysFunc('extention');

if (DEBUG) {
	ini_set('display_errors', '1');
	error_reporting(32767 ^ 8);
}
 else {
	ini_set('display_errors', '0');
}

if (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
	$isPost = 1;
}
 else {
	$isPost = 0;
} 

define('IN_BACKGROUND', 1);
define('IS_POST', $isPost);
$systemConfig = loadConfig('system');

if (isset($systemConfig['maxUploadSize']) && (0 < $systemConfig['maxUploadSize'])) {
}
 else {
}

$maxUploadSize = 400;
define('MAX_UPLOAD_SIZE', $maxUploadSize);
ini_set('upload_max_filesize', $maxUploadSize);
header('Content-type: text/html; charset=' . DB_CHARSET);

if (!isset($_GET['nogzip'])) {
	if (defined('GZIP') && GZIP && function_exists('ob_gzhandler')) {
		ob_start('ob_gzhandler');
	}
	 else {
		ob_start();
	}
}



class bpBase
{
   
	static public function creatApp()
	{
	   
		return self::loadSysClass('application');
	}

	static public function loadSysClass($classname, $path = '', $initialize = 1)
	{ 
		return self::_loadClass($classname, $path, $initialize);
	}

	static private function _loadClass($classname, $path = '', $initialize = 1)
	{
		static $classes = array();

		if (empty($path)) {
			$path = 'libs' . DIRECTORY_SEPARATOR . 'classes';
		}
        

		$key = md5($path . $classname);

		if (isset($classes[$key])) {
			if (!empty($classes[$key])) {
				return $classes[$key];
			}


			return true;
		}

        
		if (file_exists(RL_PIGCMS_CORE_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php')) {
			include RL_PIGCMS_CORE_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php';
			$name = $classname;

			if ($my_path = self::my_path(RL_PIGCMS_CORE_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php')) {
			   
				include $my_path;
				$name = 'MY_' . $classname;
			}
			if ($initialize) {
				$classes[$key] = new $name();
			}
			 else {
				$classes[$key] = true;
			}

			return $classes[$key];
		}


		if ($path == 'model') {
			$tableName = str_replace('_model', '', $classname);
			file_put_contents(RL_PIGCMS_CORE_PATH . $path . DIRECTORY_SEPARATOR . $classname . '.class.php', '<?php bpBase::loadSysClass(\'model\', \'\', 0);class ' . $classname . ' extends model {public function __construct() {$this->table_name = \'' . $tableName . '\';parent::__construct();}} ?>');
		}


		return false;
	}

	static public function loadSysFunc($func)
	{
		return self::_loadFunc($func);
	}

	static private function _loadFunc($func, $path = '')
	{
		static $funcs = array();

		if (empty($path)) {
			$path = 'libs' . DIRECTORY_SEPARATOR . 'functions';
		}


		$path .= DIRECTORY_SEPARATOR . $func . '.func.php';
		$key = md5($path);

		if (isset($funcs[$key])) {
			return true;
		}


		if (file_exists(RL_PIGCMS_CORE_PATH . $path)) {
			include RL_PIGCMS_CORE_PATH . $path;
		}
		 else {
			$funcs[$key] = false;
			return false;
		}

		$funcs[$key] = true;
		return true;
	}

	static private function _autoLoadFunc($path = '')
	{
		if (empty($path)) {
			$path = 'libs' . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . 'autoload';
		}


		$path .= DIRECTORY_SEPARATOR . '*.func.php';
		$auto_funcs = glob(BP_PATH . DIRECTORY_SEPARATOR . $path);

		if (!empty($auto_funcs) && is_array($auto_funcs)) {
			foreach ($auto_funcs as $func_path ) {
				include $func_path;
			}
		}

	}

	static public function autoLoadFunc($path = '')
	{
		return self::_autoLoadFunc($path);
	}

	static public function my_path($filepath)
	{
		$path = pathinfo($filepath);

		if (file_exists($path['dirname'] . DIRECTORY_SEPARATOR . 'MY_' . $path['basename'])) {
			return $path['dirname'] . DIRECTORY_SEPARATOR . 'MY_' . $path['basename'];
		}


		return false;
	}

	static public function loadTagClass($tagName, $initialize = 1)
	{
		return self::_loadClass($tagName, 'modules' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'tags', $initialize);
	}

	static public function loadSmallTagClass($tagName, $initialize = 1)
	{
		return self::_loadClass($tagName, 'modules' . DIRECTORY_SEPARATOR . 'template' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'stags', $initialize);
	}

	static public function loadAppClass($classname, $m = '', $initialize = 1)
	{
		if (empty($m) && defined('ROUTE_M')) {
		}
		 else {
		}

		$m = $m;

		if (empty($m)) {
			return self::_loadClass($classname, 'Lib', $initialize);
		}


		return self::_loadClass($classname, 'Lib' . DIRECTORY_SEPARATOR . APP_NAME . DIRECTORY_SEPARATOR . $m . DIRECTORY_SEPARATOR . 'classes', $initialize);
	}

	static public function loadModuleClass($classname, $m = '', $initialize = 1)
	{
		return self::_loadClass($classname, 'modules' . DIRECTORY_SEPARATOR . $m, $initialize);
	}

	static public function loadAppFunc($func, $m = '')
	{
		if (empty($m) && defined('ROUTE_MODEL')) {
		}
		 else {
		}

		$m = $m;

		if (empty($m)) {
			return false;
		}


		return self::_loadFunc($func, 'modules' . DIRECTORY_SEPARATOR . $m . DIRECTORY_SEPARATOR . 'functions');
	}

	static public function loadModel($classname)
	{
		return self::_loadClass($classname, 'model');
	}

	static public function load_plugin_class($classname, $identification = '', $initialize = 1)
	{
		if (empty($identification) && defined('PLUGIN_ID')) {
		}
		 else {
		}

		$identification = $identification;

		if (empty($identification)) {
			return false;
		}


		return pc_base::load_sys_class($classname, 'plugin' . DIRECTORY_SEPARATOR . $identification . DIRECTORY_SEPARATOR . 'classes', $initialize);
	}

	static public function loadOrg($classname)
	{
		$classnameFile = RL_PIGCMS_CORE_PATH . 'libs' . DIRECTORY_SEPARATOR . 'org' . DIRECTORY_SEPARATOR . $classname . '.class.php';
		if (file_exists($classnameFile)) {
			include_once $classnameFile;
		}

	}

	static public function load_plugin_func($func, $identification)
	{
		static $funcs = array();

		if (empty($identification) && defined('PLUGIN_ID')) {
		}
		 else {
		}

		$identification = $identification;

		if (empty($identification)) {
			return false;
		}


		$path = 'plugin' . DIRECTORY_SEPARATOR . $identification . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR . $func . '.func.php';
		$key = md5($path);

		if (isset($funcs[$key])) {
			return true;
		}


		if (file_exists(BP_PATH . $path)) {
			include BP_PATH . $path;
		}
		 else {
			$funcs[$key] = false;
			return false;
		}

		$funcs[$key] = true;
		return true;
	}

	static public function load_plugin_model($classname, $identification)
	{
		if (empty($identification) && defined('PLUGIN_ID')) {
		}
		 else {
		}

		$identification = $identification;
		$path = 'plugin' . DIRECTORY_SEPARATOR . $identification . DIRECTORY_SEPARATOR . 'model';
		return self::_load_class($classname, $path);
	}
}

function M($tablename)
{
	$tablename = strtolower($tablename);
	return bpBase::loadModel($tablename . '_model');
}

function getKey($domain, $ip)
{
	$systemConfig = loadConfig('system');
	return md5(md5($ip . $domain) . $systemConfig['key']);
}


?>
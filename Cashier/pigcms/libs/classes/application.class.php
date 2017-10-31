<?php
class application
{
	public function __construct()
	{
		$route = bpBase::loadSysClass('route');

		if (!defined('ROUTE_MODEL')) {
			define('ROUTE_MODEL', $route->routeModel());
			define('ROUTE_CONTROL', $route->routeControl());
			define('ROUTE_ACTION', $route->routeAction());
		}


		$this->init();

		if (loadConfig('system', 'cron')) {
		}

	}

	private function init()
	{
		$controller = $this->load_controller();

		if (method_exists($controller, ROUTE_ACTION)) {
			if (preg_match('/^[_]/i', ROUTE_ACTION)) {
				exit('You are visiting the action which is to protect the private action');
			}
			 else {
				call_user_func(array($controller, ROUTE_ACTION));
			}
		}
		 else {
			exit(ROUTE_ACTION . ' Action does not exist.');
		}
	}

	private function load_controller($filename = '', $m = '')
	{
		if (empty($filename)) {
			$filename = ROUTE_CONTROL;
		}


		if (empty($m)) {
			$m = ROUTE_MODEL;
		}


		$PIGCMS_CORE_PATH = ((defined('OPIGCMS_CORE_PATH') ? OPIGCMS_CORE_PATH : PIGCMS_CORE_PATH));
		$filepath = ABS_PATH . $PIGCMS_CORE_PATH . 'Lib' . DIRECTORY_SEPARATOR . APP_NAME . DIRECTORY_SEPARATOR . $m . DIRECTORY_SEPARATOR . $filename . '.class.php';

		if (file_exists($filepath)) {
			$classname = $filename . '_controller';
			include $filepath;

			if ($mypath = bpBase::my_path($filepath)) {
				$classname = 'MY_' . $filename . '_controller';
				include $mypath;
			}


			return new $classname();
		}


		if (defined('DEBUG')) {
			exit($PIGCMS_CORE_PATH . 'Lib' . DIRECTORY_SEPARATOR . APP_NAME . DIRECTORY_SEPARATOR . $m . DIRECTORY_SEPARATOR . $filename . '.class.php doesn\'t exist.');
		}
		 else {
			exit(APP_NAME . DIRECTORY_SEPARATOR . $m . DIRECTORY_SEPARATOR . $filename . '.class.php doesn\'t exist.');
		}
	}
}


?>
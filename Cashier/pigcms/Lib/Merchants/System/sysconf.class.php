<?php

bpBase::loadAppClass('common', 'System', 0);
class sysconf_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->payConfigDb = M('cashier_payconfig');
	}

	public function index()
	{
		$sysadmin = loadConfig('sysadmin');
		$this->assign('sysadmin', $sysadmin);
		$this->display();
	}

	public function saveSysConf()
	{
		$data = array();
		$data['isregcheck'] = intval($_POST['isregcheck']);
		$writeConfStr = '<?php ' . "\n" . 'return ' . stripslashes(var_export($data, true)) . ';' . "\n\n" . '?>';
		$config_file = ABS_PATH . 'config' . DIRECTORY_SEPARATOR . 'sysadmin.config.php';

		if (file_put_contents($config_file, $writeConfStr) !== false) {
			$this->successTip('配置成功！');
		}
		 else {
			$this->errorTip('配置失败！');
		}
	}
}


?>
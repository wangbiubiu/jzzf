<?php

defined('IN_BACKGROUND') || exit('No permission');
bpBase::loadAppClass('smarty', '', 0);
class common_controller extends smarty_controller
{
	protected $isLogin = 0;
	protected $adminuser = array();
	protected $tablepre = '';
	protected $_mid = 0;
	protected $_uid = 0;

	public function __construct()
	{
		parent::__construct();
		$session_storage = getSessionStorageType();
		bpBase::loadSysClass($session_storage);
		$this->adminuser = unserialize($_SESSION['my_Cashier_adminuser']);
                
                
		if (!$this->adminuser || !is_array($this->adminuser) || !0 < $this->adminuser['uid']) {
		    
			if (!in_array(ROUTE_ACTION, array('login', 'logout', 'getCode'))) {
				header('Location:/merchants.php?m=System&c=index&a=login');
				exit();
			}

		}
		$db_config = loadConfig('db');
		$this->tablepre = $db_config['default']['tablepre'];
		unset($db_config);
		$this->_mid = ((!empty($this->adminuser) ? $this->adminuser['mid'] : 0));
		$this->_uid = ((!empty($this->adminuser) ? $this->adminuser['uid'] : 0));
		$this->assign('adminuser', $this->adminuser);
		$this->assign('_mid', $this->_mid);
		$this->assign('_uid', $this->_uid);
	}
	
	
	protected function cleanIspfPay($type)
	{
		if ($type == 'wx') {
			$data = array('pfpaymid' => 0);
		}
		 else if ($type == 'ali') {
			$data = array('pfalipaymid' => 0);
		}
		 else {
			$data = array();
		}

		if (!empty($data)) {
			M('cashier_payconfig')->update($data, `11=11`);
		}


		return true;
	}

	/*
	 * 导出数据
	 * @param array $data   数据总条数
	 *
	 * @param array $str   表格头
	 */
	public function ExportTable($data,$title,$filename = ''){
	   	$result = $data;
	   	
	   	//组装xls文本
	   	$str="";
	   	foreach ($title as &$value) {
	   	    $str .= $value;
	   	    $str .="\t";
	   	}
	   	$str .="\n";
	   	 
	   	$str = iconv('utf-8', 'gb2312', $str);
	   	 
	   	foreach ($result as  $k=>$row) {
	   	    $str1 ="";
	   	    foreach($row as $key=>$v){
	   	        $key = iconv('utf-8', 'gb2312', $v);
	   	        $str1 .= $key."\t";
	   	    }
	   	    $str .= $str1 ."\n";
	
	   	}
	   
	   	if(!$filename){
	   	    $filename = date('YmdHis') . '.xls';
	   	}
	   	
	   	$this->exportExcelData($filename, $str);
	   	 
	}
	 
	/**
	 * 导出excel表格
	 * @param unknown $filename
	 * @param unknown $content  
	 * 
	 */
	
	private function exportExcelData($filename, $content)
	{
	   	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	   	header("Content-Type: application/vnd.ms-execl");
	   	header("Content-Type: application/force-download");
	   	header("Content-Type: application/download");
	   	header("Content-Disposition: attachment; filename=" . $filename);
	   	header("Content-Transfer-Encoding: binary");
	   	header("Pragma: no-cache");
	   	header("Expires: 0");
	   	echo $content;
	}
}


?>
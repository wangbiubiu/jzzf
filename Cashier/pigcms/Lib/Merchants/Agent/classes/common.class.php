<?php

defined('IN_BACKGROUND') || exit('No permission');
bpBase::loadAppClass('base', '', 0);
class common_controller extends base_controller
{
	protected $agents = array();
	protected $salesnam = array();
	protected $aid;
	protected $storeid = 0;
	protected $sid = 0;
	protected $extraInsertData = array();
	protected $tablepre = '';

	public function __construct()
	{
		parent::__construct();
		
		$session_storage = getSessionStorageType();
		bpBase::loadSysClass($session_storage);
		$isLogin = 0;
        
		if(!empty($_GET['agent_aid'])){

		    $id = intval($_GET['agent_aid']);
		    if(!empty($_SESSION['my_Cashier_adminuser'])){
		        $_SESSION['my_Cashier_Agent']['aid'] = $id;
		    }else{
		        $this->errorTip('非法请求!!');
		    }
		}
		
		
		
		
		
		
		if (isset($_SESSION['my_Cashier_Agent']['aid']) || !empty($_SESSION['my_Cashier_Agent']['aid'])){
			$isLogin = 1;

			$this->agents = M('cashier_agent')->get_one(array('aid' => $_SESSION['my_Cashier_Agent']['aid']));

			$this->aid = $this->agent['aid'];
		}
		// } else {

		// 	if (isset($_SESSION['my_Cashier_Salesman']['sid']) || !empty($_SESSION['my_Cashier_Salesman']['sid'])) {

		// 		$isLogin = 1;
		// 		$this->Salesman = M('cashier_salesman')->get_one(array('id' => $_SESSION['my_Cashier_Salesman']['sid']));
		// 		var_dump($this->salesnam);die;

		// 		$this->agents = M('cashier_agent')->get_one(array('aid' => $this->Salesman['aid']));
                                
		// 		 $this->aid = $this->Salesnam['aid'];

				


		// 	}


		if ($isLogin == 0) {

			header('Location:merchants.php?m=Index&c=login&a=agentLogin');
			exit();
		}
		 else if (empty($this->agents)) {

			$this->errorTip('账号异常，请重新登录！', '/merchants.php?m=Index&c=login&a=agentLogin');
			exit();
		}

                

		$db_config = loadConfig('db');
		$this->tablepre = $db_config['default']['tablepre'];
		unset($db_config);
	}



	protected function getAdminuserInfo()
	{
		$adminUtmp = M('cashier_adminuser')->get_one('1=1');
		$adminUtmp = M('cashier_payconfig')->get_one(array('aid' => $adminUtmp['aid']), '*');

		if ($adminUtmp['configData']) {
			$adminUtmp['configData'] = unserialize(htmlspecialchars_decode($adminUtmp['configData'], ENT_QUOTES));
		}
		 else {
			$adminUtmp['configData'] = array();
		}

		return $adminUtmp;
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
			M('cashier_payconfig')->update($data, '11=11');
		}


		return true;
	}

	protected function authorityControl($data = array())
	{
		$eid = 0;
		isset($_SESSION['my_Cashier_Salesman']) && !empty($_SESSION['my_Cashier_Salesman']) && isset($_SESSION['my_Cashier_Salesman']['eid']) && !empty($_SESSION['my_Cashier_Salesman']['eid']) && ($eid = intval($_SESSION['my_Cashier_Salesman']['eid']));

		if ((0 < $eid) && !in_array(ROUTE_ACTION, $data)) {
			if (!$this->authority($this->Salesman['authority'])) {
				if (isAjax()) {
					exit(json_encode(array('status' => 0, 'error' => 1, 'msg' => '您没有权限访问！')));
				}
				 else {
					$this->errorTip('您没有权限访问！');
				}
			}

		}


		return true;
	}

	protected function getStoreInfo($iswxpass = true)
	{
		$cashier_storesDb = M('cashier_stores');

		if ($iswxpass) {
			$whereArr = array('aid' => $this->aid, 'available_state' => 3);
		}
		 else {
			$whereArr = array('aid' => $this->aid);
		}

		$allStores = $cashier_storesDb->select($whereArr, 'id,aid,poi_id,business_name,branch_name,available_state', '', 'id DESC');
		return $allStores;
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
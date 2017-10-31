<?php

defined('IN_BACKGROUND') || exit('No permission');
bpBase::loadAppClass('base', '', 0);

class common_controller extends base_controller
{
	protected $salesmans = array();
	protected $employer = array();
	protected $sid;
	protected $storeid = 0;
	protected $eid = 0;
	protected $extraInsertData = array();
	protected $tablepre = '';
	public function __construct()
	{
	    
		parent::__construct();
		
		$session_storage = getSessionStorageType();
		bpBase::loadSysClass($session_storage);
		$isLogin = 0;
		
		/**
		 *  一键登录管理
		 */
		if(!empty($_GET['sid'])){
		    if(!empty($_SESSION['my_Cashier_Agent'])){
		        $id = $_SESSION['my_Cashier_Agent']['aid'];
		        //验证当前代理商下是否存在该业务员
		        $salesmans_get = M('cashier_salesmans')->get_one(array('id'=>$_GET['sid'],'aid'=>$id));
		        if(!empty($salesmans_get)){
		            $_SESSION['my_Cashier_Salesman']['sid'] = $salesmans_get['id'];
		        }else{
		            $this->errorTip('非法请求!!');
		        }
		    }else{
		        $this->errorTip('非法请求!!');
		    }
		}
		
		
		if (isset($_SESSION['my_Cashier_Salesman']['sid']) || !empty($_SESSION['my_Cashier_Salesman']['sid'])) {
			$isLogin = 1;
			$this->salesmans = M('cashier_salesmans')->get_one(array('id' => $_SESSION['my_Cashier_Salesman']['sid']));
			$this->mid = $this->salesmans['id'];

		}
		/*  else {
			if (isset($_SESSION['my_Cashier_Employer']['eid']) || !empty($_SESSION['my_Cashier_Employer']['eid'])) {
				$isLogin = 1;
				$this->employer = M('cashier_employee')->get_one(array('eid' => $_SESSION['my_Cashier_Employer']['eid']));
				$this->merchant = M('cashier_merchants')->get_one(array('mid' => $this->employer['mid']));
				$this->mid = $this->employer['mid'];
				$this->storeid = $this->employer['storeid'];
				$this->eid = $this->employer['eid'];

				if (0 < $this->storeid) {
					$this->extraInsertData = array('eid' => $this->eid, 'storeid' => $this->storeid);
				}

			}

		} */

		if ($isLogin == 0) {
			header('Location:merchants.php?m=Index&c=login&a=salesmansLogin');
			exit();
		}
		 else if (empty($this->salesmans)) {
			$this->errorTip('账号异常，请重新登录！', '/merchants.php?m=Index&c=login&a=salesmansLogin');
			exit();
		}
		

		$db_config = loadConfig('db');
		$this->tablepre = $db_config['default']['tablepre'];
		unset($db_config);
	}
    protected function getAdminuserInfo()
	{
		$adminUtmp = M('cashier_adminuser')->get_one('1=1');
		$adminUtmp = M('cashier_payconfig')->get_one(array('mid' => $adminUtmp['mid']), '*');

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
			M('cashier_payconfig')->update($data, `11=11`);
		}


		return true;
	}

	protected function authorityControl($data = array())
	{
		$eid = 0;
		isset($_SESSION['my_Cashier_Employer']) && !empty($_SESSION['my_Cashier_Employer']) && isset($_SESSION['my_Cashier_Employer']['eid']) && !empty($_SESSION['my_Cashier_Employer']['eid']) && ($eid = intval($_SESSION['my_Cashier_Employer']['eid']));

		if ((0 < $eid) && !in_array(ROUTE_ACTION, $data)) {
			if (!$this->authority($this->employer['authority'])) {
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
			$whereArr = array('mid' => $this->mid, 'available_state' => 3);
		}
		 else {
			$whereArr = array('mid' => $this->mid);
		}

		$allStores = $cashier_storesDb->select($whereArr, 'id,mid,poi_id,business_name,branch_name,available_state', '', 'id DESC');
		return $allStores;
	}
	
	static protected function getUserApi($data){
	    
	}
	
	/**
	 *  查询当前业务员下所有商户
	 */
	
	public function MerchantsID($id){
	    if($id){
	        $sqlObj = new model();
	        $merchants_sql = "SELECT mid FROM ".$this->tablepre."cashier_merchants WHERE sid=".$id ;
	        $merchantsID =  $sqlObj->selectBySql($merchants_sql);
	        $mid = '';
	        foreach ($merchantsID as $key => $val){
	            $mid .= $val['mid'] .',';
	        }
	        $mid = substr($mid,0,strlen($mid)-1);
	        if($mid){
	            return $mid;
	        }else{
	            return false;
	        }
	    }else{
	        return false;
	    }
	     
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
<?php

bpBase::loadAppClass('common', 'System', 0);
class rlmanage_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$rolegroup = M('cashier_rolegroup');
		$rlgroup = $rolegroup->select();
		$this->assign('rlgroup', $rlgroup);
		$this->display();
	}
}


?>
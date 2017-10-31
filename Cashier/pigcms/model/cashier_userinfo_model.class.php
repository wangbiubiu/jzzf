<?php

bpBase::loadSysClass('model', '', 0);
class cashier_userinfo_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_userinfo';
		parent::__construct();
	}
}


?>
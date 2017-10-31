<?php

bpBase::loadSysClass('model', '', 0);
class cashier_rolegroup_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_rolegroup';
		parent::__construct();
	}
}


?>
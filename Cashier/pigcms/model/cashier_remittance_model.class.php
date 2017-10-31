<?php

bpBase::loadSysClass('model', '', 0);
class cashier_remittance_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_remittance';
		parent::__construct();
	}
}


?>
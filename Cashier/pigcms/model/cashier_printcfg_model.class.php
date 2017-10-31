<?php

bpBase::loadSysClass('model', '', 0);
class cashier_printcfg_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_printcfg';
		parent::__construct();
	}
}


?>
<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbgifts_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbgifts';
		parent::__construct();
	}
}


?>
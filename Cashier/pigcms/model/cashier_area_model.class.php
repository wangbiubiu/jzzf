<?php

bpBase::loadSysClass('model', '', 0);
class cashier_area_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_area';
		parent::__construct();
	}
}


?>
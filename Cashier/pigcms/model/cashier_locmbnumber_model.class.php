<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbnumber_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbnumber';
		parent::__construct();
	}
}


?>
<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbcard_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbcard';
		parent::__construct();
	}
}


?>
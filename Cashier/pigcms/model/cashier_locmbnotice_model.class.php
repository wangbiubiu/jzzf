<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbnotice_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbnotice';
		parent::__construct();
	}
}


?>
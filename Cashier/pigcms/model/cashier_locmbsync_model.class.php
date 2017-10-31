<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbsync_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbsync';
		parent::__construct();
	}
}


?>
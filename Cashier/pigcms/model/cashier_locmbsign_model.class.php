<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbsign_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbsign';
		parent::__construct();
	}
}


?>
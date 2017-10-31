<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbuserecord_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbuserecord';
		parent::__construct();
	}
}


?>
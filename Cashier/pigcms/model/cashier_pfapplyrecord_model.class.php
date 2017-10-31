<?php

bpBase::loadSysClass('model', '', 0);
class cashier_pfapplyrecord_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_pfapplyrecord';
		parent::__construct();
	}
}


?>
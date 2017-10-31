<?php

bpBase::loadSysClass('model', '', 0);
class cashier_activity_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_activity';
		parent::__construct();
	}
}


?>
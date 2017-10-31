<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbdonate_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbdonate';
		parent::__construct();
	}
}


?>
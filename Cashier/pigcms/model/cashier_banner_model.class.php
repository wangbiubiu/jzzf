<?php

bpBase::loadSysClass('model', '', 0);
class cashier_banner_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_banner';
		parent::__construct();
	}
}


?>
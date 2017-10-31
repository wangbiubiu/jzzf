<?php

bpBase::loadSysClass('model', '', 0);
class cashier_menu_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_menu';
		parent::__construct();
	}
}


?>
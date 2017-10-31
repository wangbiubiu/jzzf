<?php

bpBase::loadSysClass('model', '', 0);
class cashier_category_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_category';
		parent::__construct();
	}
}


?>
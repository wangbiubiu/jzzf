<?php

bpBase::loadSysClass('model', '', 0);
class cashier_sub_merchant_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_sub_merchant';
		parent::__construct();
	}
}


?>
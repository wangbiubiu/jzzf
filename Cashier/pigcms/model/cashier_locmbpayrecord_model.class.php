<?php

bpBase::loadSysClass('model', '', 0);
class cashier_locmbpayrecord_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_locmbpayrecord';
		parent::__construct();
	}
}


?>
<?php

bpBase::loadSysClass('model', '', 0);
class cutprice_order_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cutprice_order';
		parent::__construct();
	}
}


?>
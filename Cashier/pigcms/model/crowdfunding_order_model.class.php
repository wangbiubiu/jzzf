<?php

bpBase::loadSysClass('model', '', 0);
class crowdfunding_order_model extends model
{
	public function __construct()
	{
		$this->table_name = 'crowdfunding_order';
		parent::__construct();
	}
}


?>
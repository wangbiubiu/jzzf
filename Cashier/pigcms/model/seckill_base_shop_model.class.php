<?php

bpBase::loadSysClass('model', '', 0);
class seckill_base_shop_model extends model
{
	public function __construct()
	{
		$this->table_name = 'seckill_base_shop';
		parent::__construct();
	}
}


?>
<?php

bpBase::loadSysClass('model', '', 0);
class seckill_action_model extends model
{
	public function __construct()
	{
		$this->table_name = 'seckill_action';
		parent::__construct();
	}
}


?>
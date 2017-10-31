<?php

bpBase::loadSysClass('model', '', 0);
class lottery_model extends model
{
	public function __construct()
	{
		$this->table_name = 'lottery';
		parent::__construct();
	}
}


?>
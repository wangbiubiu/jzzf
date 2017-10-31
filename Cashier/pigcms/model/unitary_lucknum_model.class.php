<?php

bpBase::loadSysClass('model', '', 0);
class unitary_lucknum_model extends model
{
	public function __construct()
	{
		$this->table_name = 'unitary_lucknum';
		parent::__construct();
	}
}


?>
<?php

bpBase::loadSysClass('model', '', 0);
class unitary_model extends model
{
	public function __construct()
	{
		$this->table_name = 'unitary';
		parent::__construct();
	}
}


?>
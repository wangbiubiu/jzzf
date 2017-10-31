<?php

bpBase::loadSysClass('model', '', 0);
class bargain_model extends model
{
	public function __construct()
	{
		$this->table_name = 'bargain';
		parent::__construct();
	}
}


?>
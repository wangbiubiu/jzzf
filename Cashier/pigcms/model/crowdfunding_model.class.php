<?php

bpBase::loadSysClass('model', '', 0);
class crowdfunding_model extends model
{
	public function __construct()
	{
		$this->table_name = 'crowdfunding';
		parent::__construct();
	}
}


?>
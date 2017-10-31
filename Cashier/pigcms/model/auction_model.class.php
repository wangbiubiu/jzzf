<?php

bpBase::loadSysClass('model', '', 0);
class auction_model extends model
{
	public function __construct()
	{
		$this->table_name = 'auction';
		parent::__construct();
	}
}


?>
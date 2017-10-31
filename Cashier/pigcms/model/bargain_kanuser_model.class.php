<?php

bpBase::loadSysClass('model', '', 0);
class bargain_kanuser_model extends model
{
	public function __construct()
	{
		$this->table_name = 'bargain_kanuser';
		parent::__construct();
	}
}


?>
<?php

bpBase::loadSysClass('model', '', 0);
class cutprice_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cutprice';
		parent::__construct();
	}
}


?>
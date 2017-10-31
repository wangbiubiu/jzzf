<?php

bpBase::loadSysClass('model', '', 0);
class cashier_attention_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_attention';
		parent::__construct();
	}
}


?>
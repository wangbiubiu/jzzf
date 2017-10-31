<?php

bpBase::loadSysClass('model', '', 0);
class cashier_card_bonus_model extends model
{
	public function __construct()
	{
		$this->table_name = 'cashier_card_bonus';
		parent::__construct();
	}
}


?>

<?php

bpBase::loadAppClass('common', 'User', 0);
class count_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		
		include $this->showTpl();
	}
        //门店统计
	public function store()
	{
		
		include $this->showTpl();
	}

}


?>
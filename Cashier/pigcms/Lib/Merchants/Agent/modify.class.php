<?php

bpBase::loadAppClass('common', 'Agent', 0);
class modify_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
	
		include $this->showTpl();
	}

	public function setinfo () {
		echo 'setinfo';
		include $this->showTpl();
	}


	
}


?>
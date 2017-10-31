<?php

bpBase::loadAppClass('common', 'User', 0);
class test_controller extends common_controller
{
	public function __construct()
	{
		parent::__construct();

	}

	public function p($str) {
		echo "<pre>".print_r($str).'</pre>';
	}
	public function index()
	{
		include $this->showTpl();
	}


	
	public function test () {

	}


}


?>
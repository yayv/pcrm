<?php
include_once('commoncontroller.php');

class stage extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		// TODO: <b style='color:red;'>实现人生阶段</b>
		$this->init();
			

	}

}

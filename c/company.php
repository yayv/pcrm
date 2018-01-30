<?php
include_once('commoncontroller.php');

class company extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		// TODO: 实现公司列表，查找等功能
		$this->init();
			
		$body = "实现公司列表，查找等功能";		
		
		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function add()
	{
		if(!$this->isLogined()) die();

		parent::init();

		//$body = strtr($body,array("\n"=>'<br/>',' '=>'&nbsp;'));
		$body = $this->tpl->fetch('person_add.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function show()
	{
		if(!$this->isLogined()) die();

		parent::init();

	}

}

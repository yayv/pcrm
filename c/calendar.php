<?php
include_once('commoncontroller.php');

class calendar extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		$this->init();

		// TODO: 按照月呈现访问记录，作为工作记录。
		$body = $this->tpl->fetch('calendar_index.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function addlog()
	{
		if(!$this->isLogined()) die();

		parent::init();

		//$body = strtr($body,array("\n"=>'<br/>',' '=>'&nbsp;'));
		$this->tpl->assign('today',date('Y-m-d'));
		$body = $this->tpl->fetch('calendar_addlog.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function doaddLog()
	{
		if(!$this->isLogined()) die();

		parent::init();

		$date = $_POST['date'];
		$time = $_POST['time'];
		$type = $_POST['type'];
		$abou = $_POST['about'];
		$pids = $_POST['ids'];
		$cont = $_POST['content'];

		// TODO: 支持多ID,多姓名的状态
		$ret  = $this->getModel('mlog')->addLog($date,$time,$pids,$abou,$cont,$type);
		
		header('Content-Type:text/javascript');
		if($ret)
			echo json_encode(array('ret'=>1,'msg'=>'记录已保存'));
		else
			echo json_encode(array('ret'=>0,'msg'=>'记录保存失败'));
	}

	public function addtodo()
	{
		if(!$this->isLogined()) die();

		parent::init();

		//$body = strtr($body,array("\n"=>'<br/>',' '=>'&nbsp;'));
		$this->tpl->assign('today',date('Y-m-d'));
		$body = $this->tpl->fetch('calendar_addtodo.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function doaddTODO()
	{
		if(!$this->isLogined()) die();

		parent::init();

		header('Content-Type:text/javascript');
		if($ret)
			echo json_encode(array('ret'=>1,'msg'=>'记录已保存'));
		else
			echo json_encode(array('ret'=>0,'msg'=>'记录保存失败'));
	}

	public function calendar()
	{
		if(!$this->isLogined()) die();

		// TODO: 日历方式呈现待做事项

		
	}	
}

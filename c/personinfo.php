<?php
include_once('commoncontroller.php');

class personinfo extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		header('location:/person/');
		return ;
	}

	public function show()
	{
		if(!$this->isLogined()) die();

		parent::init();

		$id = isset($_GET['id'])?intval($_GET['id']):0;

		if($id<=0) 
		{
			header('location:/person/all');
			return ;
		}

		$person = $this->getModel('mperson')->getPersonById($id);
		$tags   = explode(',',$this->getModel('mtags')->getTagsById($id));

		$logs   = $this->getModel('mlog')->getLogs($id);

		$p = Core::getInstance()->getConfig('plugins');
		$panels = array();

		foreach($p['personinfo'] as $k=>$v)
		{
			$panels[] = $this->getModel($v)->getPanelInfo();
			$ret = $this->getModel($v)->getPanelValue("personinfo",$person);
			$this->tpl->assign($v,$ret);
		}

		// TODO: 本页应该支持插件
		// TODO: 页面右侧多个页签，每一个页签就是一种插件，目前可以确认的有: 记录，履历，关系，财务
		// 目前看, 记录插件基本完成，但是在展现上，尚有更大的改进空间
		$today = date('Y-m-d');
		$this->tpl->assign('panels',$panels);
		$this->tpl->assign('today',$today);
		$this->tpl->assign('tags',$tags);
		$this->tpl->assign('person',$person);
		$this->tpl->assign('logs',$logs);
		$body = $this->tpl->fetch('person_info.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function edit()
	{
		if(!$this->isLogined()) die();

		parent::init();

		$id  = $_GET['id'];

		$ret = $this->getModel('mperson')->getPersonById($id);

		$this->tpl->assign('person',$ret);
		$body= $this->tpl->fetch('person_edit.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar',$navigatebar);

		$this->tpl->assign('body',$body);
		$this->tpl->display('index.tpl.html');
	}

	public function updatePerson()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$id         = $_POST['id'];
		$name 		= $_POST['name'];
		$nickname 	= $_POST['nickname'];
		$mobile1 	= $_POST['phone1'];
		$mobile2 	= $_POST['phone2'];
		$email  	= $_POST['email'];
		$gender	 	= $_POST['gender'];
		$vocation 	= $_POST['vocation'];
		$company 	= $_POST['company'];
		$department = $_POST['department'];
		$jobtitle 	= $_POST['jobtitle'];
		$companyaddress 	= $_POST['companyaddress'];
		$companyzipcode 	= $_POST['companyzipcode'];
		$note 		= $_POST['note'];

		$ret = $this->getModel('mperson')->updatePerson(						
						$id,$name,$nickname,$mobile1,$mobile2,$email,$gender,
						$vocation,$company,$department,$jobtitle,$companyaddress,$companyzipcode,
						$note);

		if($ret)
		{
			echo json_encode(array('ret'=>1,'msg'=>'ok, updated'));
		}
		else
			echo json_encode(array('ret'=>0,'msg'=>'failed'));
	}



	public function addStage()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$id         = $_POST['id'];		
		print_r($_POST);
	}	
}

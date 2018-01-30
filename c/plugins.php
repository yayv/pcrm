<?php
include_once('commoncontroller.php');

class plugins extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		// TODO: 实现公司列表，查找等功能
		$this->init();
			
		$body = "这里是插件功能交互的入口";		
		
	}

	public function appendLog()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));


		// TODO: 这里增加log, todo ,notify 的功能，应该完成了，		
		$personid   = isset($_POST['personid'])?$_POST['personid']:0;
		$date       = isset($_POST['date'])?$_POST['date']:0;
		$note       = isset($_POST['note'])?$_POST['note']:0;
		$type       = isset($_POST['typ'])?$_POST['typ']:0;
		$notify     = isset($_POST['notify'])?$_POST['notify']:0;

		if($type!='birthday' && $note=='')
		{
			echo('location:/personinfo/show?id='.$personid);
			return ;
		}

		$person = $this->getModel('mperson')->getPersonById($personid);
		#echo '<pre>';print_r($type);die();
		switch($type)
		{
			case 'log':
				$ret = $this->getModel('mlog')->addLog($personid,$person['name'], $date,$note);
				break;
			case 'todo':
				$ret = $this->getModel('mlog')->addTodo($personid,$person['name'], $date,$note);
				break;
			case 'notify':
				$ret = $this->getModel('mlog')->addNotify($personid,$person['name'], $date,$note,$notify);
				break;
			case 'birthday':
				$ret = $this->getModel('mlog')->addBirthday($personid,$person['name'], $date);
				break;
			default:
				break;
		}

		header('location:/personinfo/show?id='.$personid);
	}	
	
	public function updatePersoninfoEx()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));

		// TODO: 这里增加log, todo ,notify 的功能，应该完成了，		
		$personid   = $_POST['personid'];
		$personinfotext = $_POST['personinfoex'];

		$ret = $this->getModel('mpersoninfoex')->updatePersoninfoExText($personid,$personinfotext);
		if($ret)
		{
			$this->getModel('mpersoninfoex')->parseText();
		}

		header("location:/personinfo/show?id=$personid");

		return $ret;
	}
}

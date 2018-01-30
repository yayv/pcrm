<?php
include_once('commoncontroller.php');

class data extends CommonController
{
	private $folder;

	public function __construct()
	{
		$this->folder = "/Users/liuce/Dropbox/客户信息/";
	}

	public function index()
	{
		echo 'hi';
		return ;
	}

	public function dumpToFiles()
	{
		#if(!$this->isLogined()) die("login first!\n");
		$this->init();

		$name = isset($_POST['name'])?$_POST['name']:'';
		if($name!='')
			$condition = "name like '%$name%'";
		else
			$condition = false;

		$persons = $this->getModel('mperson')->getPersonsValue(0,20000,'id,name', $condition);

		#var_dump($persons);
		foreach($persons as $k => $v)
		{
			$ret1 = mkdir($this->folder.$v['name']);
			$ret2 = file_put_contents($this->folder.$v['name'].'.txt', $v['id']);
			echo $v['id']." : ". $v['name']." ".($ret1?1:0)." ".($ret2?1:0)."\n";
		}
	}

	public function importFromFiles()
	{
		#if(!$this->isLogined()) die("login first!\n");
		$this->init();

		$a = scandir($this->folder);
		echo '<pre>';
		print_r($a);
	}	
}

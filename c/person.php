<?php
include_once('commoncontroller.php');

class person extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		// TODO: 实现拜访记录
		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);
		
		// TODO: 请在下面实现您的默认action
		$body = file_get_contents('data/todo.txt');
		$body .= file_get_contents('data/history.txt');
		$body = strtr($body,array("\n"=>'<br/>',' '=>'&nbsp;'));
		
		#$this->tpl->assign('menuarr', $menu);
		#$menustr = $this->tpl->fetch('right.menu.tpl.html');
		
		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function add()
	{
		if(!$this->isLogined()) die();

		parent::init();

		// TODO: 需要对所在行业进行新建联系人时提示吗？
		//$body = strtr($body,array("\n"=>'<br/>',' '=>'&nbsp;'));
		$body = $this->tpl->fetch('person_add.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}


	public function all()
	{
		if(!$this->isLogined()) die();

		parent::init();

		$start = isset($_GET['start'])?$_GET['start']:(isset($_COOKIE['browseid'])?$_COOKIE['browseid']:0);
		$start = intval($start)<0?0:$start;

		// 暂存浏览位置，为了下一次打开时随时可以继续
		setcookie('browseid',$start,time()+3600*24*30);

		$ret = $this->getModel('mperson')->getPersons($start, 4);

		$this->tpl->assign('title', '客户列表'.$start.'页'.'-'.core::getInstance()->getConfig('title'));
		$this->tpl->assign('persons',$ret);
		$this->tpl->assign('start',$start);
		$body = $this->tpl->fetch('person_browse.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function namelist()
	{
		if(!$this->isLogined()) die();

		$this->init();

		$name = isset($_POST['name'])?$_POST['name']:'';
		if($name!='')
			$condition = "name like '%$name%'";
		else
			$condition = false;

		$persons = $this->getModel('mperson')->getPersonsValue(0,20000,'id,name,nickname', $condition);

		$this->tpl->assign('persons',$persons);
		$this->tpl->assign('count',count($persons));
		$body = $this->tpl->fetch('person_list.tpl.html');

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	// json result below
	public function doaddPerson()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

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

		$ret = $this->getModel('mperson')->addNewPerson(						
						$name,$nickname,$mobile1,$mobile2,$email,$gender,
						$vocation,$company,$department,$jobtitle,$companyaddress,$companyzipcode,
						$note);

		if($ret)
		{
			echo json_encode(array('ret'=>1,'msg'=>'ok, added'));
		}
		else
			echo json_encode(array('ret'=>0,'msg'=>'failed'));
	}



	public function getpersonbyname()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$name = $_GET['name'];

		if($name!='')
			$ret = $this->getModel('mperson')->getPersonByName($name);
		else
			$ret = false;

		if($ret)
		{
			if(count($ret)<100)
				echo json_encode(array('ret'=>1,'msg'=>'ok','data'=>$ret));			
			else
			{
				print_r($ret);
				echo json_encode(array('ret'=>0,'msg'=>'too many results'));
			}
				
		}
		else
			echo json_encode(array('ret'=>0,'msg'=>'no result'));
	}

	public function getpersonbymobile()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$mobile = $_GET['name'];

		if($mobile!='')
			$ret = $this->getModel('mperson')->getPersonByPhone($mobile);
		else
			$ret = false;

		if($ret)
		{
			if(count($ret)<100)
				echo json_encode(array('ret'=>1,'msg'=>'ok','data'=>$ret));			
			else
			{
				print_r($ret);
				echo json_encode(array('ret'=>0,'msg'=>'too many results'));
			}
				
		}
		else
			echo json_encode(array('ret'=>0,'msg'=>'no result'));
	}
	public function getpersonbyemail()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$email = $_GET['name'];

		if($email!='')
			$ret = $this->getModel('mperson')->getPersonByEmail($email);
		else
			$ret = false;

		if($ret)
		{
			if(count($ret)<100)
				echo json_encode(array('ret'=>1,'msg'=>'ok','data'=>$ret));			
			else
			{
				print_r($ret);
				echo json_encode(array('ret'=>0,'msg'=>'too many results'));
			}
				
		}
		else
			echo json_encode(array('ret'=>0,'msg'=>'no result'));
	}
	public function getcompanyname()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$name = $_GET['name'];

		if($name!='')
			$ret = $this->getModel('mperson')->getCompanyName($name);
		else
			$ret = false;

		if($ret)
		{
			if(count($ret)<100)
				echo json_encode(array('ret'=>1,'msg'=>'ok','data'=>$ret));			
			else
			{
				echo json_encode(array('ret'=>0,'msg'=>'too many results'));
			}
				
		}
		else
			echo json_encode(array('ret'=>0,'msg'=>'no result'));

	}

	public function names_json()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$ret = array();
		$all = $this->getModel('mperson')->getPersons(0, 5000);
		foreach($all as $k=>$v)
		{
			$ret[] = $v['name'].'('.$v['nickname'].'):'.$v['mobile1'].','.$v['mobile2'];
		}

		echo json_encode($ret);
	}

	public function phones_json()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'login first')));

		$this->init();

		$ret = array();
		$all = $this->getModel('mperson')->getPersons(0, 5000);
		foreach($all as $k=>$v)
		{
			if($v['mobile1'] || $v['mobile2'])
				$ret[] = $v['name'].'('.$v['nickname'].'):'.$v['mobile1'].','.$v['mobile2'];
		}

		echo json_encode($ret);
	}
}

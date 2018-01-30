<?php
include_once('commoncontroller.php');

class pcrm extends CommonController
{
	public function __construct()
	{
	}
	
	public function index()
	{
		$this->countActions();
	}

	public function search()
	{
		
	}

	public function countActions()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$this->tpl->assign('owner', $this->getModel('moperson')->getOwner());
		
		$birthday = $this->getModel('moperson')->getPersonByBirthday();
		$this->tpl->assign('birthday',$birthday);

		$rets = $this->getModel('moperson')->countNewpersonByDay();
		$this->tpl->assign('newpersons', $rets);
		$body = $this->tpl->fetch('pcrm_index.tpl.html');

		$menustr = "";
		$this->tpl->assign('navigatebar', $this->getNaviBar());
		$this->tpl->assign('body', $body);
		$this->tpl->assign('menu', $menustr);	
		$this->tpl->display('index.tpl.html');
	}

	public function allcontacts()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);
		
		$ret  = $this->getModel('moperson')->getPersonNameList();
		$this->tpl->assign('owner', $this->getModel('moperson')->getOwner());
		$this->tpl->assign('personlist',$ret);
		$body = $this->tpl->fetch('pcrm_personlist.tpl.html');
		
		$menustr = "";
		$this->tpl->assign('navigatebar', $this->getNaviBar());
		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->assign('menu', $menustr);	
		$this->tpl->display('index.tpl.html');
	}

	public function customs()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);
		
		$ret  = $this->getModel('moperson')->getCustomList();
		$this->tpl->assign('owner', $this->getModel('moperson')->getOwner());
		$this->tpl->assign('personlist',$ret);
		$body = $this->tpl->fetch('pcrm_personlist.tpl.html');
		
		$menustr = "";
		$this->tpl->assign('navigatebar', $this->getNaviBar());
		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->assign('menu', $menustr);	
		$this->tpl->display('index.tpl.html');
	}

	public function personinfo()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		header('Content-Type:text/html;charset=UTF8');

		$personid = $_GET['personid'];

		$person      = $this->getModel('moperson')->getPersonById($personid);
		$accesslog   = $this->getModel('moperson')->getAccessLog($personid);
		$lifesection = $this->getModel('moperson')->getLifeSection($personid);

		$this->tpl->assign('today',date('Y-m-d'));
		$this->tpl->assign('accesslog',$accesslog);

		$person['age'] = intval(date('Y')) - intval($person['birthday']);
		$this->tpl->assign('person', $person);

		$this->tpl->assign('lifesection',$lifesection);

		// TODO: $months = date('Y-m') - $person['act']);=''acquaint_time
		$this->tpl->assign('navigatebar', $this->getNaviBar());

		$body = $this->tpl->fetch('pcrm_personinfo.tpl.html');
		$this->tpl->assign('body', $body);
		$this->tpl->display('index.tpl.html');

		return ;
	}

	public function addPerson()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		#parent::initDb(Core::getInstance()->getConfig('database'));
		#parent::initTemplateEngine(
        #            Core::getInstance()->getConfig('theme'),
        #            Core::getInstance()->getConfig('compiled_template')
		#);
		$this->init();

		$this->tpl->assign('navigatebar', $this->getNaviBar());

		$body = $this->tpl->fetch('pcrm_addperson.tpl.html');
		$this->tpl->assign('body', $body);
		$this->tpl->display('index.tpl.html');

		return ;
	}

	public function modifySource()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$personid = $_GET['personid'];

		$ret = $this->getModel('moperson')->getPersonSourceById($personid);

		$this->tpl->assign('personid', $personid);
		$this->tpl->assign('source', $ret);

		$this->tpl->assign('navigatebar', $this->tpl->fetch('navigatebar.tpl.html'));
		$body = $this->tpl->fetch('pcrm_source.tpl.html');
		$this->tpl->assign('body', $body);
		$this->tpl->display('index.tpl.html');

		return true;
	}

	public function updateSource()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$personid = $_POST['personid'];
		$id = $_POST['id'];
		$name = $this->getModel('moperson')->getPersonNameById($id);
		$type = $_POST['type'];
		$relationship = $_POST['relationship'];

		$this->getModel('moperson')->updateSource($personid, $id, $name, $type, $relationship);

		header("location:/pcrm/personinfo?personid=$personid");		
		return ;
	}

	public function editcomment()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$personid = $_GET['personid'];

		$ret = $this->getModel('moperson')->getPersonById($personid);
		$this->tpl->assign('person', $ret);

		$body = $this->tpl->fetch('pcrm_editcomment.tpl.html');
		$this->tpl->assign('navigatebar', $this->tpl->fetch('navigatebar.tpl.html'));
		$this->tpl->assign('body', $body);
		$this->tpl->display('index.tpl.html');

		return ;
	}

	public function updateComment()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));
		
		$personid = $_POST['personid']; 
		$comment  = $_POST['comment']; 

		$ret = $this->getModel('moperson')->updateComment($personid, $comment);

		header("location:/pcrm/personinfo/?personid=$personid");

		return false;
	}

	public function updateBasic()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));
		echo '<pre>';
		$personid = $_POST['personid']; 
		$name     = $_POST['name']; 
		$nickname = $_POST['nickname']; 
		$englishname = $_POST['english_name']; 
		$gender   = $_POST['gender'];
		$birthday = $_POST['birthday']; 
		$confirm_birthday  = $_POST['confirm_birthday']=='on'?1:0;
		$household_register= $_POST['household_register'];
		$idcard_type       = $_POST['idcard_type'];
		$idcard_no         = $_POST['idcard_no'];

		$mobile1  = $_POST['mobile1'];
		$mobile2  = $_POST['mobile2'];
		$mobile3  = $_POST['mobile3'];
		$email1   = $_POST['email1'];
		$email2   = $_POST['email2'];

		$hometown = $_POST['hometown']; 
		$nature   = $_POST['nature'];
		$attitude = $_POST['attitude'];

		$bank1    = $_POST['bank1'];
		$account1 = $_POST['account1'];
		$bank2    = $_POST['bank2'];
		$account2 = $_POST['account2'];
		$bank3    = $_POST['bank3'];
		$account3 = $_POST['account3'];

		$address  = $_POST['address'];
		$address_zipcode  = $_POST['address_zipcode'];
		$company  = $_POST['company'];
		$company_address = $_POST['company_address'];
		$company_zipcode = $_POST['company_zipcode'];
		$income   = $_POST['income'];
		$vocation = $_POST['vocation'];
		$department = $_POST['department'];
		$job      = $_POST['job'];
		$jobtitle = $_POST['job_title'];
		$residence= $_POST['residence'];
		$marital  = $_POST['marital'];
		$children = $_POST['children'];
		$acquaint_time = $_POST['acquaint_time'];
		$contact_degree = $_POST['contact_degree'];
		$meet_times = $_POST['meet_times'];
		$engagement_diffcult = $_POST['engagement_diffcult'];
		$recommend_ability = $_POST['recommend_ability'];

		// 获得旧的用户信息,用于实现用户状态更新记录
		if(isset($_POST['update_personalstatus']))
		{
			$oldperson   = $this->getModel('moperson')->getPersonById($personid);
		}

		$ret = $this->getModel('moperson')->updateBasic(
				$personid, $name, $nickname, $englishname, $gender, $birthday, $confirm_birthday, 
				$household_register,$idcard_type, $idcard_no, $mobile1,$mobile2, $mobile3,$email1,$email2,
				$hometown, $nature,$attitude,
				$bank1,$account1,$bank2,$account2,$bank3,$account3,
				$address, $address_zipcode,$company,$company_address,$company_zipcode,$income,
				$vocation,$department,$job, $jobtitle, $residence, $marital,$children,
				$acquaint_time,$contact_degree,$meet_times,$engagement_diffcult,$recommend_ability
		);

		if(isset($_POST['update_personalstatus']))
		{
			// TODO: 插入用户信息变化表,
		}

		if(!$ret)
		{
			echo $ret;
			die('no');
		}
		header("location:/pcrm/personinfo/?personid=$personid");

		return ;
	}

	public function getPersonId()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$personname = $_GET['personname'];

		$ret = $this->getModel('moperson')->getPersonIdByName($personname);

		echo $ret;

		return true;
	}

	public function getPersonNamesLike()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$personname = $_GET['like'];

		if($personname=='') 
		{
			echo json_encode(array());
		}

		$ret = $this->getModel('moperson')->getPersonNamesLike($personname);

		echo json_encode($ret);

		return true;		
	}

	public function editPersonalBasicInfo()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$personid = $_GET['id'];

		$ret = $this->getModel('moperson')->getPersonById($personid);

		$this->tpl->assign('person', $ret);
		$this->tpl->assign('navigatebar', $this->tpl->fetch('navigatebar.tpl.html'));
		$body = $this->tpl->fetch('pcrm_editbasic.tpl.html');
		$this->tpl->assign('body', $body);
		$this->tpl->display('index.tpl.html');

		return true;
	}

	public function doAddPerson()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));

		$username = $_POST['personname'];

		$ret = $this->getModel('moperson')->addNewPerson($username);

		if($ret)
		{
			header("location:/pcrm/modifySource/?personid=$ret");
		}

		return ;
	}

	public function thousandKill()
	{
		if(!$this->isLogined()) die();

		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);
		
		$ret  = $this->getModel('moperson')->getThousandKill();
		$total = count($ret);
		$this->tpl->assign('total',$total);
		$this->tpl->assign('owner', $this->getModel('moperson')->getOwner());
		$this->tpl->assign('personlist',$ret);
		$body = $this->tpl->fetch('pcrm_thousandkill.tpl.html');
		
		$menustr = "";
		$this->tpl->assign('navigatebar', $this->getNaviBar());
		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->assign('menu', $menustr);	
		$this->tpl->display('index.tpl.html');
	}

	public function updatelastcontact()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));

		$personid = $_GET['personid'];

		$date = isset($_GET['date'])?$_GET['date']:'today';
		$this->getModel('moperson')->updateLastContact($personid, $date);

		header('Content-Type:text/javascript');
		echo json_encode(array('ret'=>1));
	}

	public function updateCustomlevel()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));

		$personid = $_GET['personid'];
		$newlevel = $_GET['newlevel'];

		$ret = $this->getModel('moperson')->updateCustomLevel($personid,$newlevel);

		header('Content-Type:text/javascript');
		echo json_encode(array('ret'=>1));
	}

	public function addlifesection()
	{
		if(!$this->isLogined()) die();

		parent::initDb(Core::getInstance()->getConfig('database'));

		$personid = $_GET['personid'];
		$newlevel = $_GET['newlevel'];

		$ret = $this->getModel('moperson')->updateCustomLevel($personid,$newlevel);

		header('Content-Type:text/javascript');
		echo json_encode(array('ret'=>1));

	}
}

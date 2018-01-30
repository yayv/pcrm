<?php
include_once('commoncontroller.php');

class user extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		// TODO: 这里实现统计。按照所安装的插件进行统计和展示
		$this->init();
		
		// TODO: 要实现的插件包括:
		// TODO: 1. person
		// TODO: 2. company
		// TODO: 3. contactinfo
		// TODO: 4. personal info
		// TODO: 5. family ?
		// TODO: 6. seller's note
		// TODO: 7. insurance info
		

		// TODO: 请在下面实现您的默认action
		$body = file_get_contents('data/todo.txt');
		$body .= file_get_contents('data/history.txt');
		$body = strtr($body,array("\n"=>'<br/>',' '=>'&nbsp;'));
		
		$menu = $this->getModel('mmenu')->getMenu();
		$this->tpl->assign('menuarr', $menu);
		$menustr = $this->tpl->fetch('right.menu.tpl.html');
		
		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->assign('menu', $menustr);	
		$this->tpl->display('index.tpl.html');
	}


	public function login()
	{
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);
		
		$body = $this->tpl->fetch('user_login.tpl.html');	
		$this->tpl->assign('body', $body);

		$this->tpl->display('index.tpl.html');
	}

	public function dologin()
	{
		parent::initDb(Core::getInstance()->getConfig('database'));

		$user = $_POST['username'];
		$pass = $_POST['password'];

		$logined = $this->getModel('muser')->isValidateUser($user, $pass);

		if($logined)
		{
			print_r($logined);
			$_SESSION['userid']=1;
			$_SESSION['username'] = $user;
			unset($_SESSION['login_error']);
			header('location:/home/');

			return ;
		}
		else
		{
			$_SESSION['login_error'] = 'login failed';
			header('location:/user/login');
			return false;
		}
		
	}

	public function logout()
	{
		unset($_SESSION['userid']);

		header('location:/');
		return ;
	}	

}

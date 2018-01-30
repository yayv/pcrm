<?php
include_once('commoncontroller.php');

class defaultcontroller extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		// NOTE:如果此 action 不需要用到数据库或者模板引擎，请注释掉相应的代码，以提高速度
		parent::initDb(Core::getInstance()->getConfig('database'));
		parent::initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
		);

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$body = $this->tpl->fetch('default.tpl.html');
		$this->tpl->assign('body', $body);

		$this->tpl->display('index.tpl.html');
	}
}

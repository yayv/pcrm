<?php
include_once('commoncontroller.php');

class tags extends CommonController
{
	public function __construct()
	{
	}

	public function index()
	{
		if(!$this->isLogined()) die();

		$this->init();

		$tag = isset($_GET['params2'])?urldecode($_GET['params2']):'';

		$start = 0;
		$limit = 30;
		if($tag!='')
		{
			if($this->getModel('mtags')->isTag($tag))
			{
				$personids = $this->getModel('mtags')->getPersonsIdByTag($tag);
				if($personids)
					$ret = $this->getModel('mperson')->getPersonsByIds($personids, $start,$limit);
				else
					$ret = array();

				$this->tpl->assign('count',count($personids));
				$this->tpl->assign('tag',$tag);
				$this->tpl->assign('persons',$ret);
				$body = $this->tpl->fetch('tags_personbytag.tpl.html');				
			}
			else
				$body = "不存在标签:$tag";
		}
		else
		{
			$ret = $this->getModel('mtags')->getAllTags();
#http://install.local.lvren.cn/project/todo/name-PCRM
#http://liuce.love-u.localhost/tags
			$this->tpl->assign('tags',$ret);

			$body = $this->tpl->fetch('tags_index.tpl.html');
		}

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function notag()
	{
		if(!$this->isLogined()) die();

		$this->init();

		$this->getModel('mtags')->fillNotTagPerson();

		$personids = $this->getModel('mtags')->getPersonsWithoutTag($tag);

		if($personids)
			$ret = $this->getModel('mperson')->getPersonsByIds($personids, $start,$limit);
		else
			$ret = array();

		$this->tpl->assign('tag','无标签');
		$this->tpl->assign('count',count($personids));
		$this->tpl->assign('persons',$ret);
		$body = $this->tpl->fetch('tags_personbytag.tpl.html');				

		$navigatebar = $this->getNaviBar();
		$this->tpl->assign('navigatebar', $navigatebar);

		$this->tpl->assign('body', '<p>'.$body.'</p>');
		$this->tpl->display('index.tpl.html');
	}

	public function jetAllTags()
	{
		if(!$this->isLogined()) die();

		$this->init();

		$ret = $this->getModel('mtags')->getAllTags();

		header('Content-Type: text/javascript');

		echo json_encode(array('ret'=>1,'msg'=>'ok','data'=>$ret));
	}

	public function jupdate()
	{
		header('Content-Type:text/javascript');
		if(!$this->isLogined()) die(json_encode(array('ret'=>0,'msg'=>'not logined')));
		
		$this->init();

		$id = $_POST['id'];
		$strTags = $_POST['value'];
		$pos = strpos($strTags,',');
		if($pos===false)
			$arrTags = array($strTags);
		else
			$arrTags = explode(',',$strTags);

		$tags = $this->getModel('mtags')->formatTags($arrTags);

		$arrTags = array();
		$arrHtml = array();
		foreach($tags as $k=>$v)
		{
			$arrTags[]=$v['tagname']; 
			$arrHtml[]="<a href=''>".$v['tagname'].'</a>';
		}
		$strTags = implode(',',$arrTags);
		$strHtml = implode(',',$arrHtml);
		$this->getModel('mtags')->updateTagsForId($id,$strTags,$tags);

		echo json_encode(array(
					'ret'=>1,
					'msg'=>'ok',
					'html'=>$strHtml,
					'text'=>$strTags,
			));
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

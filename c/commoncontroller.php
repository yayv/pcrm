<?php

abstract class CommonController extends Controller {

    /**
     * 初始化数据库对象，考虑增加一层，用于实现用户的基类
     *
     */
    function initDb($dbsrv) {
        if ('mysql' == get_class($this->_db))
            return;

        include_once('cls.mysql.php');

        // override it , if you want own database object
        //assign the object for db,tpl
        /*
          $dbsrv['host']
          $dbsrv['port']
          $dbsrv['username']
          $dbsrv['password']
          $dbsrv['charset']
          $dbsrv['logfile']  default:$dbsrv['logfile']='php://output'
          $dbsrv['prefix']   table prefix
         */
        $this->_db = new mysql($dbsrv);
    }

    /**
     * 初始化模版引擎，提供用户覆盖此方法的机会
     *
     */
    function initTemplateEngine($templatedir = 'v/default/', $compile_dir = 'v/_run') {
        if ('Smarty' == get_class($this->tpl))
            return;

        include('smarty3/Smarty.class.php');

        $this->tpl = new Smarty;
        if ($templatedir)
            $this->tpl->template_dir = $templatedir;
        if ($compile_dir)
            $this->tpl->compile_dir = $compile_dir;

        // assign site title
        // page title
        $this->tpl->assign('title', core::getInstance()->getConfig('title'));

        $this->tpl->assign('home', Core::getInstance()->getConfig('baseurl'));
    }

    function initAssign() {
        // TODO: 这里可以实现整站的标准化赋值，比如网站title, 
    }

    public function init() {
        $this->initDb(Core::getInstance()->getConfig('database'));
        $this->initTemplateEngine(
                    Core::getInstance()->getConfig('theme'),
                    Core::getInstance()->getConfig('compiled_template')
        );

        $this->initAssign();
    }

    public function isLogined($locatetologin = true) {
        if (isset($_SESSION['userid']) && $_SESSION['userid'] != 0) {
            return true;
        }

        if ($locatetologin)
            header('location:/user/login');
        return false;
    }

    public function getNaviBar() {
        $navibar = '';
        if (isset($this->tpl)) {
            if (isset($_SESSION['username']))
                $this->tpl->assign('userid', $_SESSION['userid']);
                $this->tpl->assign('username', $_SESSION['username']);
            $navibar = $this->tpl->fetch('navigatebar.tpl.html');
        }

        $footer = $this->tpl->fetch('footer.tpl.html');
        $this->tpl->assign('footer', $footer);
        return $navibar;
    }

}


<?php
needRole('user');
class UserControl extends Control {

	public function __construct()
	{
		setTitle('会员中心 ,欢迎您:'.getRole('user'));
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function check(){
		$check = daocall('user','getUser',array($_POST['username']));
		if($check) echo 1;
		else echo 0;
		exit;
	}
	public function index(){
		session_start();
		$user = daocall('user','getUser',array(getRole('user')));
		$login_ip=$_SERVER['REMOTE_ADDR'];
		$this->_tpl->assign('login_ip',$login_ip);
		$this->_tpl->assign('user',$user);
		$this->pageNewsByNumber();
		return $this->_tpl->fetch('user/index.html');
	}
	public function left()
	{
		if($GLOBALS['frame']==1){
			$this->_tpl->assign('target','main');
		}else{
			$this->_tpl->assign('target','_self');
		}
		return $this->_tpl->fetch('user/left.html');
	}
	public function change()
	{
		$result = daocall('user','updateUser',array(getRole('user'),$_REQUEST['name'],$_REQUEST['email'],$_REQUEST['id']));
		return $this->index();
	}
	public function changeForm()
	{
		$user = daocall('user','getUser',array(getRole('user')));
		$this->_tpl->assign('user',$user);
		return $this->_tpl->fetch('user/changeForm.html');
	}

	private function pageNewsByNumber()
	{
		$page = 1;
		$page_count = 10;
		$count = 0;
		$news = daocall('news','pageNewsByNumber',array(10,$page,$page_count,&$count));
		$this->assign('news',$news);
	}

}
?>
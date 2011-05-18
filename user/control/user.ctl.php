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
		$user = daocall('user','getUser',array(getRole('user')));
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
	public function getNews()
	{
		$new=daocall('news','getNews',array($_REQUEST['id']));
		$this->assign('new',$new);
		return $this->fetch('user/list.html');	
	}
	private function pageNewsByNumber()
	{
		$page = 1;
		$page_count = 5;
		$count = 0;
		$news = daocall('news','pageNews',array(10,$page,$page_count,&$count));
		$this->assign('news',$news);
	}

}
?>
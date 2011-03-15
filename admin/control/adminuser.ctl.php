<?php
needRole('admin');
class AdminUserControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function add(){
		$this->_tpl->display('adminuser/useradd.html');
	}
	public function check(){
		$check = daocall('admin_user','getUser',array($_POST['username']));
		if($check) echo 1;
		else echo 0;
		exit;
	}
	public function listUser(){
		
		$list = daocall('admin_user','list_user',array());
		if($list){
			$this->_tpl->assign('sum',count($list));
			$this->_tpl->assign('list',$list);
			$this->_tpl->display('adminuser/userlist.html');
		}
		
	}
	public function insert(){
		$data = $_POST;
		$uid = apicall('admin_user','insertUser',array($data));
		if(!$uid){
			die('增加管理员失败');
		}
		header("Location: ?c=adminuser&a=listUser");
	}
	public function del(){
		$ret = daocall('admin_user','delUser',array($_REQUEST['username']));
		if($ret){
		}
		header("Location: ?c=adminuser&a=listUser");
		
	}
	public function info(){
		$arr = $_GET;
		$ret = daocall('admin_user','getUser',array($arr['username']));
		if($ret){
			$this->_tpl->assign('row',$ret);
			$this->_tpl->display('user/userinfo.html');
		}
		
	}
}
?>
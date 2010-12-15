<?php
class SessionControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function loginForm(){
		$this->_tpl->display('login.html');
	}
	public function login()
	{
		global $_REQUEST;
		$user = daocall('admin_user','getUser', array($_REQUEST['username']));
		if(!$user){
			die('登录错误');
		}
		if(strtolower($user["passwd"])!=strtolower(md5($_REQUEST['passwd']))){
			die('登录错误2');
		}
		$_SESSION['admin_user'] = $arr['username'];
		registerRole('admin');
		header("Location: index.php");
	}
	public function logout()
	{
		session_start();
		session_destroy();
		return $this->loginForm();
	}
}
?>
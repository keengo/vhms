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
		session_start();
		$user = daocall('user','getUser', array($_REQUEST['username']));
		if(!$user){
			die('登录错误');
		}
		if(strtolower($user["passwd"])!=strtolower(md5($_REQUEST['passwd']))){
			die('登录错误2');
		}
	//	$_SESSION['username'] = $user['username'];
		registerUser($user['username']);
		registerRole('user');
		header("Location: index.php");
	}
	public function logout()
	{
		session_start();
		unregisterRole('user');
		unregisterUser();
		$_SESSION['username']='';
		return $this->loginForm();
	}
}
?>
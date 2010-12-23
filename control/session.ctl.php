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
		//return $this->_tpl->fetch('login.html');
		header("Location: ?c=public&a=index");
		die();
	}
	public function login()
	{
		session_start();
		$user = $this->checkPassword($_REQUEST['username'], $_REQUEST['passwd']);
		if(!$user){
			//die('登录错误');
			return "登录错误";
		}
		registerRole('user',$user['username']);
		header("Location: index.php?c=user&a=index");
		die();
	}
	public function logout()
	{
		session_start();
		unregisterRole('user');
		return $this->loginForm();
	}
	public function changePasswordForm()
	{
		needRole('user');
		return $this->_tpl->fetch('session/changePassword.html');
	}
	public function changePassword()
	{
		needRole('user');
		if(!$this->checkPassword(getRole('user'), $_REQUEST['oldpasswd'])){
			return '旧密码不对!';
		}else{
			daocall('user', 'updatePassword', array(getRole('user'),$_REQUEST['passwd']));
			return '修改密码成功';
		}
		die();
	}
	public function left()
	{
		return dispatch('user','left');
	}
	private function checkPassword($username,$passwd)
	{
		$user = daocall('user','getUser', array($username));
		if(!$user){
			return false;
		}
		if(strtolower($user["passwd"])!=strtolower(md5($passwd))){
			return false;
		}
		return $user;
	}

}
?>
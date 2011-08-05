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
		if($GLOBALS['frame']==1){
			return $this->_tpl->fetch('session/login.html');
		}else{
			header("Location: ?c=public&a=index");
			die();
		}
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
		if($GLOBALS['frame']==1){
			header("Location: ?c=frame&a=index");
		}else{
			header("Location: ?c=user&a=index");
		}
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
			$this->_tpl->assign('msg','原密码不对!');	
		}else{
			daocall('user', 'updatePassword', array(getRole('user'),$_REQUEST['passwd']));
			$this->_tpl->assign('msg','修改密码成功');
		}
		return $this->_tpl->display('public/msg.html');
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
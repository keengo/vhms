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
	public function changePasswordForm()
	{
		needRole('admin');
		$this->_tpl->display('changePassword.html');
	}
	public function changePassword()
	{
		needRole('admin');
		if(!$this->checkPassword(getRole('admin'), $_REQUEST['oldpasswd'])){
			$this->_tpl->assign('msg','旧密码不对!');			
		}else{
			daocall('admin_user', 'updatePassword', array(getRole('admin'),$_REQUEST['passwd']));
			$this->_tpl->assign('msg','修改密码成功');
		}
		return $this->_tpl->display('msg.html');
	} 
	public function login()
	{
		global $_REQUEST;
		$user = $this->checkPassword($_REQUEST['username'],$_REQUEST['passwd']);
		if(!$user){
			die('登录错误');
		}
		registerRole('admin',$user['username']);
		header("Location: index.php");
	}
	public function logout()
	{
		session_start();
		session_destroy();
		return $this->loginForm();
	}
	private function checkPassword($username,$passwd)
	{
		$user = daocall('admin_user','getUser', array($username));
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
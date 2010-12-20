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
		$user = $this->checkPassword($_REQUEST['username'], $_REQUEST['passwd']);
		if(!$user){
			die('登录错误');
		}
		registerRole('vhost',$user['name']);
		header("Location: index.php");
	}
	public function logout()
	{
		session_start();
		unregisterRole('vhost');
		return $this->loginForm();
	}
	public function changePasswordForm()
	{
		needRole('vhost');
		$this->_tpl->display('changePassword.html');
	}
	public function changePassword()
	{
		needRole('vhost');
		if(!$this->checkPassword(getRole('vhost'), $_REQUEST['oldpasswd'])){
			$this->_tpl->assign('msg','旧密码不对!');
		}else{
			daocall('vhost', 'updatePassword', array(getRole('vhost'),$_REQUEST['passwd']));
			$this->_tpl->assign('msg','修改密码成功');
		}
		return $this->_tpl->display('msg.html');		
	} 
	private function checkPassword($username,$passwd)
	{
		$user = daocall('vhost','getVhost', array($username));
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
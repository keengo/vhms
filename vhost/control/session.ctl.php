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
		//return "没有登录";
	}
	public function sso()
	{
		$name = getRole('vhost');
		//echo "name=".$name;
		if($name){
			$sign = md5($name.$_REQUEST['r'].$GLOBALS['skey']);
			$url = $_REQUEST['url'];
			if(strchr($url,'?')){
				$url.='&';
			}else{
				$url.='?';
			}
			$url.='action=login&name='.$name."&s=".$sign;
			header("Location: ".$url);
			die();
		}
		die("no login");
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
		$vhost = getRole('vhost');
		$this->_tpl->assign('db_limit',$_SESSION['quota'][$vhost]['db_limit']);
		return $this->_tpl->fetch('changePassword.html');
	}
	public function changePassword()
	{
		needRole('vhost');
		if(apicall('vhost','changePassword',array(null,getRole('vhost'),$_REQUEST['passwd']))){
		//daocall('vhost', 'updatePassword', array(getRole('vhost'),$_REQUEST['passwd']));
			$this->_tpl->assign('msg','修改密码成功');		
		}else{
			$this->_tpl->assign('msg','修改密码失败');
			
		}
		return $this->_tpl->fetch('msg.html');				
	} 
	public function changeDbPassword()
	{
		needRole('vhost');	
		$vhost = getRole('vhost');
		$user = $_SESSION['user'][$vhost];
		if($_SESSION['quota'][$vhost]==0){
			$this->_tpl->assign('msg','该产品没有数据库');
		}else{
			$db = apicall('nodes','makeDbProduct',array($user['node']));
			if($db && $db->password($user['uid'],$_REQUEST['passwd'])){
				$this->_tpl->assign('msg','修改数据库密码成功!');				
			}else{
				$this->_tpl->assign('msg','修改数据库密码失败');
			}
		}			
		return $this->_tpl->fetch('msg.html');		
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
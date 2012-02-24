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
		//if(getRole('user')){
		//	header("Location: ?c=frame&a=index");
		//	die();
		//}
		//if($GLOBALS['frame']==1){
		return $this->_tpl->fetch('session/login.html');
	
	}
	public function login()
	{		
		$user=trim($_REQUEST['username']);
		if(UC_START=='on'){
			@include dirname(__FILE__).'/../../config.inc.php';
				
			if(UC_KEY=="" || UC_API=="")
			{
				exit("登陆失败，请检查uc配置文件config.inc.php");
			}
				
			include dirname(__FILE__).'/../../include/db_mysql.class.php';
			include dirname(__FILE__).'/../../uc_client/client.php';
				
			list($uid, $username, $password, $email) = uc_user_login($user, $_REQUEST['passwd']);
			if($uid > 0)
			{
				registerRole('user',$user);
				$_SESSION["uc_uid"]=$uid;
				header("Location: ?c=user&a=index&uc=1");
				die();
			
				//$ucsynlogin = uc_user_synlogin($uid);
				//$this->assign('ucsynclogin',$ucsynlogin);				
				//return dispatch('user','index');
				//return $this->_tpl->fetch('user/index.html');
			}else{
				header('Location: ?c=session&a=error');
				die();
			}
		}else{
			if(!$this->checkRight($user))
			{
				exit("用户名不符合标准");
			}
			$userinfo = $this->checkPassword($user, $_REQUEST['passwd']);
			if(!$userinfo){
				return $this->error();
			}
			registerRole('user',$userinfo['username']);
			if($GLOBALS['frame']==1){
				header("Location: ?c=frame&a=index");
				die();
			}else{
				header("Location: ?c=user&a=index");
				die();
			}
		}
	}
	public function error()
	{
		return $this->_tpl->fetch('public/error.html');
	}
	public function logout()
	{
		//退出uc_uid	
		//unset($_SESSION["uc_uid"]);
		if(UC_START && UC_START=='on'){
			@include dirname(__FILE__).'/../../config.inc.php';
			if(UC_KEY=="" || UC_API=="")
			{
				return  "登陆失败，请检查uc配置文件.";
			}
			include dirname(__FILE__).'/../../include/db_mysql.class.php';
			include dirname(__FILE__).'/../../uc_client/client.php';

			$user=getRole('user');
			$userinfo=daocall('user','getUser',array($user));
			
			unregisterRole('user');
			$ucsynlogout=uc_user_synlogout($userinfo['uid']);
			echo $ucsynlogout;

			return $this->loginForm();
		}
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
		return dispatch('public','left');
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
	private function checkRight($username)
	{
		return preg_match('/^[a-z0-9][a-z0-9_]{2,11}$/', $username);
	}

}
?>
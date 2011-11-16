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
		global $_SESSION;
		if(getRole('user')){
			header("Location: ?c=frame&a=index");
			die();
		}
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
		$user=trim($_REQUEST['username']);
		if(!$this->checkRight($user))
		{
			exit("用户名不符合标准");
		}
		$err='<div align="center"><br />';
		$err.='<div class="block tb_wid mar_top" align="center"> ';
		$err.="<p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>";
		$err.=' <h2><font color=red>登陆失败,<a href="/user/?c=session&a=loginForm">返回</a></font></h2';
		$err.='</div></div>';
		if(UC_START=='on'){
			
			include dirname(__FILE__).'/../../config.inc.php';
			
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
				$ucsynlogin = uc_user_synlogin($uid);
				$this->assign('ucsynclogin',$ucsynlogin);
				$this->assign('fc','user');
				$this->assign('fa','index');
				return $this->_tpl->fetch('frame/index.html');
			}else{
				exit($err);
			}
		}else{
			$userinfo = $this->checkPassword($user, $_REQUEST['passwd']);
			if(!$userinfo){
				exit($err);
			}
			registerRole('user',$userinfo['username']);
			if($GLOBALS['frame']==1){
				header("Location: ?c=frame&a=index");
			}
			if($_REQUEST['refer']=='web')
			{
				header("Location: /");
			}
			else{
				header("Location: ?c=user&a=index");
			}
			die();
		}
	}
	public function logout()
	{
		session_start();

		if(UC_START && UC_START=='on'){

			include dirname(__FILE__).'/../../config.inc.php';
			if(UC_KEY=="" || UC_API=="")
			{
				return  "登陆失败，请检查uc配置文件.";
			}
			include dirname(__FILE__).'/../../include/db_mysql.class.php';
			include dirname(__FILE__).'/../../uc_client/client.php';

			$user=getRole('user');
			$userinfo=daocall('user','getUser',array($user));

			unregisterRole('user');
			$ucsynlogout=uc_user_synlogout($userinfo['id']);
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
	private function checkRight($username)
	{
		return preg_match('/^[a-z0-9][a-z0-9_]{2,11}$/', $username);
	}

}
?>
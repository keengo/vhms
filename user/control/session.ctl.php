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
		$user1=trim($_REQUEST['username']);
		$user2=trim($user1,"+");
		$user=trim($user2,"=");
		$filename=dirname(__FILE__).'./../../config.php';
		if(!file_exists($filename)){
			exit("程序未安装");
		}
		include dirname(__FILE__).'./../../config.php';
		if(UC_START && UC_START==1){
			include dirname(__FILE__).'/../../config.inc.php';
			if(UC_KEY=="" || UC_API=="")
			{
				return  "登陆失败，请检查uc配置文件.";
			}
			include dirname(__FILE__).'/../../include/db_mysql.class.php';
			include dirname(__FILE__).'/../../uc_client/client.php';
			list($uid, $username, $password, $email) = uc_user_login($user, $_REQUEST['passwd']);
			setcookie('Example_auth', '', -86400);
			if($uid > 0)
			{
				//				$sql="SELECT count(*) FROM  ".UC_DBNAME.".{$tablepre}members WHERE uid='$uid'";
				//				$db=new dbstuff();
				//				$conn=$db->connect($dbhost, $dbuser, $dbpw);
				//				if(!$db->result_first($sql)) {
				//					//判断用户是否存在于用户表，不存在则跳转到激活页面
				//					$auth = rawurlencode(uc_authcode("$username\t".time(), 'ENCODE'));
				//					echo '您需要需要激活该帐号，才能进入本应用程序<br><a href="'.$_SERVER['PHP_SELF'].'?example=register&action=activation&auth='.$auth.'">继续</a>';
				//					exit;
				//				}
				registerRole('user',$user);
				$ucsynlogin = uc_user_synlogin($uid);
				echo $ucsynlogin;//echo 必需，用于ucenter的js返回数据
				return $this->_tpl->fetch('frame/index.html');
			}else{
				$str='<div align="center"><br />';
				$str.='<div class="block tb_wid mar_top" align="center"> ';
				$str.="<p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p><p>&nbsp</p>";
				$str.=' <h2><font color=red>登陆失败,<a href="/user/?c=session&a=loginForm">返回</a></font></h2';
				$str.='</div></div>';
				exit($str);
			}
		}

		$userinfo = $this->checkPassword($user, $_REQUEST['passwd']);
		if(!$userinfo){
			return "登录错误";
		}
		registerRole('user',$userinfo['username']);
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
		if($GLOBALS['uc'] && $GLOBALS['uc']=='on'){
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

}
?>
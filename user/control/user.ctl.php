<?php
needRole('user');
class UserControl extends Control {

	public function __construct()
	{
		setTitle('会员中心 ,欢迎您:'.getRole('user'));
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function check(){
		$check = daocall('user','getUser',array($_POST['username']));
		if($check) echo 1;
		else echo 0;
		exit;
	}
	public function index(){
		if($_REQUEST['uc']==1){
			@include dirname(__FILE__).'/../../config.inc.php';
			if(UC_KEY=="" || UC_API=="")
			{
				exit("登陆失败，请检查uc配置文件config.inc.php");
			}
			include dirname(__FILE__).'/../../include/db_mysql.class.php';
			include dirname(__FILE__).'/../../uc_client/client.php';
			if (isset($_SESSION['uc_uid'])) {
				$ucsynlogin = uc_user_synlogin($_SESSION['uc_uid']);
				$this->assign('ucsynclogin',$ucsynlogin);
				unset($_SESSION['uc_uid']);
			}
		}
		$user = daocall('user','getUser',array(getRole('user')));
		$agents = daocall('agent','selectList',array());
		foreach($agents as $agent){
			if($agent['id'] == $user['agent_id']) {
				$user['agent_name'] =$agent['name'];
			}
		}
		$login_ip=$_SERVER['REMOTE_ADDR'];
		$this->_tpl->assign('login_ip',$login_ip);
		$this->_tpl->assign('user',$user);
		//$this->pageNewsByNumber();
		return $this->_tpl->fetch('user/index.html');
	}
	public function left()
	{
		if($GLOBALS['frame']==1){
			$this->_tpl->assign('target','main');
		}else{
			$this->_tpl->assign('target','_self');
		}
		$mproductgroups = daocall('mproductgroup','getMproductgroup',array());
		if(is_array($mproductgroups)){
			foreach($mproductgroups as $mproductgroup) {
				$group[] = array($mproductgroup['name'],'?c=mproductorder&a=pageListMyMproductorder&refer='.$mproductgroup['id']); 
				
			}
			$this->_tpl->assign('group',$group);
		}
		return $this->_tpl->fetch('user/left.html');
	}
	public function change()
	{
		$result = daocall('user','updateUser',array(getRole('user'),$_REQUEST['name'],$_REQUEST['email'],$_REQUEST['id']));
		return $this->index();
	}
	public function changeForm()
	{
		$user = daocall('user','getUser',array(getRole('user')));
		$this->_tpl->assign('user',$user);
		return $this->_tpl->fetch('user/changeForm.html');
	}
	public function changePasswordForm()
	{
		needRole('user');
		return $this->_tpl->fetch('user/changePassword.html');
	}


	/**
	 * 更败密码
	 */
	public function changePassword()
	{
		if(!$this->checkPassword(getRole('user'), $_REQUEST['oldpasswd'])){
			$this->_tpl->assign('msg','原密码不对!');
		}else{
			daocall('user', 'updatePassword', array(getRole('user'),$_REQUEST['passwd']));
			$this->_tpl->assign('msg','修改密码成功');
		}
		return $this->_tpl->fetch('public/msg.html');
	}

	
	/**
	 * 验证登陆的账号和密码,name,passwd
	 * @param  $username
	 * @param  $passwd
	 */
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
	/**
	 * 公告列表
	 */
	private function pageNewsByNumber()
	{
		$page = 1;
		$page_count = 10;
		$count = 0;
		$news = daocall('news','pageNewsByNumber',array(10,$page,$page_count,&$count));
		$this->assign('news',$news);
	}

}
?>

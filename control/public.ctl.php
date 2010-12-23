<?php
class PublicControl extends  Control
{
	public function __construct()
	{
		setTitle('专业虚拟主机提供商');
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		return $this->_tpl->fetch('public/index.html');
	}
	public function foot()
	{
		return $this->_tpl->fetch('public/foot.html');
	}
	public function head()
	{
		$menus=array(
		array('首页','/'),
		array('虚拟主机','?c=public&a=vhost'),
		array('会员中心','?c=user&a=index')
		);
		$this->_tpl->assign("menus",$menus);
		return $this->_tpl->fetch("public/head.html");
	}
	public function register()
	{
		$result = daocall('user','newUser',array(
		$_REQUEST['username'],
		$_REQUEST['passwd'],
		$_REQUEST['email'],
		$_REQUEST['name'],
		$_REQUEST['id'])
		);
		if($result){
			registerRole('user',$_REQUEST['username']);
			header("Location: ?c=user&a=index");
			die();
		}else{
			return '注册失败';
		}
	}
	public function registerForm()
	{
		return $this->_tpl->fetch('public/register.html');
	}
	public function checkUser()
	{
		$username = $_REQUEST['username'];
		$result = daocall('user','checkUser',array($username));
		$this->_tpl->assign('param',$username);
		if($result){
			$this->_tpl->assign('result',1);
		}else{
			$this->_tpl->assign('result',0);
		}
		$this->_tpl->display('product/product_check_result.html');
		die();
	}
	public function left()
	{
		return "";
	}
}
?>
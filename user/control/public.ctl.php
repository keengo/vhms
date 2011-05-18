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
	public function readNews()
	{
		$new=daocall('news','getNews',array($_REQUEST['id']));
		$this->assign('new',$new);
		return $this->fetch('public/news.html');	
	}
	public function register()
	{
		$username = $_REQUEST['username'];
		if(!$this->checkRight($username)){
			return "用户名不符合标准";
		}
		$result = daocall('user','newUser',array(
		$_REQUEST['username'],
		$_REQUEST['passwd'],
		$_REQUEST['email'],
		$_REQUEST['name'],
		$_REQUEST['id'])
		);
		if($result){
			registerRole('user',$_REQUEST['username']);
			$external = $_REQUEST['external'];
			if ($external == '1') {
				$url = "?fc=user&fa=index";
			} else {
				$url = "?c=user&a=index";
			}
			header("Location: ".$url);
			die();
		}else{
			return '注册失败';
		}
	}
	public function registerForm()
	{
		return $this->_tpl->fetch('public/register.html');
	}
	public function ajaxCheckUser()
	{
		$username = $_REQUEST['username'];
		$result = false;
		if(!$this->checkRight($username)){
			$msg = "用户名不符合标准";
		}else{
			if(!daocall('user','checkUser',array($username))){
				$result = true;
			}else{
				$msg = "该用户已经被注册了";
			}
		}
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str .="<result ret='".$result."' msg='".$msg."'/>";
		die($str);
	}
	public function checkUser()
	{
		$username = $_REQUEST['username'];
		if(!$this->checkRight($username)){
			return "用户名不符合标准";
		}
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
	private function checkRight($username)
	{
		return preg_match('/^[a-z0-9][a-z0-9_]{2,11}$/', $username);	
	}
}
?>
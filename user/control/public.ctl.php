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
		$products=apicall('product','getProductList');
		$this->_tpl->assign('products',$products);
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
		$username = trim($_POST['username']);
		if(!$this->checkRight($username)){
			exit("用户名不符合标准");
		}
		if(UC_START && UC_START=='on'){
			
			include_once dirname(__FILE__).'/../../config.inc.php';
			if(UC_KEY=="" || UC_API=="")
			{
				return "注册失败，请检查ucenter配置文件.";
			}

			include_once dirname(__FILE__).'/../../uc_client/client.php';

			$passwd=trim($_REQUEST['passwd']);
			$email=$_REQUEST['email'];
			$uid = uc_user_register($username, $passwd, $email);
			if($uid <= 0) {
				if($uid==-6){
					exit('注册失败,email已注册');
				}
				elseif($uid==-5){
					exit('注册失败,Email 不允许注册');
				}
				elseif($uid==-4){
					exit('注册失败,Email 格式有误');
				}
				elseif($uid==-3){
					exit('注册失败,用户名已经存在');
				}
				elseif($uid==-2){
					exit('注册失败,包含不允许注册的词语');
				}
				elseif($uid==-1){
					exit('注册失败,用户名不合法');
				}
				exit('注册失败');
			} else {
				include_once  dirname(__FILE__).'/../../include/db_mysql.class.php';
				$db=new dbstuff();
				$conn=$db->connect(UC_DBHOST, UC_DBUSER, UC_DBPW);
				$password=null;
				$sql="INSERT INTO ".UC_DBNAME.".".$tablepre."common_member (`uid`,`email`,`username`,`password`)";
				$sql.=" VALUES ('$uid','$email','$username','$password')";
				@$db->query($sql);
				if($_REQUEST['at']==1){
					needRole('admin');
					return header("Location:  /admin/index.php?c=user&a=pageUsers");
				}
				//				registerRole('user',$username);
				//				$ucsynlogin = uc_user_synlogin($uid);
				//				echo $ucsynlogin;//echo 必需，用于ucenter的js返回数据
				//				$userinfo=daocall('user','getUser',array($username));
				//				$this->assign('user',$userinfo);
				//				return $this->display('user/index.html');
				exit('注册成功，<a href="?c=session&a=loginForm">返回登录</a>');
				die();
			}
		}
		$result = daocall('user','newUser',array($username,trim($_REQUEST['passwd']),$_REQUEST['email'],$_REQUEST['name'],$_REQUEST['ids']));
		if($result){
			registerRole('user',$username);
			$external = $_REQUEST['external'];
			if ($external == '1') {
				$url = "?fc=user&fa=index";
			} else {
				$url = "?c=user&a=index";
			}
			header("Location: ".$url);
			die();
		}else{
			exit('注册失败');
		}
	}
	public function registerForm()
	{
		if($_REQUEST['at']==1){
			$at=1;
		}else{
			$at=0;
		}
		$this->_tpl->assign('at',$at);
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
	public function ajaxGetProductList()
	{
		$products=apicall('product','getProducts');
		print_r($products);
		die();
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
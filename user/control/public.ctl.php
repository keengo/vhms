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

	public function contact()
	{
		return $this->_tpl->fetch('public/contact.html');

	}
	public function viewNewsById()
	{
		$id=intval($_REQUEST['id']);
		$new=apicall('news','getNewsById',array($id));
		$this->_tpl->assign('new',$new);
		return $this->_tpl->fetch('public/viewnews.html');		
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
		
		$vhost_name = $GLOBALS['setting_cfg']['vhost_name']['value'];
		if($vhost_name==""){
			$vhost_name="虚拟主机";
		}
		$menus=array(
			array('首页','/'),
			array($vhost_name,'?c=host&a=index')
		);
//		$mproduct_group = daocall('mproductgroup','getMproductgroup',array());
//		if(is_array($mproduct_group)){
//			foreach($mproduct_group as $mproduct) {
//				$menus[]=array($mproduct['name'],'?c=mproduct&a=index');
//			}
//		}
		$menus[]=array('会员中心','?c=user&a=index');
		$menus[]=array('联系我们','?c=public&a=contact');
		$menus[]=array('使用帮助','?c=help&a=index');
		if(UC_START=='on') {
			$menus[]=array('论坛','/bbs/');
		}
		$this->_tpl->assign("menus",$menus);
		$this->_tpl->assign('role',getRoles());
		return $this->_tpl->fetch("public/head.html");
	}
	public function pageListNews()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 12;
		$count = 0;
		$list = daocall('news','pageNews',array($page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('public/pagelistnews.html');
	}
	public function readNews()
	{
		$new=daocall('news','getNews',array($_REQUEST['id']));
		$this->assign('new',$new);
		return $this->fetch('public/news.html');
	}
	public function registerPact()
	{	
		return $this->fetch('public/pact.html');
	}
	public function register()
	{
		$username = trim($_POST['username']);
		if(!$this->checkRight($username)){
			exit("用户名不符合标准");
		}
		if(UC_START && UC_START=='on'){
				
			@include_once dirname(__FILE__).'/../../config.inc.php';
			$uctable = explode('.', UC_DBTABLEPRE);
			$tablepre = substr($uctable[1],0,-8);
			
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
					$this->_tpl->assign('msg','注册失败,email已注册');
				}
				elseif($uid==-5){
					$this->_tpl->assign('msg','注册失败,Email 不允许注册');
				}
				elseif($uid==-4){
					$this->_tpl->assign('msg','注册失败,Email 格式有误');
				}
				elseif($uid==-3){
					$this->_tpl->assign('msg','注册失败,用户名已经存在');
				}
				elseif($uid==-2){
					$this->_tpl->assign('msg','注册失败,包含不允许注册的词语');
				}
				elseif($uid==-1){
					$this->_tpl->assign('msg','注册失败,用户名不合法');
				}
				return $this->fetch('msg.html');
			} else {
				include_once  dirname(__FILE__).'/../../include/db_mysql.class.php';
				$db=new dbstuff();
				$conn=$db->connect(UC_DBHOST, UC_DBUSER, UC_DBPW);
				$password=md5($_REQUEST['passwd']);
				$sql="INSERT INTO ".UC_DBNAME.".".$tablepre."common_member (`uid`,`email`,`username`,`password`)";
				$sql.=" VALUES ('$uid','$email','$username','$password')";
				@$db->query($sql);
				//at 管理员还是user
				if($_REQUEST['at']==1){
					needRole('admin');
					return header("Location:  /admin/index.php?c=user&a=pageUsers");
				}
				$this->_tpl->assign('msg','注册成功');
				return $this->_tpl->fetch('msg.html');
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
		$at = $_REQUEST['at'] or 0;
		$this->_tpl->assign('at',$at);
		return $this->_tpl->fetch('public/register.html');
	}
	public function register_n()
	{
		return $this->_tpl->fetch('public/register_n.html');
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
		$news=apicall('news','getNewsList',array());
		$this->_tpl->assign('news',$news);
		return $this->fetch('public/left.html');
	}
	private function checkRight($username)
	{
		return preg_match('/^[a-z0-9][a-z0-9_]{2,11}$/', $username);
	}
}
?>
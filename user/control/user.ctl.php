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
	 * 查看订单信息
	 * where id
	 */
	public function showMproductorder()
	{
		$id = intval($_REQUEST['id']);
		if (!$id){
			trigger_error('失败:没有这个订单');
			return false;
		}
		$mproductorder = daocall('mproductorder','getMproductorder',array($id));
			
		$mproduct = daocall('mproduct','getMproductById',array($mproductorder['product_id']));
		$mproductorder['product_name'] = $mproduct['name'];
		
		$this->_tpl->assign('mproductorder',$mproductorder);
		return $this->_tpl->fetch('mproductorder/showmproductorder.html');

	}

	/**
	 * 非自动化产品业务申请页面
	 */
	public function addMproductorderFrom()
	{
		
		//得到产品ID
		$mproduct_id = $_REQUEST['mproduct_id'];
		//获取产品信息,得到价格
		$mproduct = daocall('mproduct','getMproductById',array($mproduct_id));
		$month_price = $mproduct['price']/12/100;
		$months = array(
						array('1','一个月'),
						array('12','一年'),
						array('24','二年'),
						
		);
		$months[0][2] = $month_price*$months[0][0];
		$months[1][2] = $month_price*$months[1][0];
		$months[2][2] = $month_price*$months[2][0];
	
		$this->_tpl->assign('product_name',$mproduct['name']);
		$this->_tpl->assign('id',$mproduct_id);
		$this->_tpl->assign('months',$months);
		return $this->_tpl->fetch('mproductorder/addfrom.html');
	}
	/**
	 * 非自动化产品业务创建函数
	 */
	public function addMproductorder()
	{
		$arr = $_REQUEST;
		$arr['username'] = getRole('user');
		if($_REQUEST['product_id']) {
			$mproductorder = daocall('mproductorder','getMproductorder',array(intval($_REQUEST['product_id'])));
			if($mproductorder['status']!=0) {
				$this->_tpl->assign('msg',"订单已完成");
				return $this->_tpl->fetch('msg.html');
			}
		}
		//获取产品名称
		$product_info = daocall('mproduct','getMproductById',array($_REQUEST['product_id']));
		//
		$product = apicall('product', 'newProduct',array('m'));
		
		if(!is_object($product)){
			trigger_error('没有该产品类型:m');
			return false;
		}
		$user = getRole('user');
		//传产品名称，用于写消费记录的购买名称识别
		$arr['name'] = $product_info['name'];
		
		if(!$product->sell($user,intval($_REQUEST['product_id']),$arr)){
			return false;
		}
		$this->_tpl->assign('msg','购买成功,请注意看相订单详情里的管理员回复信息');
		return $this->_tpl->fetch('public/msg.html');
	}
	/**
	 * 非自动化产品业务列表
	 */
	public function pageListMyMproductorder()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;

		//排序字段
		$order = $_REQUEST['order'] or 'id';

		//查询条件，传入数组
		$where['username'] = getRole('user');

		$mproducts = daocall('mproduct','getMproductById',array());

		$list = daocall('mproductorder','pageList',array($page,$page_count,&$count,$order,$where));
		if(is_array($mproducts)) {
			for($i=0;$i<count($list);$i++ ) {
				foreach($mproducts as $mproduct){
					if($list[$i]['product_id'] == $mproduct['id']){
						$list[$i]['product_name'] = $mproduct['name'];
					}

				}
			}
		}
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
	
		$this->_tpl->assign('order',$order);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('mproductorder/pagelistmproductorder.html');
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

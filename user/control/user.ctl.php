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
		session_start();
		
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
		$this->pageNewsByNumber();
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
		needRole('user');
		if(!$this->checkPassword(getRole('user'), $_REQUEST['oldpasswd'])){
			$this->_tpl->assign('msg','原密码不对!');
		}else{
			daocall('user', 'updatePassword', array(getRole('user'),$_REQUEST['passwd']));
			$this->_tpl->assign('msg','修改密码成功');
		}
		return $this->_tpl->fetch('public/msg.html');
	}
	/**
	 * 非自动化产品业务创建页面
	 */
	public function addMproductorderFrom()
	{
		if($_REQUEST['id']) {
			
			$mproductorder = daocall('mproductorder','getMproductorder',array(intval($_REQUEST['id'])));
			$this->_tpl->assign('mproductorder',$mproductorder);
			$this->_tpl->assign('edit',1);
		}
		$mproduct = daocall('mproduct','getMproductById',array());
		$this->_tpl->assign('mproduct',$mproduct);
		
//		$mproductgroup = daocall('mproductgroup','getMproductgroup',array());
//		$this->_tpl->assign('mproductgroup',$mproductgroup);
//		
		return $this->_tpl->fetch('mproductorder/addfrom.html');
	}
	/**
	 * 非自动化产品业务创建函数
	 */
	public function addMproductorder()
	{
		$result = daocall('mproductorder','add',array($_REQUEST));
		if (!$result) {
			$this->_tpl->assign('msg','申请订单失败，请联系管理员');
			return $this->_tpl->assign('msg.html');
		}
		return header('Location: /');
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
		$order = $_REQUEST['order'] or 'id';//排序字段
		$list = daocall('mproductorder','pageList',array($page,$page_count,&$count,$order,getRole('user')));
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
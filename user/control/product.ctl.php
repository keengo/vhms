<?php
class ProductControl extends Control {

	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function getUpgradePrice()
	{
		needRole('user');
		$name 	= $_REQUEST['name'];
		$id 	= $_REQUEST['id'];
		if (!$id || !$name) {
			die("查询升级价格出错");
		}
		$vhost_info = daocall('vhost','getVhost',array($name));
		$old_time = strtotime($vhost_info['expire_time']) - time();
		$month = number_format($old_time / 2592000,2);//当前空间还余多少个月时间
		$old_product = daocall('vhostproduct','getProduct',array($vhost_info['product_id']));
		$old_money =  ($old_product['price'] / 12) * $month;//当前空间余钱
		$new_product = daocall('vhostproduct','getProduct',array($id));
		$new_price = ($new_product['price'] / 12) * $month;//当前空间余的月分，在新产品中要多少钱
		$price = $new_price - $old_money;//新产品的钱减去当前余下的钱
		if ($price > 0 ) {
			die($price/100);
		}
		die("查询价格出错");
	}
	
	public function left()
	{
		if($GLOBALS['frame']==1){
			$this->_tpl->assign('target','main');
		}else{
			$this->_tpl->assign('target','_self');
		}
		return dispatch('user', 'left');
		//return $this->_tpl->fetch('user/left.html');
	}

	public function productList()
	{
		if($_REQUEST['target']==''){
			$_REQUEST['target'] = 'self';
		}
		$products = apicall('product','getProducts',null);
		$this->_tpl->assign('products',$products);
		$this->_tpl->assign('target',$_REQUEST['target']);
		$this->_tpl->display('product/product_list.js');
		die();
	}
	public function pageListProduct()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 30;
		$count = 0;
		$list = daocall('vhostproduct','pageListProduct',array($page,$page_count,$count,0,0));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('product/pageListProduct.html');
	}
	public function sellForm()
	{
		if(getRole('user')==""){
			header("Location: ?c=session&a=loginForm");
			die();
		}
		$product = explode('_',$_REQUEST['product']);
		$username = getRole('user');
		
		switch($product[0]){
			case 'vhost':
				$product_info = daocall('vhostproduct','getProduct',array($product[1]));
				if(!$product_info || intval($product_info['pause_flag'])!=0){
					return trigger_error('虚拟主机产品ID错误');
				}
				$userinfo = daocall('user','getUser',array($username));
				if($userinfo['agent_id'] > 0 ) {
					$arr['agent_id'] 	= $userinfo['agent_id'];
					$arr['product_type']= 0;
					$arr['product_id'] 	= $product[1];
					$agentinfo = daocall('agentprice','getAgentprice',array($arr));
					if ($agentinfo && $agentinfo[0]['price'] >0) {
						$product_info['price'] = $agentinfo[0]['price'];
					}
				}
				$try_day = daocall('setting','get',array('try_day'));
				if ($try_day <= 0 || $try_day == null) {
					$try_day = '3';
				}
				$this->_tpl->assign('try_day',$try_day);
				load_lib('pub:whm');
				
				$subtempletes = apicall('nodes','listSubTemplete',array($product_info['node'],$product_info['templete']));
				$this->_tpl->assign('subtempletes',$subtempletes);
				$this->_tpl->assign('product',$product_info);
				return $this->_tpl->fetch('vhostproduct/sell.html');
				break;
			default:
				return trigger_error('产品类型错误');
		}
	}
	/**
	 * 验证账号是否可以注册
	 * 查询数据库，和查询是否为保留账号apicall('vhost','check_vhost',array($name)
	 */
	public function check()
	{
		needRole('user');
		$product_type = $_REQUEST['product_type'];
		$name = $_REQUEST['name'];
		if($name=="")
		{
			$this->_tpl->assign('result',2);
			$this->_tpl->display('product/product_check_result.html');
			die();
		}
		$this->_tpl->assign('product_type',$product_type);
		$this->_tpl->assign('param',$name);
		switch($product_type){
			case 'vhost':
				$result = daocall('vhost', 'check',array($name));
		}
		/* 存在账号或者是保留账号,则返回1 */
		if($result || false===apicall('vhost','check_vhost',array($name))){
			$this->_tpl->assign('result',1);
		}else{
			$this->_tpl->assign('result',0);
		}
		$this->_tpl->display('product/product_check_result.html');
		die();
	}
	/**
	 * 空间创建接口
	 * 保留账号 root mysql www kangle $db_name
	 */
	public function sell()
	{
		needRole('user');
		
		if (strcasecmp($_REQUEST['product_type'],'vhost')==0) {
			global $db_cfg;
			$name = trim($_REQUEST['name']);
			if(false===apicall('vhost','check_vhost',array($name))){
				$this->_tpl->assign('msg','注册失败：保留账号,请选择其他账户名');
				return $this->_tpl->fetch('public/msg.html');
			}
		}
//		if(preg_match('/([\x81-\xfe][\x40-\xfe]){0,2}/',$name))
// 		{	
// 			$this->_tpl->assign('msg','注册失败：不支持中文账号');
//			return $this->_tpl->fetch('public/msg.html');
// 		}
		$product = apicall('product', 'newProduct',array($_REQUEST['product_type']));
		if(!is_object($product)){
			trigger_error('没有该产品类型:'.$_REQUEST['product_type']);
			return false;
		}
		$user = getRole('user');
		if(!$product->sell($user,intval($_REQUEST['product_id']),$_REQUEST)){
			return false;
		}
		$this->_tpl->assign('msg','购买成功');
		return $this->_tpl->fetch('public/msg.html');
	}
	public function renew()
	{
		needRole('user');
		$user = getRole('user');
		$product = apicall('product', 'newProduct',array($_REQUEST['product_type']));
		if(!is_object($product)){
			trigger_error('没有该产品类型:'.$_REQUEST['product_type']);
			return false;
		}
		if($product->renew($user,$_REQUEST['name'],intval($_REQUEST['month']))){
			$this->_tpl->assign('msg','续费成功');
		}else{
			$this->_tpl->assign('msg','续费失败');
		}
		return $this->_tpl->fetch('public/msg.html');
	}
	public function upgrade()
	{
		needRole('user');
		$user = getRole('user');
		$product = apicall('product', 'newProduct',array($_REQUEST['product_type']));
		if($product->upgrade($user,$_REQUEST['name'],$_REQUEST['product_id'])){
			$this->_tpl->assign('msg','升级成功');
		} else {
			$this->_tpl->assign('msg','升级失败.'.$GLOBALS["last_error"]);
		}
		return $this->_tpl->fetch('public/msg.html');
	}
}
?>
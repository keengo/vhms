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
	public function sellForm()
	{
		if(getRole('user')==""){
			return "您还没有登录，请先登录";
		}
		$product = explode('_',$_REQUEST['product']);
		switch($product[0]){
			case 'vhost':
				$product_info = daocall('vhostproduct','getProduct',array($product[1]));
				if(!$product_info || intval($product_info['pause_flag'])!=0){
					return trigger_error('虚拟主机产品ID错误');
				}
				$this->_tpl->assign('product',$product_info);
				return $this->_tpl->fetch('vhostproduct/sell.html');
				break;
			default:
				return trigger_error('产品类型错误');
		}
	}	
	public function check()
	{
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
		if($result){
			$this->_tpl->assign('result',1);
		}else{
			$this->_tpl->assign('result',0);
		}
		$this->_tpl->display('product/product_check_result.html');
		die();
	}
	public function sell()
	{
		needRole('user');
		if(strcasecmp($_REQUEST['name'],'root')==0)
		{
			$this->_tpl->assign('msg','注册失败：root为保留账号');
			return $this->_tpl->display('public/msg.html');
		}
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
		return $this->_tpl->display('public/msg.html');
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
		return $this->_tpl->display('public/msg.html');
	}
	public function upgrade()
	{
		needRole('user');
		$user = getRole('user');
		$product = apicall('product', 'newProduct',array($_REQUEST['product_type']));
		if($product->upgrade($user,$_REQUEST['name'],$_REQUEST['product_id'])){
			$this->_tpl->assign('msg','升级成功');
		} else {
			$this->_tpl->assign('msg','升级失败');
		}
		return $this->_tpl->fetch('public/msg.html');
	}
	public function left()
	{

	}
}
?>
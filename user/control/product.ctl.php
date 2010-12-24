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
				if(!$product_info || intval($product_info['state'])==0){
					return trigger_error('虚拟主机产品ID错误');
				}
				$this->_tpl->assign('product',$product_info);
				return $this->_tpl->fetch('vhostproduct/sell_vproduct.html');
				break;
			default:
				return trigger_error('产品类型错误');
		}

	}
	public function check()
	{
		$product_type = $_REQUEST['product_type'];
		$param = $_REQUEST['param'];
		$this->_tpl->assign('product_type',$product_type);
		$this->_tpl->assign('param',$param);
		switch($product_type){
			case 'vhost':
				$result = daocall('vhost', 'check',array($param));
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
		$product = apicall('product', 'newProduct',array($_REQUEST['product_type']));
		if(!is_object($product)){
			trigger_error('没有该产品类型:'.$_REQUEST['product_type']);
			return false;
		}
		if(!$product->checkParam(array($_REQUEST))){
			trigger_error('参数错误');
			return false;
		}
		$user = getRole('user');
		$param = $_REQUEST["param"];
		if($param==""){
			trigger_error('参数错误');
			return false;
		}
		if(!$product->sell($user,intval($_REQUEST['product_id']),intval($_REQUEST['month']),$param,$_REQUEST)){
			return false;
		}
		return "购买成功";
	}
	public function left()
	{

	}
}
?>
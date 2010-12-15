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
		$this->_tpl->display('product_list.js');
	}
	public function sellForm()
	{
		$product = explode('_',$_REQUEST['product']);		
		switch($product[0]){
			case 'vhost':
				$product_info = daocall('vhostproduct','getProduct',array($product[1]));
				if(!$product_info || intval($product_info['state'])==0){
					return trigger_error('虚拟主机产品ID错误');
				}
				$this->_tpl->assign('product',$product_info);
				$this->_tpl->display('sell_vproduct.html');
				break;
			default:
				return trigger_error('产品类型错误');
		}
		
	}
}
?>
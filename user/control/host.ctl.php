<?php
class HostControl extends Control
{
	public function index()
	{
		$products = apicall('product','getProductList');
		
		$this->_tpl->assign('products',$products);
		return $this->_tpl->fetch('host/index.html');
	}
	public function left()
	{
		$groups = daocall('productgroup','productgroupGetAll',array());
		if (count($groups) > 0) {
			$this->_tpl->assign('groups',$groups);
		}
		$products = daocall('vhostproduct','getProductList',array());
		$this->_tpl->assign('products',$products);
		return $this->_tpl->fetch('host/left.html');
	}
	public function showProductFrom()
	{
		$product_id = $_REQUEST['product_id'];
		$product_info = daocall('vhostproduct','getProduct',array($product_id));
		$this->_tpl->assign('product_info',$product_info);
		return $this->_tpl->fetch('host/showProductFrom.html');
	}



}
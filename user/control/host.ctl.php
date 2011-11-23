<?php
class HostControl extends Control
{
	public function index()
	{
		$products=apicall('product','getProductList');
		$this->_tpl->assign('products',$products);
		return $this->_tpl->fetch('host/index.html');
	}
	public function left()
	{
		$products = daocall('vhostproduct','getProductList',array());
		$this->_tpl->assign('products',$products);
		return $this->_tpl->fetch('host/left.html');
	}
	
	
	
}
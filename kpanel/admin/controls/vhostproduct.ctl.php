<?php
class VhostproductControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function refreshAllTemplete()
	{
		$list = daocall('nodes','getData',null);
		
	}
	public function refreshTemplete()
	{
		apicall('whm','refreshTemplete',array($_REQUEST['name']));
		$this->showTemplete();
	}
	public function showTemplete()
	{
		$list = daocall('vhosttemplete','getData',null);
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('vhostproduct/showTemplete.html');
	}
	public function showProduct()
	{
		$list = daocall('vhostproduct','getData',null);
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('vhostproduct/showProduct.html');
	}
	public function addProductForm()
	{
		$this->_tpl->assign("action","addProduct");
		$this->_tpl->display('vhostproduct/addProduct.html');
	}
	public function addProduct()
	{
		//die($_REQUEST);
		daocall('vhostproduct', 'insertData', array($_REQUEST));
		$this->showProduct();
	}
	public function del()
	{
		daocall('vhostproduct','delProduct',$_REQUEST["id"]);
		$this->showProduct();
	}
}
?>
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
	public function delTemplete()
	{
		daocall('vhosttemplete','del',array($_REQUEST['node'],$_REQUEST['templete']));
		$this->showTemplete();
	}
	public function showProduct()
	{
		$list = daocall('vhostproduct','getData',null);
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('vhostproduct/showProduct.html');
	}
	public function editProductForm()
	{
		$vhostproduct = daocall('vhostproduct','getProduct',array($_REQUEST['id']));
		if(!$vhostproduct){
			return trigger_error('不能找到该产品');
		}
		$this->_tpl->assign('vhostproduct',$vhostproduct);
		$this->_tpl->assign('action','editProduct');
		$templetes = daocall('vhosttemplete','getAllTemplete',null);
		if(!$templetes || count($templetes)<=0){
			trigger_error("没有可用的模板，请先刷新模板，必要时请增加主机");
		}
		$this->_tpl->assign("templetes",$templetes);
		$this->_tpl->display('vhostproduct/addProduct.html');
	}
	public function addProductForm()
	{
		$this->_tpl->assign("action","addProduct");
		$templetes = daocall('vhosttemplete','getAllTemplete',null);
		if(!$templetes || count($templetes)<=0){
			trigger_error("没有可用的模板，请先刷新模板，必要时请增加主机");
		}
		$this->_tpl->assign("templetes",$templetes);
		$this->_tpl->display('vhostproduct/addProduct.html');
	}
	public function editTempleteForm()
	{
		$templete = daocall('vhosttemplete','getTemplete',array($_REQUEST['node'],$_REQUEST['templete']));
		if(!$templete){
			trigger_error("指定主机上没有该模板");
			return;
		}
		$this->_tpl->assign("templete",$templete);
		$this->_tpl->display('vhostproduct/editTemplete.html');
	}
	public function editTemplete()
	{
		if(!daocall('vhosttemplete', 'updateNodeTempleteWeight', array($_REQUEST['node'],$_REQUEST['templete'],$_REQUEST['weight']))){
			trigger_error("更新出错");
			return;
		}
		return $this->showTemplete();
	}
	public function addProduct()
	{
		daocall('vhostproduct', 'insertData', array($_REQUEST));
		$this->showProduct();
	}
	public function editProduct()
	{
		daocall('vhostproduct', 'update', array($_REQUEST));
		$this->showProduct();
	}
	public function del()
	{
		daocall('vhostproduct','delProduct',$_REQUEST["id"]);
		$this->showProduct();
	}
}
?>
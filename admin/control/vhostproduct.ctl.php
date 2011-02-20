<?php
needRole('admin');
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
	public function ajaxListTemplete()
	{
		$templete = apicall('nodes','listTemplete',array($_REQUEST['node']));
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str .="<result node='".$_REQUEST['node']."'>";
		for($i=0;$i<count($templete);$i++){
			$str.="<templete>".$templete[$i]."</templete>";
		}
		$str.="</result>";
		return $str;		
	}
	public function showTemplete()
	{
		$list = daocall('vhosttemplete','getData',array());
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('vhostproduct/showTemplete.html');
	}
	public function showProduct()
	{
		$product_flag = $_REQUEST['product_flag'];
		$list = daocall('vhostproduct','getProducts',array($product_flag));
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->assign('product_flag',$product_flag);
		$this->_tpl->display('vhostproduct/showProduct.html');
	}

	protected function assignHosts()
	{
		$nodes = daocall('nodes','getAllNodes',null);
		if(!$nodes || count($nodes)<=0){
			trigger_error("没有可用的主机，请先增加主机");
			return false;
		}
		$this->_tpl->assign("nodes",$nodes);
		return true;
	}
	public function editProductForm()
	{
		$vhostproduct = daocall('vhostproduct','getProduct',array($_REQUEST['id']));
		if(!$vhostproduct){
			return trigger_error('不能找到该产品');
		}
		if(!$this->assignHosts()){
			return false;
		}
		$this->_tpl->assign('vhostproduct',$vhostproduct);
		$this->_tpl->assign('action','editProduct');
	
		$this->_tpl->display('vhostproduct/addProduct.html');
	}
	public function addProductForm()
	{
		$this->_tpl->assign("action","addProduct");
		if(!$this->assignHosts()){
			return false;
		}
		$this->_tpl->display('vhostproduct/addProduct.html');
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
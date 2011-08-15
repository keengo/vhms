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
	public function ajaxListSubTemplete()
	{
		$templete = apicall('nodes','listSubTemplete',array($_REQUEST['node'],$_REQUEST['templete']));
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str .="<result node='".$_REQUEST['node']."'>";
		for($i=0;$i<count($templete);$i++){
			$str.="<subtemplete>".$templete[$i]."</subtemplete>";
		}
		$str.="</result>";
		return $str;		
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
	public function ajaxChangeNode()
	{
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$id = $_REQUEST['id'];
		$node = $_REQUEST['node'];
		$templete = $_REQUEST['templete'];
		$templetes = apicall('nodes','listTemplete',array($node));
		$finded = false;
		for($i=0;$i<count($templetes);$i++){
			if($templetes[$i] == $templete){
				$finded = true;
				break;
			}	
		}
		if(!$finded){
			$str .="<result code='2'/>";
			return $str;
		}
		$result = daocall('vhostproduct','updateNode',array($id,$node));
		if($result){
			$str.="<result code='1'/>";
			apicall('product','flushVhostProduct');
		}else{
			$str.="<result code='0'/>";
		}
		daocall('product','flushVhostProduct');
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
		@load_conf('pub:node');
		if(is_array($GLOBALS['node_cfg'])){
			$this->_tpl->assign('nodes',array_keys($GLOBALS['node_cfg']));
		}
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
		$_REQUEST['price'] *= 100;
		$_REQUEST['speed_limit']*=1024;
		daocall('vhostproduct', 'insertData', array($_REQUEST));
		apicall('product','flushVhostProduct');
		$this->showProduct();
	}
	public function editProduct()
	{
		$_REQUEST['price'] *= 100;
		$_REQUEST['speed_limit'] *= 1024;
		daocall('vhostproduct', 'updateProduct', array($_REQUEST));
		apicall('product','flushVhostProduct');
		$this->showProduct();
	}
	public function del()
	{
		daocall('vhostproduct','delProduct',$_REQUEST["id"]);
		apicall('product','flushVhostProduct');
		$this->showProduct();
	}
	public function flush()
	{
		apicall('product','flushVhostProduct');
		$this->showProduct();
	}
}
?>
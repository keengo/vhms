<?php
needRole('user');
class VhostproductControl extends Control {
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}

	public function show()
	{
		$list = daocall('vhost','listMyVhost',array(getRole('user')));
		$this->_tpl->assign('sum',count($list));
	
		load_conf('pub:vhostproduct');
		//print_r($list);
		for($i=0;$i<count($list);$i++){
			$list[$i]['product_name'] = $GLOBALS['vhostproduct_cfg'][$list[$i]['product_id']]['name'];
		}
		//print_r($list);
		$this->_tpl->assign('list',$list);
		//$this->_tpl->assign('product',$GLOBALS['vhostproduct_cfg']);
		return $this->_tpl->fetch('vhostproduct/list.html');
	}
	public function impLogin()
	{
		$vhost = $_REQUEST['name'];
		$vhost_info = daocall('vhost','getVhost',array($vhost,array('username')));
		if($vhost_info && $vhost_info['username'] == getRole('user')){					
			registerRole('vhost',$vhost);
			header("Location: /vhost/");
			die();
		}else{
			//print_r($vhost_info);
			trigger_error('不是你的虚拟主机!或者找不到该虚拟主机');
		}
	}
	public function left()
	{
		return dispatch('user','left');
	}
	public function renewForm()
	{
		$vhost = $_REQUEST['name'];
		$vhost_info = daocall('vhost','getVhost',array($vhost,array('username','product_id')));
		if(!$vhost_info || $vhost_info['username'] != getRole('user')){
			trigger_error('没有找到该虚拟主机');
			return false;
		}
		$this->_tpl->assign("name",$vhost);
		$product = apicall('product','newProduct',array('vhost'));
		$product_info = $product->getInfo($vhost_info['product_id']);
		if($product_info){
			$this->_tpl->assign("product",$product_info);
		}
		return $this->_tpl->fetch('vhostproduct/renew.html');
	}
}
?>
<?php
class MproductControl extends Control
{
	
	public function left()
	{
		$mproducts = daocall('mproduct','getMproductById',array());
		$this->_tpl->assign('mproducts',$mproducts);
		return $this->_tpl->fetch('mproduct/left.html');
	}
	public function index()
	{
		
	}
	public function showMproductFrom()
	{
		$id = intval($_REQUEST['id']);
		$mproductinfo = daocall('mproduct','getMproductById',array($id));
		$this->_tpl->assign('mproductinfo',$mproductinfo);
		return $this->_tpl->fetch('mproduct/showmproduct.html');
	}
	

}
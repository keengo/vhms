<?php
class MproductControl extends Control
{
	
	public function left()
	{
		$refer = intval($_REQUEST['refer']) or null;
		$mproducts = daocall('mproduct','getMproductByGroupid',array($refer));
		$this->_tpl->assign('mproducts',$mproducts);
		return $this->_tpl->fetch('mproduct/left.html');
	}
	public function index()
	{
		$refer = $_REQUEST['refer'];
		$mproduct = daocall('mproduct','getMproductById',array($refer));
		$this->_tpl->assign('mproduct',$mproduct);
		return $this->_tpl->fetch('mproduct/index.html');
	}
	public function showMproductFrom()
	{
		$id = intval($_REQUEST['id']);
		$mproductinfo = daocall('mproduct','getMproductById',array($id));
		$this->_tpl->assign('mproductinfo',$mproductinfo);
		return $this->_tpl->fetch('mproduct/showmproduct.html');
	}

}
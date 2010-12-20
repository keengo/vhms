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
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('showVhostProduct.html');
	}
	public function impLogin()
	{
		registerRole('vhost',$_REQUEST['name']);
		header("Location: /vhost/");
	}
}
?>
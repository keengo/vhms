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
		return $this->_tpl->fetch('vhostproduct/showVhostProduct.html');
	}
	public function impLogin()
	{
		registerRole('vhost',$_REQUEST['name']);
		header("Location: /vhost/");
		die();
	}
	public function left()
	{
		return dispatch('user','left');
	}
}
?>
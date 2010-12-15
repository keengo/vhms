<?php
needRole('user');
class IndexControl extends Control
{
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		$this->_tpl->display('kpanel.html');
	}
	public function top()
	{
		$this->_tpl->display('top.html');
	}
	public function left()
	{
		$this->_tpl->display('left.html');
	}
	public function main()
	{
		$user = daocall('user','getUser',array(getUser()));
		$this->_tpl->assign('user',$user);
		$this->_tpl->display('kfinfo.html');
	}
}
?>
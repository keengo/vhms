<?php
needRole('vhost');
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
		public function controltop()
	{
		$this->_tpl->display('controltop.html');
	}
		public function controlleft()
	{
		$this->_tpl->display('controlleft.html');
	}
	public function main()
	{
		$user = daocall('vhost','getVhost',array(getRole('vhost')));
		$this->_tpl->assign('user',$user);
		$this->_tpl->display('kfinfo.html');
	}
}
?>
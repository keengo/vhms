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
		return $this->_tpl->fetch('top.html');
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
		if($user){
			$quota = apicall('vhost','getQuota',array(getRole('vhost'),$user['uid'],$user['node'],$user['product_id']));
			if($quota){
				$this->_tpl->assign('quota',$quota);
			}
		}
		$this->_tpl->assign('user',$user);
		return $this->_tpl->fetch('kfinfo.html');
	}
}
?>
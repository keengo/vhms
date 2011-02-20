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
		$vhost = getRole('vhost');
		$node = apicall('vhost','getNode',array($vhost));
		if($node){
			$node_info = apicall('nodes','getInfo',array($node));
			$url = "http://".$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF]."?c=session&a=sso";
			$webftp_url = "http://".$node_info['host'].":3312/webftp/sso.php?action=hello&url=".urlencode($url);
			$this->_tpl->assign('webftp_url',$webftp_url);			
		}else{
			trigger_error('没有找到在线文件管理URL');
		}		
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
			$node_info = apicall('nodes','getInfo',array($user['node']));
			if($node_info){
				$this->_tpl->assign('node_host',$node_info['host']);
			}
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
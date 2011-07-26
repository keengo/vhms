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
		$user = $_SESSION['user'][$vhost];
		$node = $user['node'];
		$hasEnv = apicall('tplenv','hasEnv',array($user['templete'],$user['subtemplete']));
		$this->_tpl->assign('hasEnv',$hasEnv);
		if($node){
			$node_info = apicall('nodes','getInfo',array($node));
			$url = "http://".$_SERVER[HTTP_HOST].$_SERVER[PHP_SELF]."?c=session&a=sso";
			$webftp_url = "http://".$node_info['host'].":3312/vhost/?c=index&a=webftp&url=".urlencode($url);
			//$webftp_url = "http://".$node_info['host'].":3312/vhost/?c=index&a=webftp&url=".urlencode($url);
			$this->_tpl->assign('webftp_url',$webftp_url);	
			$quota = $_SESSION['quota'][$vhost];
			//print_r($quota);
			if($quota['db_limit']>0){
				$dbadmin_url = "http://".$node_info['host'].":3313/".$node_info['db_type']."/?uid=".$_SESSION['user'][$vhost]['uid'];
				
				$this->_tpl->assign('dbadmin_url',$dbadmin_url);
			}		
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
		$vhost = getRole('vhost');
		$user = daocall('vhost','getVhost',array($vhost));
		if($user){
			$_SESSION['user'][$vhost] = $user;
			$node_info = apicall('nodes','getInfo',array($user['node']));
			if($node_info){
				$this->_tpl->assign('node_host',$node_info['host']);
			}
			$product_info = apicall('product','getVhostProduct',array($user['product_id']));
			$this->_tpl->assign("product",$product_info);
			$user['product_name'] = $product_info['name'];
			$quota = apicall('vhost','getQuota',array(getRole('vhost'),$user['uid'],$user['node'],$user['product_id']));
			if($quota){
				$_SESSION['quota'][$vhost] = $quota;
				$this->_tpl->assign('quota',$quota);
			}
			$subtempletes = apicall('nodes','listSubTemplete',array($user['node'],$user['templete']));
			$this->_tpl->assign('subtempletes',$subtempletes);
		}
		$this->_tpl->assign('user',$user);
		return $this->_tpl->fetch('kfinfo.html');
	}
	public function changeSubtemplete()
	{
		//echo $_REQUEST['subtemplete'];
		$vhost = getRole('vhost');
		apicall('vhost','changeSubtemplete',array(null,$vhost,$_REQUEST['subtemplete']));
		//daocall('vhost','updateVhost',array($vhost,$arr));
		//$node = apicall('vhost','getNode',array($vhost));
		//apicall('vhost','noticeChange',array($node,$vhost));
		return $this->main();
	}
}
?>
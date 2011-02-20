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
		$vhost = $_REQUEST['name'];
		$vhost_info = daocall('vhost','getVhost',array($vhost,array('username')));
		if($vhost_info && $vhost_info['username'] == getRole('user')){					
			registerRole('vhost',$vhost);
			header("Location: /vhost/");
			die();
		}else{
			print_r($vhost_info);
			trigger_error('不是你的虚拟主机!或者找不到该虚拟主机');
		}
	}
	public function left()
	{
		return dispatch('user','left');
	}
}
?>
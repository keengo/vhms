<?php
needRole('vhost');
class WebappControl extends Control
{
	public function index()
	{
		$list = daocall('vhostwebapp','getAll',array(getRole('vhost')));
		$sum = count($list);
		$this->_tpl->assign('sum',$sum);
		$this->_tpl->assign('list',$list);		
		return $this->_tpl->fetch('webapp/show.html');
	}
	public function browse()
	{
		return $this->install();
	}
	public function install()
	{
		$step = intval($_REQUEST['step']);
	
		if($step==0){
			$this->_tpl->assign('appid','KKK1.zip');
			$this->_tpl->assign('appname','phpwind');
			$this->_tpl->assign('appver','8.5');
			if($GLOBALS['free_domain']!=""){
				$this->_tpl->assign('free_domain',getRole('vhost').'.'.$GLOBALS['free_domain']);
			}	
			$domain = daocall('vhostinfo', 'getDomain', array(getRole('vhost')));
			return $this->_tpl->fetch('webapp/step0.html');
		}
	}
	public function uninstall()
	{
		
	}
}
?>
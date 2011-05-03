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
}
?>
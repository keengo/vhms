<?php
needRole('vhost');
class DomainControl extends Control
{
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
		$list = daocall('domain', 'getDomain', array(getRole('vhost')));
		$sum = count($list);
		$this->_tpl->assign('sum',$sum);
		$this->_tpl->assign('list',$list);		
		$this->_tpl->display('domain/show.html');
	}
	public function addForm()
	{
		$this->_tpl->assign('action','add');
		$this->_tpl->display('domain/add.html');
	}
	public function add()
	{
		$ret = daocall('domain','findDomain',array($_REQUEST['domain']));
		if($ret){
			die('该域名已被绑定，请联系管理员');
		}
		$attr['name'] = getRole('vhost');
		$attr['domain'] = $_REQUEST['domain'];
		$attr['dir'] = '/';
		daocall('domain','insertData',array($attr));
		$this->show();
	}
	public function del()
	{
		daocall('domain', 'delDomain', array(getRole('vhost'),$_REQUEST['domain']));
		$this->show();
	}
}
?>
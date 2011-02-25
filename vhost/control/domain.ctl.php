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
		$list = daocall('vhostinfo', 'getDomain', array(getRole('vhost')));
		$sum = count($list);
		$this->_tpl->assign('sum',$sum);
		$this->_tpl->assign('list',$list);		
		return $this->_tpl->fetch('domain/show.html');
	}
	public function addForm()
	{
		$this->_tpl->assign('action','add');
		return $this->_tpl->fetch('domain/add.html');
	}
	public function add()
	{
		$ret = daocall('vhostinfo','findDomain',array($_REQUEST['domain']));
		if($ret){
			return '该域名已被绑定，请联系管理员';
		}
		$attr['user'] = getRole('vhost');		
		$attr['name'] = $_REQUEST['domain'];
		load_conf('pub:reserv_domain');
		if(is_array($GLOBALS['reserv_domain'])){
			for($i=0;$i<count($GLOBALS['reserv_domain']);$i++){
				if(strcasecmp($attr['name'],$GLOBALS['reserv_domain'][$i])==0){
					return "该域名为保留域名!";
				}
			}
		}
		if(!preg_match('/^[a-z0-9_*.]{2,32}$/i', $attr['name'])){
			return '域名不合法';			
		}
		$attr['type'] = 0;
		$attr['value'] = '/';
		daocall('vhostinfo','insertData',array($attr));
		$this->noticeChange();
		return $this->show();
	}
	public function del()
	{
		daocall('vhostinfo', 'delDomain', array(getRole('vhost'),$_REQUEST['domain']));
		$this->noticeChange();
		return $this->show();
	}
	private function noticeChange()
	{
		$vhost = getRole('vhost');
		$node = apicall('vhost','getNode',array($vhost));
		return apicall('vhost','noticeChange',array($node,$vhost));
	}
}
?>
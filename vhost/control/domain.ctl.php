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
		$vhost = getRole('vhost');
		$this->_tpl->assign('action','add');
		$product = apicall('product','newProduct',array('vhost'));
		$info = $product->getInfo($_SESSION['user'][$vhost]['product_id']);
		//print_r($info);
		$this->_tpl->assign('subdir_flag',$info['subdir_flag']);
		$this->_tpl->assign('default_subdir',$info['subdir']);
		return $this->_tpl->fetch('domain/add.html');
	}
	public function add()
	{
		$ret = daocall('vhostinfo','findDomain',array($_REQUEST['domain']));
		if($ret){
			return '该域名已被绑定，请联系管理员';
		}
		$vhost = getRole('vhost');
		@load_conf('pub:reserv_domain');
		$name = $_REQUEST['domain'];
		if(is_array($GLOBALS['reserv_domain'])){
			for($i=0;$i<count($GLOBALS['reserv_domain']);$i++){
				if(strcasecmp($attr['name'],$GLOBALS['reserv_domain'][$i])==0){
					return "该域名为保留域名!";
				}
			}
		}
		if(!preg_match('/^[a-z0-9_*.]{2,32}$/i', $name)){
			return '域名不合法';			
		}
		$product = apicall('product','newProduct',array('vhost'));
		$info = $product->getInfo($_SESSION['user'][$vhost]['product_id']);
		if($info['subdir_flag']==1){
			$value = $_REQUEST['subdir'];
		}else{
			$value = $info['subdir'];
		}
		if(!apicall('vhost','addInfo',array($vhost,$name,0,$value))){
			trigger_error('绑定域名失败');
		}
		return $this->show();
	}
	public function del()
	{
		if(!apicall('vhost','delInfo',array(getRole('vhost'),$_REQUEST['domain'],0,null))){
			trigger_error('删除域名失败');
		}
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
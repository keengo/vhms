<?php
needRole('admin');
class NodesControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function listNode(){
		$username = $_GET['username'];
		$list = daocall('nodes',"listNodes",null);
		$sum = count($list);

		$this->_tpl->assign('sum',$sum);
		$this->_tpl->assign('username',$username);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('nodes/listnode.html');
	}
	public function addNode(){
		$this->_tpl->assign('action','insert');
		$this->_tpl->display('nodes/addnode.html');
	}
	public function editForm(){
		$node = daocall('nodes','getNode',array($_REQUEST['name']));
		if(!$node){
			die("no such node");
		}
		$this->_tpl->assign('action','edit');
		$this->_tpl->assign('node',$node);
		$this->_tpl->display('nodes/addnode.html');
	}
	public function edit(){
		daocall('nodes','updateNode', array($_REQUEST["name"],$_REQUEST));
		header("Location: ?c=nodes&a=listNode");
	}
	public function del()
	{
		daocall("nodes","del",array($_REQUEST["name"]));
		header("Location: ?c=nodes&a=listNode");
	}
	public function check(){
	}
	public function insert(){
		$data = array(
			'name'=>$_REQUEST['name'],
			'host'=> $_REQUEST['host'],
			'port'=>intval($_REQUEST['port']),
			'user'=>$_REQUEST['user'],
			'passwd'=>$_REQUEST['passwd']);
		$ret = daocall("nodes","insertNode",array($data));
		if($ret !== false ){
			header("Location: ?c=nodes&a=listNode");
		}
	}
	public function init()
	{
		
	}
}
?>
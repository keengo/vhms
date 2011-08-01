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
	public function ajaxCheckNode()
	{
		$node = $_REQUEST['node'];
		$result = apicall('nodes','checkNode',array($_REQUEST['node']));
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str .="<result node='".$_REQUEST['node']."' whm='";
		$str.=$result['whm'];
		$str.="' db='".$result['db']."'/>";
		return $str;
	}
	public function checkNodes()
	{
		$node_status = apicall('nodes','checkNodes');
		$this->_tpl->assign('node_status',$node_status);
		return $this->listNode();
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
	public function initForm(){
		$this->_tpl->assign('name',$_REQUEST['name']);
		$this->_tpl->display('nodes/init.html');
	}
	public function edit(){

		$arr['host'] = $_REQUEST['host'];
		$arr['port'] = $_REQUEST['port'];
		$arr['user'] = $_REQUEST['user'];
		$arr['db_user'] = $_REQUEST['db_user'];
		$arr['dev'] = $_REQUEST['dev'];
		if($_REQUEST['passwd']!=""){
			$arr['passwd'] = $_REQUEST['passwd'];				
			$os = $this->getOs();
			if(!$os){
				return false;
			}			
			$arr['win'] = (strcasecmp($os, 'windows')==0?1:0);
		}
		if($_REQUEST['db_passwd']!=""){
			$arr['db_passwd'] = $_REQUEST['db_passwd'];
		}
		daocall('nodes','updateNode', array($_REQUEST["name"],$arr));
		$this->flush();
	}
	public function del()
	{
		daocall("nodes","del",array($_REQUEST["name"]));
		$this->flush();
		//header("Location: ?c=nodes&a=listNode");
	}
	public function check(){
	}
	public function insert(){
//		$os = $this->getOs();
//		if(!$os){
//			return false;
//		}
		$data = array(
			'name'=>$_REQUEST['name'],
			'host'=> $_REQUEST['host'],
			'port'=>intval($_REQUEST['port']),
			'user'=>$_REQUEST['user'],
			'passwd'=>$_REQUEST['passwd'],
			'db_type'=>'mysql',
			'db_user'=>$_REQUEST['db_user'],
			'db_passwd'=>$_REQUEST['db_passwd'],
			'win'=>(strcasecmp($os, 'windows')==0?1:0),
			'dev'=>$_REQUEST['dev']
		);
		$ret = daocall("nodes","insertNode",array($data));
		if($ret !== false ){
			//	header("Location: ?c=nodes&a=listNode");
		}
		$this->flush();
	}
	public function init()
	{
		if(apicall('nodes','init',array(
		$_REQUEST['name'],
		$_REQUEST['config_flag'],
		$_REQUEST['init_flag'],
		$_REQUEST['reboot_flag']
		))){
			$this->_tpl->assign('msg','初始化成功');
		}else{
			$this->_tpl->assign('msg','初始化失败');
		}
		return $this->listNode();
	}
	public function flush()
	{
		$result = apicall('nodes','flush');
		if($result){
			$this->_tpl->assign('msg','更新配置文件成功');
		}else{
			$this->_tpl->assign('msg','更新配置文件失败');
		}
		return $this->listNode();
	}
	public function getOs()
	{
		$whm = apicall('nodes','makeWhm2',array($_REQUEST['host'],$_REQUEST['port'],$_REQUEST['user'],$_REQUEST['passwd']));
		$whmCall = new WhmCall('info');
		$result = $whm->call($whmCall);
		if(!$result){
			trigger_error("call whm info failed");
			return false;
		}
		return $result->get("os");
	}
}
?>
<?php
needRole('admin');
class UserControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function editForm()
	{
		$user = daocall('user', 'getUser', array($_REQUEST['username']));
		if(!$user){
			return trigger_error("找不到该用户");
		}
		$this->_tpl->assign('user',$user);
		$this->_tpl->display('user/useredit.html');
	}
	public function editMoneyForm()
	{
		$user = daocall('user', 'getUser', array($_REQUEST['username']));
		if(!$user){
			return trigger_error("找不到该用户");
		}
		$this->_tpl->assign('user',$user);
		$this->_tpl->display('user/moneyedit.html');
	}
	public function add(){
		$this->_tpl->display('user/useradd.html');
	}
	public function edit()
	{
		$arr = array();
		$passwd = $_REQUEST["passwd"];
		if($passwd!=""){
			$arr['passwd'] = $passwd;
		}
		$arr['name'] = $_REQUEST['name'];
		$arr['id'] = $_REQUEST['id'];
		$arr['email'] = $_REQUEST['email'];
		daocall('user','updateUser',array($_REQUEST['username'],$arr));
		return $this->listUser();
	}
	public function editMoney()
	{
		$money = intval($_REQUEST['money']);
		if($money>0){
			daocall('user','addMoney', array($_REQUEST['username'],abs($money)));
		}else{
			daocall('user','decMoney', array($_REQUEST['username'],abs($money)));
		}
		$this->listUser();
	}
	public function check(){
		$check = daocall('user','getUser',array($_POST['username']));
		if($check) echo 1;
		else echo 0;
		exit;
	}
	public function insert(){
		$data = $_POST;
		//$data['homedir'] = $this->getHomedir($data['username']);
		$data['passwd'] = md5($data['passwd']);
		$data['regtime'] = "now()";
		$uid = apicall('user','insertUser',array($data));
		header("Location: ?c=user&a=listUser");
	}
	public function delete(){
		$arr = $_GET;
		$ret = daocall('user','delUser',array($arr['username']));
		if($ret){
			if($retval == 0){
				header("Location: ?c=user&a=listUser");
			}
			echo 'del whm host and bak host';
		}		
	}
	public function info(){
		$arr = $_GET;
		$ret = daocall('user','getUser',array($arr['username']));
		if($ret){
			$this->_tpl->assign('row',$ret);
			$this->_tpl->display('user/userinfo.html');
		}
		
	}
	public function getHomedir($username){
		$homedir = "/home/ftp/".$username[0]."/".$username[1]."/".$username[2]."/".$username;
		return $homedir;
	}
	public function listUser(){
		$list = daocall('user','listUser',array($_REQUEST['username']));
		//if($list){
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('user/userlist.html');
		//}

	}
	public function impLogin()
	{
		registerRole('user',$_REQUEST['username']);
		header("Location: /user/");
	}
}
?>
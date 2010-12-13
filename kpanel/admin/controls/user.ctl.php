<?php
class UserControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function add(){
		$this->_tpl->display('user/useradd.html');
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
		$list = daocall('user','listUser',array());
		if($list){
			$this->_tpl->assign('sum',count($list));
			$this->_tpl->assign('list',$list);
			$this->_tpl->display('user/userlist.html');
		}

	}
	public function docRoot2subDir($username,$doc_root){
		$ret = daocall("user","getUser",array($username));
		$sub_dir = str_replace($this->getHomedir($username),'',$doc_root);
		return $sub_dir;
	}
	public function subDir2docRoot($username,$sub_dir){
		$doc_root = $this->getHomedir($username)."/".$sub_dir;
		return $doc_root;
	}
}
?>
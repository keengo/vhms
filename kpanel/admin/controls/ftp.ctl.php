<?php
class FtpControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function addFtp(){
		$data['username'] = $_GET['username'];
		$this->_tpl->assign('username',$data['username']);
		$this->_tpl->display('user/ftpadd.html');
	}
	public function check(){
		$check = daocall('ftp','getFtp',array($_POST['ftpname']));
		if($check) echo 1;
		else echo 0;
		exit;
	}
	public function insert(){
		$data = $_POST;
		$data['username'] = $_GET['username'];
		$u = daocall('user','getUser',array($data['username']));
		$data['uid'] = $u['uid'];
		$data['gid'] = $u['gid'];
		$data['homedir'] = $u['homedir']."/".$data['homedir'];
		$data['ftppasswd'] = $data['ftppasswd'];
		$data['accessed'] = date("Y-m-d H:i:s");
		$ret = daocall('ftp','insertFtp',array($data));
		if($ret !== false ){
			header("Location: /?c=ftp&a=getFtp&ftpname=".$data['ftpname']);
		}else{
			echo 'insert ftpuser error';
		}
	}
	public function editFtp(){

		$data['username'] = $_GET['username'];
		$this->_tpl->assign('username',$data['username']);
		$this->_tpl->display('user/ftpadd.html');
		
	}
	public function delFtp(){
		$arr = $_GET;
		$ret = daocall('ftp','delFtp',array($arr['ftpname']));
		if($ret){
		
		}
		
	}
	public function getFtp(){
		$arr = $_GET;
		$ret = daocall('ftp','getFtp',array($arr['ftpname']));
		if($ret){
			$this->_tpl->assign('row',$ret);
			$this->_tpl->display('user/ftpinfo.html');
		}
		
	}
	public function listFtp(){
		if($_SESSION['username']){
			$username = $_SESSION['username'];
		}else if($_GET['username']){
			$username = $_GET['username'];
		}
		$list = daocall('ftp','listFtp',array($username));
		if($list){
			$this->_tpl->assign('sum',count($list));
			$this->_tpl->assign('list',$list);
			$this->_tpl->display('user/ftplist.html');
		}

	}
}
?>
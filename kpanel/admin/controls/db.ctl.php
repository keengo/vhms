<?php
class DbControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function addDb(){
		$data['username'] = $_GET['username'];
		$this->_tpl->assign('username',$data['username']);
		$this->_tpl->display('user/dbadd.html');
	}
	public function check(){
		$check = daocall('db','getDb',array($_POST['dbname']));
		if($check) echo 1;
		else echo 0;
		exit;
	}
	public function insert(){
		$data = $_POST;
		$data['username'] = $_GET['username'];
		$data['dbname'] = $data['dbname'];
		$data['dbpasswd'] = $data['dbpasswd'];
		$ret = daocall('db','insertDb',array($data));
		if($ret !== false ){
			$ret = apicall('whm','addDb',array($data));
			var_dump($ret);
		}else{
			echo 'insert dbuser error';
		}
	}
	public function editDb(){

		$data['username'] = $_GET['username'];
		$this->_tpl->assign('username',$data['username']);
		$this->_tpl->display('user/dbadd.html');
		
	}
	public function delDb(){
		$arr = $_GET;
		$ret = daocall('db','delDb',array($arr['dbname']));
		if($ret){
		
		}
		
	}
	public function getDb(){
		$arr = $_GET;
		$ret = daocall('db','getDb',array($arr['dbname']));
		if($ret){
			$this->_tpl->assign('row',$ret);
			$this->_tpl->display('user/dbinfo.html');
		}
		
	}
	public function listDb(){
		if($_SESSION['username']){
			$username = $_SESSION['username'];
		}else if($_GET['username']){
			$username = $_GET['username'];
		}
		$list = daocall('db','listDb',array($username));
		if($list){
			$this->_tpl->assign('sum',count($list));
			$this->_tpl->assign('list',$list);
			$this->_tpl->display('user/dblist.html');
		}

	}
}
?>
<?php
$lock_file = dirname(__FILE__).'install.lock';
if(file_exists($lock_file)){
	die("已经安装过了，如果要重新安装，请删除文件:".$lock_file);
}
class InstallControl extends Control
{
	public function step1()
	{
		//测试空间是否可写
		$test_file = dirname(__FILE__)."test_write.txt";
		$fp = @fopen($test_file,"wt");
		if(!$fp){
			die("空间不可写，请检查权限");
		}
		fclose($fp);
		if(!unlink($test_file)){
			die("空间不可写，请检查权限");
		}
		//测试结束
		$this->_tpl->assign("db_host","localhost");
		$this->_tpl->assign("db_name","kangle");
		$this->_tpl->assign("admin_user","admin");
		return $this->_tpl->fetch('install/step1.html');
	}
	public function step2()
	{
		
	}
	public function check_connect()
	{
		
	}
}
?>
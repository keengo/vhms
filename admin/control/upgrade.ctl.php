<?php
$GLOBALS['lock_file'] = dirname(__FILE__).'/install.lock';
if(!file_exists($GLOBALS['lock_file'])){
	die("你没有安装过无需升级,请<a href='?c=install&a=step1'>运行安装程序</a>安装");
}
class UpgradeControl extends Control
{
	public function step1()
	{
		if($this->getInstallVersion() == VHMS_VERSION){
			die("已经升级过了.");
		}
		load_lib("pub:db");
		$db = db_connect('default');
		$sqlfile = dirname(__FILE__).'/upgrade.sql';
		apicall('install','executeSql',array($db,$sqlfile));
		apicall('product','flushVhostProduct');
		//$db->exec("ALTER TABLE `vhost` DROP INDEX `name` , ADD UNIQUE `name` ( `name` ) ");
		if(!apicall('install','writeVersion')){
			die("未能写入版本信息");
		}
		die("成功升级,<a href='?c=session&a=loginForm'>登录</a>");
	}
	private function getInstallVersion()
	{
		$line = file($GLOBALS['lock_file']);
		return trim($line[0]);		
	}
}
?>
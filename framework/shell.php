#!/usr/bin/php
<?php
@set_time_limit(0);
function Usage()
{
	die("Usage: ".$_SERVER['argv'][0]." <sync>\n");
}
$dir = dirname(__FILE__);
define('SYS_ROOT',$dir);
define('APPLICATON_ROOT','');
include(SYS_ROOT . '/runtime.php');
if($_SERVER["argv"]== null || $_REQUEST!=null ){
	die("crontab cann't run in web model.please run in cli.");
}
if($_SERVER['argc']<2){
	Usage();
}
$argv = $_SERVER['argv'];
$program = array_shift($argv);
$action = array_shift($argv);
@apicall('shell',$action,$argv);
?>
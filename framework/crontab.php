<?php
@set_time_limit(0);
function Usage()
{
	die("Usage: ".$_SERVER['argv'][0]." <hour|day>\n");
}
$dir = dirname(__FILE__);
define('SYS_ROOT',$dir);
define('APPLICATON_ROOT','');
include(SYS_ROOT . '/runtime.php');
if($_SERVER["argv"]== null || $_REQUEST!=null ){
	die("crontab cann't run in web model.please run in cli.");
}
if($_SERVER['argc']!=2){
	Usage();
}
$action = $_SERVER['argv'][1];
if($action == 'day'){
	return apicall('crontab','runDay');
}
if($action == 'hour'){
	return apicall('crontab','runHour');
}
Usage();
?>

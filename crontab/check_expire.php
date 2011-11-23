<?php
if($_SERVER["argv"]== null || $_REQUEST!=null ){
	die("crontab cann't run in web model.please run in cli.");
}
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");

define('APPLICATON_ROOT', dirname(__FILE__));
define('SYS_ROOT', dirname(dirname(__FILE__)).'/framework');
include(SYS_ROOT.'/runtime.php');

$day = 1; //查询过期天数
$del_day = 30;//过期多少天删除空间
$dal_mysql = 1;//是否删除数据库

$vhosts = daocall('vhost','selectListByExpire_time',array($day)); //获取过期空间
if(!is_file('crontab.log')) {
	@touch('crontab.log');
	echo "touch file success";
}
$fp=fopen('crontab.log', 'a');
if (is_array($vhosts)) {
	foreach ($vhosts as $vhost) {
		$arr['status'] = 1;
		$return = apicall('vhost','changeStatus',array($vhost['node'],$vhost['name'],1));
		$stopstr =$vhost['name']." web stop result=".$return."\r\n";
		echo $stopstr;
		echo "</br>";
		writelog($fp,$stopstr);
	}
}

//查询过期达到指定天数的网站，并删除
$del_vhosts = daocall('vhost','selectListByExpire_time',array($del_day,-1));
if (is_array($del_vhosts)) {
	foreach ($del_vhosts as $del_vhost) {
		$result = apicall('vhost','del',array($del_vhost['node'],$del_vhost['name']));
		$stopstr = $del_vhost['name']." web del result=".$result."\r\n";
		echo $stopstr;
		echo "</br>";
		writelog($fp,$stopstr);
	}
}
//获取数据库的使用量;
function getDbUsed($nodename,$name)
{
	$whm = apicall('nodes','makeWhm',array($nodename));
	$whmCall = new WhmCall('getDbUsed');
	$whmCall->addParam('name', $name);
	return $whm->call($whmCall,10);
}
function writelog($fp,$str)
{
	fwrite($fp, date('Y-m-d H:i:s',time())." ".$str);
}
fclose($fp);


?>
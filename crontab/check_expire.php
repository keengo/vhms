<?php
define('SYS_ROOT', './../framework');
include(SYS_ROOT.'/runtime.php');

$day = 1; //查询过期天数
$del_day = 30;//过期多少天删除空间
$dal_mysql = 1;//是否删除数据库

$vhosts = daocall('vhost','selectListByExpire_time',array($day));
@touch('crontab.log');
$str = date('Y-m-d H:i:s',time())." ".$vhost['name']." web stop success";
writelog($str);
die();
if (count($vhosts)>0)
{
	foreach ($vhosts as $vhost)
	{
		$arr['status'] = 1;
		if(daocall('vhost','updateVhost',array($arr,$vhost['name'])))
		{
			$str = date('Y-m-d H:i:s',time())." ".$vhost['name']." web stop success";
			echo $str;
			writelog($str);
			continue;
		}
	}
	
} else {
	$str = date('Y-m-d H:i:s',time())." not web stop";
	echo $str;
	writelog($str);
}
//查询过期达到指定天数的网站，并删除
$del_vhosts = daocall('vhost','selectListByExpire_time',array($del_day,1));
if (count($del_vhost)>0)
{
	foreach ($del_vhosts as $del_vhost)
	{
		if(daocall('vhost','delVhost',array($vhost['name'],$vhost['username'])))
		{
			$whmCall = new WhmCall('del_vh');
			$whmCall->addParam('name', $vhost['name']);
			$str2 = date('Y-m-d H:i:s',time())." ".$del_vhost['name']." web delete success";
			echo $str2;
			writelog($str2);
			continue;
		}
	}
}else{
	return false;
}
function writelog($str)
{
	$fp=fopen('crontab.log', 'a');
	fwrite($fp, $str);
	fclose($fp);
}


?>
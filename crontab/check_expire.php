<?php
define('SYS_ROOT', './../framework');
include(SYS_ROOT.'/runtime.php');

$day = 1; //查询过期天数
$del_day = 30;//过期多少天删除空间
$dal_mysql = 1;//是否删除数据库

$vhosts = daocall('vhost','selectListByExpire_time',array($day)); //获取过期空间
if(!is_file('crontab.log'))
{
	@touch('crontab.log');
}

if (count($vhosts)>0)
{
	foreach ($vhosts as $vhost)
	{
		$arr['status'] = 1;
		echo "up=".$vhost['name']."\r\n";
		echo "up=".$vhost['node']."\r\n";
		if(daocall('vhost','updateVhost',array($vhost['name'],$arr)))
		{
			if(change_status($vhost))
			{
				$stopstr = date('Y-m-d H:i:s',time())." ".$vhost['name']." web stop success"."\r\n";//暂停空间成功
				echo $stopstr;
				writelog($stopstr);
				continue;
			}else{
				$stopstr2 = date('Y-m-d H:i:s',time())." ".$vhost['name']." web stop faild"."\r\n";//暂停空间失败
				echo $stopstr2;
				writelog($stopstr2);
				continue;
			}
		}
	}

}

//查询过期达到指定天数的网站，并删除
$del_vhosts = daocall('vhost','selectListByExpire_time',array($del_day,1));
if (count($del_vhost)>0)
{
	foreach ($del_vhosts as $del_vhost)
	{
		echo "del=".$del_vhost['name']."\r\n";
		echo "del=".$del_vhost['node']."\r\n";
		if(daocall('vhost','delVhost',array($del_vhost)))
		{
			if(del_vhost($del_vhost))
			{
				$delstr = date('Y-m-d H:i:s',time())." ".$del_vhost['name']." web delete success"."\r\n";//删除空间
				echo $delstr;
				writelog($delstr);
				continue;
			}else{
				$delstr2 = date('Y-m-d H:i:s',time())." ".$del_vhost['name']." web delete faild"."\r\n";//删除空间
				echo $delstr2;
				writelog($delstr2);
				continue;
			}
		}
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
//更改vhms数据库，并同步节点数据库，同步查数据库超标，暂停空间
function change_status($arr)
{
	$arr['status'] = 1;
	if(apicall('vhost','changeStatus',array($arr['node'],$arr['name'],$arr['status'])))
	{
		$return = update_nodevhost_status($arr['node'],$arr['name']);
		if($return==200){
			return true;
		}
	}
	return false;

}

//删除本地数据库和同步节点数据库，并删除空间
function del_vhost($arr)
{
	if(apicall('vhost','del',array($arr['node'],$arr['name']))){
		$return = del_node_vhost($arr['node'], $arr['name']);
		if($return==200){
			return true;
		}
	}
	return false;

}
//删除节点空间

function del_node_vhost($nodename,$name)
{
	//$nodeinfo = daocall('node','getNode',array($nodename));
	$whm = apicall('nodes','makeWhm',array($nodename));
	$whmCall = new WhmCall('del_vh');
	$whmCall->addParam('name', $name);
	return $whm->call($whmCall,10);
}
//更改节点状态
function update_nodevhost_status($nodename,$name)
{
	//$nodeinfo = daocall('node','getNode',array($nodename));
	$whm = apicall('nodes','makeWhm',array($nodename));
	$whmCall = new WhmCall('update_vh');
	$whmCall->addParam('status', 1);
	$whmCall->addParam('name', $name);
	return $whm->call($whmCall,10);
}
function writelog($str)
{
	$fp=fopen('crontab.log', 'a');
	fwrite($fp, $str);
	fclose($fp);
}


?>
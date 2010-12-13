<?php
session_start();
include("../config.php");
$dblink = mysql_connect($db_host,$db_user,$db_passwd);
mysql_select_db($db_db,$dblink);
mysql_query("set names utf8", $dblink);

$username = $_POST['username'];
$passwd = $_POST['password'];
$sql = sprintf("SELECT username,passwd,rights FROM admin_users WHERE username='%s'",$username);

$result = mysql_query($sql,$dblink);
if($result && mysql_num_rows($result) == 1)
{
	$arr = mysql_fetch_assoc($result);
	if(strtolower($arr["passwd"])==strtolower(md5($passwd))){
	//	die("success");
		$_SESSION['admin_user'] = $arr['username'];
		$_SESSION['admin_right'] = $arr['rights'];
		header("Location: index.php");
		die();
	}
}
//die("sql=".$sql);
header("Location: index.php?c=session&a=login");
?>
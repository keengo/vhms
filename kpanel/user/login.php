<?php
session_start();
include("../config.php");
$dblink = mysql_connect($db_host,$db_user,$db_passwd);
mysql_select_db($db_db,$dblink);
mysql_query("set names utf8", $dblink);

$username = $_POST['username'];
$passwd = $_POST['password'];
$sql = sprintf("SELECT username,passwd FROM users WHERE username='%s'",$username);
$result = mysql_query($sql,$dblink);
if($result && mysql_num_rows($result) == 1)
{
	$arr = mysql_fetch_assoc($result);
	if(strtolower($arr["passwd"])==strtolower(md5($passwd))){
		$_SESSION['username'] = $arr['username'];
		header("Location: index.php");
		die();
	}
}
header("Location: index.php?c=session&a=login");
?>
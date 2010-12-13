<?php
include_once("./connect.php");
include_once("./utils.php");
header("Content-Type: text/html; charset=gbk");
$user = $_REQUEST["name"];
if(!ereg($right_user_name,$user)){
	die("用户名有错误!(由小写的英文字母和数字组成，长度在3-16位)");
}
if(check_exsit_user($user)){
	echo "<font color=red>用户名:".$user."已经被别人注册了!</font>";
}else{
	echo "<font color=blue>用户名:".$user."可以注册！</font>";
}
?>

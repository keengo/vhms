<?php

session_start();
include_once("./connect.php");
function error_login()
{
	die("用户名或密码不对！");
}
$name=$_REQUEST["name"];
if(strstr($name,"'")!=""){
	error_login();
}

$sql="select doc_root,templete,create_time,expire_time,passwd from users where name='".$name."'";
$result=mysql_query($sql,$cn);
if(!$result){
	error_login();
}
$rs=mysql_fetch_array($result);
if(!$rs || strcmp($rs[passwd],md5($_REQUEST["passwd"]))!=0){
	error_login();
}
$_SESSION["name"] = $name;
$_SESSION["doc_root"] = $rs["doc_root"];
$_SESSION["templete"] = $rs["templete"];
$_SESSION["create_time"] = $rs["create_time"];
$url = "index.php";
Header("Location: ".$url);
?>

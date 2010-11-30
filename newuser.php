<?php
include_once("./connect.php");
include_once("./whm.php");
include_once("./utils.php");
function make_user_doc_root($user)
{
        return "/home/ftp/".$user[0]."/".$user;
}
$user = $_REQUEST["name"];
if(check_exsit_user($user)){
	die("该用户已经注册了");
}
$passwd = md5($_REQUEST["passwd"]);
$templete = $_REQUEST["type"];
$doc_root = make_user_doc_root($user);
$sql = "insert into users (name,passwd,doc_root,templete) values ('".$user."','".$passwd."','".$doc_root."','".$templete."')";
mysql_query($sql,$cn);
$rs = mysql_fetch_array(mysql_query("select uid,gid from users where name='".$user."'"));
/*
调用whm，初始化用户数据
*/
$call = new WhmCall("init_vh".$templete);
$call->addParam("name",$user);
$call->addParam("doc_root",$doc_root);
$call->addParam("uid",$rs["uid"]);
$call->addParam("gid",$rs["gid"]);
$whm->call($call);
echo "注册成功.<a href='index.php'>点这里登录管理</a>";
?>

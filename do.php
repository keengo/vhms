<?php
include_once("./check_login.php");
include_once("./connect.php");
$action = $_REQUEST["action"];
$reload = true;
if($action=="del"){
	$sql = "delete from domain where domain='".$_REQUEST["domain"]."' and name='".$_SESSION["name"]."'";
}else if($action=="add"){
	if($_REQUEST["domain"]==""){
		die("参数错误");
	}
	$sql = "insert into domain (name,domain,dir) value ('".$_SESSION["name"]."','".$_REQUEST["domain"]."','".$_REQUEST["dir"]."')";
}else if($action=="edit"){
	if($_REQUEST["domain"]=="" ){
		die("参数错误");
	}
	$sql = "update domain set dir='".$_REQUEST["dir"]."' where domain='".$_REQUEST["domain"]."' and name='".$_SESSION["name"]."'";
}else if($action=="changepasswd"){
	$reload = false;
	if($_REQUEST["passwd1"]==""){
		die("新密码不能为空");
	}
	if($_REQUEST["passwd1"]!=$_REQUEST["passwd2"]){
		die("两次密码不对");
	}
	$sql="select passwd from users where name='".$_SESSION[name]."'";
	$rs=mysql_fetch_array(mysql_query($sql));
	if(!$rs){
		die("没有这个用户名");
	}
	if(strtolower(md5($_POST[old_passwd]))!=strtolower($rs[passwd])){
		die("旧密码不对");
	}
	$sql = "update users set passwd='".md5($_REQUEST["passwd1"])."' where name='".$_SESSION[name]."'";
	mysql_query($sql,$cn);
	$err_msg =  mysql_error();
	if($err_msg!=""){
		die($err_msg);
	}
	die("修改密码成功");

}
if($sql==""){
	die("wrong action");
}else{
	mysql_query($sql,$cn);
	$err_msg =  mysql_error();
	if($err_msg!=""){
		die($err_msg);
	}
	if($reload){
		include("./whm.php");
		$call = new WhmCall("reload_vh");
		$call->addParam("name",$_SESSION["name"]);
		$whm->call($call);
	}
	header("Location: domain.php");
}
?>


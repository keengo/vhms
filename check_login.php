<?php
session_start();
header("Content-Type: text/html; charset=gbk");
if($_SESSION["name"]==""){
	die("没有登录或者登录超时.[<a href='index.php' target=_top>点这里登录</a>]");
}
?>

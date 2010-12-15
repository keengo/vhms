<?php 
session_start();
if($_SESSION['username']==''){
	header("Location: ?c=session&a=login");
	die();
}
?>
<?php
session_start();
header("Cache-Control: no-cache, must-revalidate");
//定义代码路径
define('APPLICATON_ROOT', dirname(__FILE__));
define('SYS_ROOT', dirname(dirname(__FILE__)).'/framework');
//定义默认控制器
define('DEFAULT_CONTROL', 'index');
include(SYS_ROOT . '/runtime.php');
include("../config.php");
if($_SESSION['admin_user']==""){
	$_REQUEST["c"] = "session";
	$_REQUEST["a"] = "login";
}
startFramework();
?>

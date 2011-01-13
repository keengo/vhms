<?php
session_start();
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
//定义代码路径
define('APPLICATON_ROOT', dirname(__FILE__));
define('SYS_ROOT', dirname(dirname(__FILE__)).'/framework');
//定义默认控制器
define('DEFAULT_CONTROL', 'index');
//die(print_r($_REQUEST));
include(SYS_ROOT . '/runtime.php');
@include("../config.php");
startFramework();
?>

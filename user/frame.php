<?php
session_start();
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
define('APPLICATON_ROOT', dirname(__FILE__));
define('SYS_ROOT', dirname(dirname(__FILE__)).'/framework');
define('DEFAULT_CONTROL', 'public');
include(SYS_ROOT . '/runtime.php');
include("../config.php");
$c=$_REQUEST['c'];
$a=$_REQUEST['a'];
if($c==""){
	$_REQUEST['c']=$c='frame';
	$_REQUEST['a']=$a='index';
}
$tpl = TPL::singleton();
$tpl->assign('frame',1);
$GLOBALS['frame'] = 1;
$main = dispatch($c,$a);
//echo $main;
//startFramework();
$tpl->assign('main',$main);
$tpl->display('frame.html');
?>
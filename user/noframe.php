<?php
session_start();
date_default_timezone_set('Asia/Shanghai');
header("Cache-Control: no-cache, must-revalidate");
//定义代码路径
define('APPLICATON_ROOT', dirname(__FILE__));
define('SYS_ROOT', dirname(dirname(__FILE__)).'/framework');
//定义默认控制器
define('DEFAULT_CONTROL', 'public');
include(SYS_ROOT . '/runtime.php');
include(APPLICATON_ROOT."/../config.php");
$c=$_REQUEST['c'];
$a=$_REQUEST['a'];
if($c==""){
	$_REQUEST['c']=$c='public';
	$_REQUEST['a']=$a='index';
}
$main = dispatch($c,$a);
//echo $main;
//startFramework();
$tpl = TPL::singleton();
$tpl->assign('main',$main);
$tpl->assign('width','960');
$tpl->assign('title',getTitle());
$tpl->display('noframe.html');
?>
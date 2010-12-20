<?php
/**
 * 获得微妙数
 */
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return (float)$usec + (float)$sec;
}
$start_time = microtime_float();
define('APPLICATON_ROOT', dirname(__FILE__));
define('SYS_ROOT', dirname(dirname(__FILE__)).'/framework');
require_once( SYS_ROOT . "/smarty/Smarty.class.php");
$instance = new Smarty();
$instance->use_sub_dirs = false;
$instance->template_dir = APPLICATON_ROOT . '/view/default';
$instance->assign("STATIC",dirname($_SERVER['SCRIPT_NAME']).'/view/default/');
$instance->assign('_c',$_REQUEST['c']);
$instance->assign('_a',$_REQUEST['a']);


$instance->caching = false;
$instance->left_delimiter = '!{';
$instance->right_delimiter = '}';
//$instance->compile_check = false;
$instance->display('changePassword.html');
$end_time=microtime_float();
echo "time:".($end_time-$start_time);
?>
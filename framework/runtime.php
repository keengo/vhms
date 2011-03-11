<?php
/**
 * 框架内核启动
 * 
 * @package core
 */
@include_once("../config.php");
//ob_start();

if(!defined('VHOST_ROOT'))
{
	define('VHOST_ROOT', $_SERVER["DOCUMENT_ROOT"]);
}

if(!defined('APPLICATON_ROOT'))
{
	trigger_error('未定义常量 APPLICATON_ROOT.', E_USER_ERROR);
}

if(!defined('SYS_ROOT'))
{
	trigger_error('未定义常量 SYS_ROOT.', E_USER_ERROR);
}
define(VHMS_VERSION,"1.1");
/**
 * 框架全局变量
 */
global $__core_env;	//框架环境变量

/**
 * 核心文件加载函数
 *
 * 负责system, public, application 的文件加载
 *
 * @param string 文件名，包含tag标识，例如：pub:frame
 * @param string 文件所在特殊目录
 * @param bool 为true时，不加载文件，直接返回文件真实路径
 * @return mixed
 */
function __load_core($file, $dir = "", $return = false)
{
	global $__core_env;

	$tag = '';
	$pos = strpos($file, ':');
	if($pos !== false)
	{
		$tag = substr($file, 0, $pos);
		$file = substr($file, $pos + 1);
	}

	if(!in_array(substr($file, 0, 1), array('/', '\\')))
	{
		$file = '/' . $file;
	}

	$file = $dir . $file . '.php';
	if(substr($file, 0, 1) == '/') $file = substr($file , 1);

	switch($tag)
	{
		case 'core':
			$file =  SYS_ROOT . '/' . $file;
			break;
		case 'mod':
			$file =  APPLICATON_ROOT . '/models/' . $file;
			break;
		case 'pub':
			$file = SYS_ROOT.'/'.$file;
			break;
		case 'app':
		default: 
			$file = APPLICATON_ROOT . '/' . $file;
			break;
	}

	$__core_env['last_load_file'] = $file;

	if(file_exists($file))
	{
		if($return)
		{
			return $file;
		}
		else
		{
			//echo 'file='.$file;
			include_once($file);
			//print_r($lang);
			return true;
		}
	}
	else
	{
		trigger_error('文件不存在: ' . $file, E_USER_WARNING);
		//debug_print_backtrace();
		return false;
	}
}

/**
 * 获得最后一次加载的文件
 */
function __get_last_load()
{
	global $__core_env;

	return $__core_env['last_load_file'];
}
/**
 * 基础库加载函数
 *
 * @param string 文件名
 */
function load_lib($file)
{
	__load_core($file . '.lib', 'lib');
}
/**
 * 配置加载函数
 *
 * @param string 文件名
 */
function load_conf($file)
{
	__load_core($file . '.cfg', 'configs');
}
/**
 * 控制器加载函数
 *
 * @param string 文件名
 */
function load_ctl($file)
{
	__load_core($file . '.ctl', 'control');
}



/**
 * api加载函数
 *
 * @param string 文件名
 */
function load_api($file)
{
	__load_core('pub:' . $file . '.api', 'api');
}
function load_lng($file)
{
	__load_core('pub:'.$file.'.lng','lng');
}
/**
 * dao加载函数
 *
 * @param string 文件名
 */
function load_dao($file)
{
	__load_core('pub:' . $file . '.dao', 'dao');
}

/**
 * 业务模型加载函数
 *
 * @param string 文件名
 */
function load_mod($file)
{
	__load_core($file . '.mod', 'model');

	$pos = strrpos($file, '/');
	if(false === $pos)
		$model_name = $file;
	else
		$model_name = substr($file, $pos + 1, 100);

	$class = $model_name . 'Model';

	if(!class_exists($class))
	{
		trigger_error($class . '  模型未定义.', E_USER_ERROR);
		return false;
	}
}
/**
 * Controller调用
 */
function ctlcall($module,$method,$args = array()) 
{
	//加载控制器接口文件
	$module = str_replace(array('-'), array('/'), $module);
	load_ctl($module);
	$pos 	= strrpos($module, '/');
	$class  = $module;
	if(false !== $pos){
		$class = substr($class, $pos + 1, 100);
	}
	$class[0]  = strtoupper($class[0]);
	$className = $class."Control";
	return BaseCall("ctl",$className,$method,$args);
}

/**
 * MODEL调用
 */
function modcall($module,$method,$args = array()) {
	//加载控制器接口文件
	$module = str_replace(array('-'), array('/'), $module);
	load_mod($module);
	$pos 	= strrpos($module, '/');
	$class  = $module;
	if(false !== $pos){
		$class = substr($class, $pos + 1, 100);
	}
	$class[0]  = strtoupper($class[0]);
	$className = $class."Model";
	return BaseCall("mod",$className,$method,$args);
}

/**
 * API调用
 */
function apicall($module,$method,$args=null) {
	//加载系统接口文件
	load_api($module);
	$className	= exportClass($module,"API");
	return BaseCall("api",$className,$method,$args);
}
function newapi($module)
{
	load_api($module);
	$className	= exportClass($module,"API");
	return 	Container::getInstance()->newObj($module,$className,true);
}
/**
 * DAO调用
 */
function daocall($module,$method,$args=null,$is_stat = true) {
	//加载DAO层文件
	load_dao($module);
	$className	= exportClass($module,"DAO");
	return BaseCall("dao",$className,$method,$args,false,$is_stat);
}
function newdao($module)
{
	load_dao($module);
	$className	= exportClass($module,"DAO");
	return 	Container::getInstance()->newObj($module,$className,true);
}
function exportClass($module,$lay) {
	$module_clips 	= explode("_",$module);
	$className  	= "";
	foreach($module_clips as $clip) {
		$clip[0] 	= strtoupper($clip[0]);
		$className .= $clip;
	}
	$className .= $lay;
	return $className;
}

/**
 * 核心函数
 * 调用类名为className的method函数
 * @param String className	类名
 * @param String method		调用的函数名
 * @param Boolean mul_mod	是否多例模式，默认为单例模式
 * @param Boolean is_stat	是否统计
 * @return Mixed 成功：目标函数的返回结果；失败：false
 */
function BaseCall($module,$className,$method,$args,$mul_mod = false,$is_stat = true) {
	$start = 0;
	//DEBUG跟踪
	global $__core_env;
	$__core_env['DEBUG'] === true && $__core_env['STRACE'][$module."/".$className."/".$method]['start'] = microtime_float();
	$object	= Container::getInstance()->newObj($module,$className,$mul_mod);
	if(method_exists($object, $method))
	{
		$result = call_user_func_array(array($object, $method), $args==null?array():$args);
		if($__core_env['DEBUG'] === true)
		{
			$__core_env['STRACE']["{$module}/".$className."/".$method]['end'] 	 = microtime_float();
			$__core_env['STRACE']["{$module}/".$className."/".$method]['cost'] 	 = $__core_env['STRACE']["{$module}/".$className."/".$method]['end']-$__core_env['STRACE']["{$module}/".$className."/".$method]['start'];
			$__core_env['STRACE']["{$module}/".$className."/".$method]['return']  = $result;
		}
		return $result;
	} else {
		if($__core_env['DEBUG'] === true)
		{
			$__core_env['STRACE']["{$module}/".$className."/".$method]['end'] 	 = microtime_float();
			$__core_env['STRACE']["{$module}/".$className."/".$method]['cost'] 	 = $__core_env['STRACE']["{$module}/".$className."/".$method]['end']-$__core_env['STRACE']["{$module}/".$className."/".$method]['start'];
			$__core_env['STRACE']["{$module}/".$className."/".$method]['return']  =  "ERROR: The Method {$method} in {$className} is not exist";
			echo $__core_env['STRACE']["{$module}/".$className."/".$method]['return'];
		}
		return false;
	}
}
function getRoles()
{
	global $_SESSION;
	return $_SESSION['janbao_role'];
}
function getRole($role)
{
	global $_SESSION;
	return $_SESSION['janbao_role'][$role];
}
function unregisterRole($role)
{
	global $_SESSION;
	unset($_SESSION['janbao_role'][$role]);
}
function registerRole($role,$user)
{
	global $_SESSION;
	$_SESSION['janbao_role'][$role]=$user;
	assert(isRole($role));
}
function isRole($role)
{
	$user = getRole($role);
	if($user==null || $user==""){
		return false;
	}	
	return true;
}
function setTitle($title)
{
	global $__core_env;
	$__core_env['title'] = $title;
}
function getTitle()
{
	global $__core_env;
	if($__core_env['title']==""){
		$__core_env['title'] = "kangle虚拟主机管理系统";
	}
	return $__core_env['title']." - Powered by kangle vhms ".VHMS_VERSION;
}
function getRandPasswd($len=8)
{
        $base_passwd='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_-0123456789';
        srand((double)microtime()*1000000);
        $base_len=strlen($base_passwd);
        if($len<8){
            $len=8;
        }
        for($i=0;$i<$len;$i++){
            $passwd.=$base_passwd[rand()%$base_len];
        }
        return $passwd;
}
function needRole($role)
{

	if(!isRole($role)){
		if($_SERVER["QUERY_STRING"]=='c=session&a=loginForm'){
			die("");
		}
		die('<html><body><script language="javascript">window.top.location.href="?c=session&a=loginForm";</script></body></html>');
	}
}

/**
 * 获得微妙数
 */
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return (float)$usec + (float)$sec;
}
/*
* 框架文件加载
*/
$__core_env['DEBUG']=false;
load_lng('zh');
//include_once(SYS_ROOT.'/lng/zh.lng.php');
//print_r($lang);
//die('');
__load_core('core:control');
__load_core('core:model');
__load_core('core:dao');
__load_core('core:api');
__load_core('core:tpl');
__load_core('core:container');
__load_core('core:dispatch');

//load_conf('pub:global');
//load_conf('pub:database');
/*
* 框架运行开始
*/
function startFramework()
{
	if(!defined('CORE_DAEMON'))	//当框架非用于后台Daemon脚本编写
	{		
		__dispatch_init();
		echo __dispatch_start();
	}
}
//ob_end_flush();
?>
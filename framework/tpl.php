<?php
/*
*	重写smarty,护展配置路径
*/
class TPL
{
    private static $instance;
    
    public static function singleton() 
    {
		require_once( SYS_ROOT . "/smarty/Smarty.class.php");
		if (!isset(self::$instance)) {
            self::$instance = new Smarty();
			self::$instance->use_sub_dirs = true;
			//防止没有第一次使用的时候，无法连接数据库
			if (file_exists(dirname(__FILE__).'../config.php')) {
				$view_dir = daocall('setting','get',array('view_dir'));
			}
			if (!$view_dir) {
				$view_dir = 'default';
			}
			self::$instance->template_dir = APPLICATON_ROOT . '/view/'.$view_dir;;
			self::$instance->compile_dir = SYS_ROOT.'/templates_c/'.$view_dir;
			if(!defined(TPL_ROOT)){
				//define(TPL_ROOT,dirname($_SERVER["REQUEST_URI"]));
				define(TPL_ROOT,dirname($_SERVER['PHP_SELF']));
			}
			self::$instance->assign("STATIC",TPL_ROOT.'/view/'.$view_dir.'/');
			//self::$instance->assign("PSTATIC","/");
		
			//self::$instance->assign('role',getRoles());
			//self::$instance->caching = false;
			self::$instance->left_delimiter = '{{';
			self::$instance->right_delimiter = '}}';
        }
        return self::$instance;
	}
}
?>
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
			self::$instance->use_sub_dirs = false;
			self::$instance->template_dir = APPLICATON_ROOT . '/view/default';
			if(!defined(TPL_ROOT)){
				define(TPL_ROOT,dirname($_SERVER['SCRIPT_NAME']));
			}
			self::$instance->assign("STATIC",TPL_ROOT.'/view/default/');
			//self::$instance->assign("PSTATIC","/");			
			self::$instance->assign('lang',get_lang());
			self::$instance->assign('role',getRoles());
			self::$instance->caching = false;
			self::$instance->left_delimiter = '{{';
			self::$instance->right_delimiter = '}}';
        }
        return self::$instance;
	}
}
?>
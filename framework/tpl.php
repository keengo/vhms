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
			//global $lang;
			//die('lang='.$lang);
            self::$instance = new Smarty();
			self::$instance->use_sub_dirs = false;
			self::$instance->template_dir = APPLICATON_ROOT . '/view/default';
			self::$instance->assign("STATIC",dirname($_SERVER['SCRIPT_NAME']).'/view/default/');			
			self::$instance->assign('lang',get_lang());
			self::$instance->assign('role',getRoles());
			self::$instance->caching = false;
			self::$instance->compile_dir = "c:\\windows\\temp\\smarty_templates_c";
			//self::$instance->compile_check = false;
			/*
			$tmp_dir = explode(".",$_SERVER['SERVER_NAME']);
			if(!file_exists( SYS_ROOT . '/smarty_templates_c')){
				mkdir(SYS_ROOT . '/smarty_templates_c');
			}
			if(!file_exists( SYS_ROOT . '/smarty_templates_c/'.$tmp_dir[0])){
				mkdir(SYS_ROOT . '/smarty_templates_c/'.$tmp_dir[0]);
			}			
			self::$instance->compile_dir = SYS_ROOT . '/smarty_templates_c/'.$tmp_dir[0];
			if(!file_exists( SYS_ROOT . '/smarty_cache')){
				mkdir(SYS_ROOT . '/smarty_cache');
			}
			if(!file_exists( SYS_ROOT . '/smarty_cache/'.$tmp_dir[0])){
				mkdir(SYS_ROOT . '/smarty_cache/'.$tmp_dir[0]);
			}

			self::$instance->cache_dir = SYS_ROOT . '/smarty_cache/'.$tmp_dir[0];
			self::$instance->plugins_dir = array("plugins", SYS_ROOT . "/smarty/helpers");
			*/
			self::$instance->left_delimiter = '{{';
			self::$instance->right_delimiter = '}}';
        }
        return self::$instance;
	}
}
?>

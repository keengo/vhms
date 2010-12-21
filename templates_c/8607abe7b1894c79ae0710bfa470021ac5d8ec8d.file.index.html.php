<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:03:06
         compiled from "D:\project\janbao/view/default\index.html" */ ?>
<?php /*%%SmartyHeaderCode:315234d105f3ab45ea1-69909611%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8607abe7b1894c79ae0710bfa470021ac5d8ec8d' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\index.html',
      1 => 1292918544,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '315234d105f3ab45ea1-69909611',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include 'D:\project\janbao\framework\smarty\plugins\function.dispatch.php';
?>hello world2!{$_REQUEST.name}
<?php echo smarty_function_dispatch(array('c'=>'index','a'=>'registerForm'),$_smarty_tpl);?>

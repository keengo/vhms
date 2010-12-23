<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:27:46
         compiled from "D:\project\janbao/view/default\product_check_result.html" */ ?>
<?php /*%%SmartyHeaderCode:148764d12c1b20d1976-82460354%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c81df1b2d14bff2c851e51e34c75e881408977d' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\product_check_result.html',
      1 => 1292987686,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148764d12c1b20d1976-82460354',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>检测结果</title>
</head>
<body>
<?php if ($_smarty_tpl->getVariable('result')->value==1){?>
<?php echo $_smarty_tpl->getVariable('param')->value;?>
已经被别人注册了!请选过一个吧.
<?php }else{ ?>
<?php echo $_smarty_tpl->getVariable('param')->value;?>
可用
<?php }?>
</body>
</html>
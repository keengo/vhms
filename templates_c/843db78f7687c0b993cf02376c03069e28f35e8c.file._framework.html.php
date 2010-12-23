<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 13:35:28
         compiled from "D:\project\janbao/view/default\_framework.html" */ ?>
<?php /*%%SmartyHeaderCode:261124d12dfa0b18166-31959138%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '843db78f7687c0b993cf02376c03069e28f35e8c' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\_framework.html',
      1 => 1293082526,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '261124d12dfa0b18166-31959138',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php if (!is_callable('smarty_function_dispatch')) include 'D:\project\janbao\framework\smarty\plugins\function.dispatch.php';
?><?php echo smarty_function_dispatch(array('c'=>'public','a'=>'head'),$_smarty_tpl);?>

<table width="<?php echo $_smarty_tpl->getVariable('width')->value;?>
" border="0" align="center">
  <tr>
    <td width="150" valign="top"><?php echo smarty_function_dispatch(array('c'=>$_REQUEST['c'],'a'=>'left'),$_smarty_tpl);?>
</td>
    <td valign='top' align='left'><?php echo $_smarty_tpl->getVariable('main')->value;?>
</td>
  </tr>
</table>
<?php echo smarty_function_dispatch(array('c'=>'public','a'=>'foot'),$_smarty_tpl);?>

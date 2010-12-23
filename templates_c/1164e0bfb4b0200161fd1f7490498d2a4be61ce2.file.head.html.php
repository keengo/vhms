<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:55:18
         compiled from "D:\project\janbao/view/default\public/head.html" */ ?>
<?php /*%%SmartyHeaderCode:102844d12c8265c08f1-05851271%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1164e0bfb4b0200161fd1f7490498d2a4be61ce2' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\public/head.html',
      1 => 1293074379,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '102844d12c8265c08f1-05851271',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body>
<table width="<?php echo $_smarty_tpl->getVariable('width')->value;?>
" height="20" border="0" align="center" cellPadding=0 cellSpacing=0>
  <tr><form id="form1" name="form1" method="post" action="?c=session&a=login" >
    <td valign="middle">
	<?php if ($_smarty_tpl->getVariable('role')->value['user']){?><?php echo $_smarty_tpl->getVariable('role')->value['user'];?>
,您好!  [<a href='?c=user&a=index'>进入会员中心</a>] [<a href='?c=session&a=logout'>退出</a>]<?php }else{ ?>
      用户名:
      <input name="username" type="text" size="12" />
        密码:
        <input name="passwd" type="password" size="12" />
        <input type="submit" name="Submit" value="登录" />
        <a href="?c=public&a=registerForm"><font color='red'>注册</font></a>
    忘记密码 
   
	<?php }?>
    </td> </form>
    <td align="right" valign="middle"><script language="javascript" src="?c=product&a=productList&target=self">
</script></td>
  </tr>
</table>
<table width='<?php echo $_smarty_tpl->getVariable('width')->value;?>
' border="0" align="center">
<tr>
<td width="120"><img src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/style/logo.gif' border="0"/></td>
<td width="650">banner</td>
</tr></table>
<table width="<?php echo $_smarty_tpl->getVariable('width')->value;?>
" border="0" align="center">
  <tr><td>
   <?php  $_smarty_tpl->tpl_vars['menu'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('menus')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['menu']->key => $_smarty_tpl->tpl_vars['menu']->value){
?>
    <a href="<?php echo $_smarty_tpl->tpl_vars['menu']->value[1];?>
"><?php echo $_smarty_tpl->tpl_vars['menu']->value[0];?>
</a>|
   <?php }} ?>
  </td>
  </tr>
</table>

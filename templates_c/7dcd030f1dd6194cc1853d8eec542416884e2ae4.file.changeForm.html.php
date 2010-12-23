<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 14:06:44
         compiled from "D:\project\janbao/view/default\user/changeForm.html" */ ?>
<?php /*%%SmartyHeaderCode:156134d12e6f4172d36-84321512%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7dcd030f1dd6194cc1853d8eec542416884e2ae4' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\user/changeForm.html',
      1 => 1293084401,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '156134d12e6f4172d36-84321512',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<form action="?c=user&a=change" method="post">
<table width="329" border="1">
  <tr>
    <td width="99">用户名</td>
    <td width="214"><?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
</td>
  </tr>
  <tr>
    <td>姓名</td>
    <td><input name='name' id="name" value='<?php echo $_smarty_tpl->getVariable('user')->value['name'];?>
' /></td>
  </tr>
  <tr>
    <td>身份证</td>
    <td><input name='id' id="id" value='<?php echo $_smarty_tpl->getVariable('user')->value['id'];?>
' /></td>
  </tr>
  <tr>
    <td>电子邮件</td>
    <td><input name='email' id="email" value='<?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
' /></td>
  </tr>
    <tr>
    <td>&nbsp;</td>
    <td><input type='submit' value='修改' /></td>
  </tr>
 </table>
</form>
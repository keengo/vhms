<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:22:07
         compiled from "D:\project\janbao/view/default\user/index.html" */ ?>
<?php /*%%SmartyHeaderCode:155504d12c05f35a0d8-81078595%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '57dd7129517324975ab2423c717390b399672c35' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\user/index.html',
      1 => 1293074525,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '155504d12c05f35a0d8-81078595',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<table width="329" border="1">
  <tr>
    <td width="99">用户名</td>
    <td width="214"><?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
</td>
  </tr>
  <tr>
    <td>姓名</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['name'];?>
</td>
  </tr>
  <tr>
    <td>身份证</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['id'];?>
</td>
  </tr>
  <tr>
    <td>电子邮件</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
</td>
  </tr>
  <tr>
    <td>账户余额(元)</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['money']/100;?>
</td>
  </tr>
</table>

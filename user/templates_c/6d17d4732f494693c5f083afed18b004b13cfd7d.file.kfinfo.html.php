<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:14:05
         compiled from "D:\project\janbao\user/view/default\kfinfo.html" */ ?>
<?php /*%%SmartyHeaderCode:23604d0f104d36de57-06608721%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6d17d4732f494693c5f083afed18b004b13cfd7d' => 
    array (
      0 => 'D:\\project\\janbao\\user/view/default\\kfinfo.html',
      1 => 1292400996,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '23604d0f104d36de57-06608721',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<table width="329" border="1" align="center">
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
<div id="container">
<div class="topimg">
</div>
</div>
</body>
</html>
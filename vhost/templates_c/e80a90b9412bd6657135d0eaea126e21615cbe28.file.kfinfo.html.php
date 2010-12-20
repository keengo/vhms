<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:10:11
         compiled from "D:\project\janbao\vhost/view/default\kfinfo.html" */ ?>
<?php /*%%SmartyHeaderCode:65894d0f0f63970065-80960835%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e80a90b9412bd6657135d0eaea126e21615cbe28' => 
    array (
      0 => 'D:\\project\\janbao\\vhost/view/default\\kfinfo.html',
      1 => 1292817156,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '65894d0f0f63970065-80960835',
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
    <td width="99">FTP用户名</td>
    <td width="214"><?php echo $_smarty_tpl->getVariable('user')->value['name'];?>
</td>
  </tr>
  <tr>
    <td>FTP主机</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['node'];?>
</td>
  </tr>
  <tr>
    <td>产品名称</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['product_id'];?>
</td>
  </tr>
  <tr>
    <td>创建时间</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['create_time'];?>
</td>
  </tr>
  <tr>
    <td>到期时间</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['expire_time'];?>
</td>
  </tr>
  <tr>
    <td>状态</td>
    <td><?php echo $_smarty_tpl->getVariable('user')->value['state'];?>
</td>
  </tr>
</table>
<div id="container">
<div class="topimg">
</div>
</div>
</body>
</html>

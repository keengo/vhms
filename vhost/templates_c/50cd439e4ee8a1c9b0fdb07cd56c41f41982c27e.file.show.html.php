<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:10:13
         compiled from "D:\project\janbao\vhost/view/default\domain/show.html" */ ?>
<?php /*%%SmartyHeaderCode:98564d0f0f654cbbd6-31536275%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '50cd439e4ee8a1c9b0fdb07cd56c41f41982c27e' => 
    array (
      0 => 'D:\\project\\janbao\\vhost/view/default\\domain/show.html',
      1 => 1292821279,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '98564d0f0f654cbbd6-31536275',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg"></div>
<div class="topimg pal1">共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</div>
  <div id="main" class="wid">
    <table width="436" cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td width="75" bgcolor='#efefef' class='color01 right'>操作</td>
        <td width="123" bgcolor='#efefef' class='color01 right'>域名</td>
        <td width="232" bgcolor='#efefef' class='color01 right'>目录</td>
	  </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
        <td class="right">[<a href="javascript:if(confirm('确定删除<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
?')){location='?c=domain&a=del&domain=<?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
';}" title="删除域名"> 删除</a>]</td>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['domain'];?>
</td>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['dir'];?>
</td>
	  </tr>
	  <?php }} ?>
    </table>
    <div align="left">
	</div>
  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
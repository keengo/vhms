<?php /* Smarty version Smarty-3.0.5, created on 2010-12-10 14:13:23
         compiled from "I:\janbao\kpanel\admin/views/default\listnode.html" */ ?>
<?php /*%%SmartyHeaderCode:290394d0235833778a6-53797402%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3f5e9ef8e8765bc4fe03e25fed9c6d37328de42b' => 
    array (
      0 => 'I:\\janbao\\kpanel\\admin/views/default\\listnode.html',
      1 => 1291990398,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '290394d0235833778a6-53797402',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -> 主机列表 -> 返回<a href="/?c=user&a=listvh&username=<?php echo $_smarty_tpl->getVariable('username')->value;?>
"><?php echo $_smarty_tpl->getVariable('username')->value;?>
</></div>
<div class="topimg pal1">共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td class='color01 right' bgcolor='#efefef'>名称</td>
		<td class='color01 right' bgcolor='#efefef'>主机</td>
		<td class='color01 right' bgcolor='#efefef'>端口</td>
		<td class='color01 right' bgcolor='#efefef'>用户名</td>
        <td class='color01 right' bgcolor='#efefef'>操作</td>
      </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['host'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['port'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['user'];?>
</td>
        <td class="right">[<a href="javascript:if(confirm('确定删除<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
?')){location='?c=nodes&a=del&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
';}" title="删除主机">
        <img src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/b_drop.gif' alt='删除主机' border="0" align="absmiddle"></a>]
        [<a href="?c=nodes&a=editForm&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" title="更改信息">
        <img src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/b_edit.gif' alt='更改信息' border="0" align="absmiddle"></a>]
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
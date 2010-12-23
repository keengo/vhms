<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:17:53
         compiled from "D:\project\janbao/view/default\showVhostProduct.html" */ ?>
<?php /*%%SmartyHeaderCode:272474d12bf6110d3f3-41791068%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4037bb0bbf51e9240991e72c551eb13830678859' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\showVhostProduct.html',
      1 => 1293074269,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '272474d12bf6110d3f3-41791068',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿
<div id="container">
<div class="topimg pal1">共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td  bgcolor='#efefef' class='color01 right'>操作</td>
	   <td  bgcolor='#efefef' class='color01 right'>ftp用户名</td>
	   <td bgcolor='#efefef' class='color01 right'>产品</td>
	   	<td bgcolor='#efefef' class='color01 right'>购买时间</td>
		<td  bgcolor='#efefef' class='color01 right'>过期时间</td>
		<td bgcolor='#efefef' class='color01 right'>状态</td>
      </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
        <td class="right"> [<a href="?c=vhostproduct&a=editProductForm&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" title="更改信息">续费</a>][升级][<a href="?c=vhostproduct&a=impLogin&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" target="_blank">管理</a>]</td>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['product_id'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['create_time'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['expire_time'];?>
</td>
		<td class="right">&nbsp;</td>
      </tr>
	  <?php }} ?>
    </table>
    <div align="left">
	</div>
  </div>
</div>

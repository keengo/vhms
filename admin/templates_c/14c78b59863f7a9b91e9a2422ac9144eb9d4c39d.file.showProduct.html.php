<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:42:47
         compiled from "D:\project\janbao\admin/view/default\vhostproduct/showProduct.html" */ ?>
<?php /*%%SmartyHeaderCode:109094d1068879b7794-39003810%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '14c78b59863f7a9b91e9a2422ac9144eb9d4c39d' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\vhostproduct/showProduct.html',
      1 => 1292920964,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '109094d1068879b7794-39003810',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg pal1">共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
	   <td class='color01 right' bgcolor='#efefef'><?php echo $_smarty_tpl->getVariable('lang')->value['product_id'];?>
</td>
        <td class='color01 right' bgcolor='#efefef'>产品名称</td>
		<td class='color01 right' bgcolor='#efefef'>空间配额(M)</td>
		<td class='color01 right' bgcolor='#efefef'>数据库配额(M)</td>
		<td class='color01 right' bgcolor='#efefef'>价格(分/年)</td>
		
		<td class='color01 right' bgcolor='#efefef'>模板</td>
		<td class='color01 right' bgcolor='#efefef'>主机</td>
		<td class='color01 right' bgcolor='#efefef'>状态</td>
        <td class='color01 right' bgcolor='#efefef'>操作</td>
      </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['web_quota'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['db_quota'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['price'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['templete'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['node'];?>
</td>
		<td class="right"><?php if ($_smarty_tpl->tpl_vars['row']->value['state']==0){?>暂停销售<?php }elseif($_smarty_tpl->tpl_vars['row']->value['state']==1){?>购买<?php }else{ ?>试用<?php }?></td>
        <td class="right">[<a href="javascript:if(confirm('确定删除<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
?')){location='?c=vhostproduct&a=del&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
';}}" title="删除">
        <img src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/b_drop.gif' alt='删除' border="0" align="absmiddle"></a>]
        [<a href="?c=vhostproduct&a=editProductForm&id=<?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
" title="更改信息">
        <img src='<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
images/b_edit.gif' alt='更改' border="0" align="absmiddle"></a>]
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
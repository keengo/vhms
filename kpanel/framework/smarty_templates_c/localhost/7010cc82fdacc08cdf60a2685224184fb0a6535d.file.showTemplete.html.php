<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 09:45:34
         compiled from "D:\project\janbao\kpanel\admin/views/default\vhostproduct/showTemplete.html" */ ?>
<?php /*%%SmartyHeaderCode:317264d05eb3edf49c2-51028837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7010cc82fdacc08cdf60a2685224184fb0a6535d' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\vhostproduct/showTemplete.html',
      1 => 1292233530,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '317264d05eb3edf49c2-51028837',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg pal1">
  [<a href="javascript:if(confirm('确定要刷新所有模板吗？这可能要耗点时间。')){window.location='?c=vhostproduct&a=refreshAllTemplete';}">刷新所有主机模板</a>]
  <p>共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</p>
</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
	   <td class='color01 right' bgcolor='#efefef'>主机</td>
        <td class='color01 right' bgcolor='#efefef'>模板</td>
		<td class='color01 right' bgcolor='#efefef'>权重</td>
		<td class='color01 right' bgcolor='#efefef'>状态</td>
		<td class='color01 right' bgcolor='#efefef'>操作</td>
      </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['node'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['templete'];?>
</td>
		<td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['weight'];?>
</td>
		<td class="right"><?php if ($_smarty_tpl->tpl_vars['row']->value['state']==1){?>有效<?php }else{ ?>无效<?php }?></td>
		<td class="right">[<a href="javascript:if(confirm('确定删除<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
?')){location='?c=vhostproduct&a=delTemplete&node=<?php echo $_smarty_tpl->tpl_vars['row']->value['node'];?>
&templete=<?php echo $_smarty_tpl->tpl_vars['row']->value['templete'];?>
';}" title="删除">
        删除</a>]
        [<a href="?c=vhostproduct&a=editTempleteForm&node=<?php echo $_smarty_tpl->tpl_vars['row']->value['node'];?>
&templete=<?php echo $_smarty_tpl->tpl_vars['row']->value['templete'];?>
">
       更改权重</a>]</td>
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
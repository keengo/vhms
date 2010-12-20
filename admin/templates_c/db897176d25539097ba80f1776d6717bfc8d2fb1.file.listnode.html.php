<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 17:55:04
         compiled from "D:\project\janbao\admin/view/default\listnode.html" */ ?>
<?php /*%%SmartyHeaderCode:167084d0f27f84339a9-20803745%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db897176d25539097ba80f1776d6717bfc8d2fb1' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\listnode.html',
      1 => 1292227179,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167084d0f27f84339a9-20803745',
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
    <table width="657" cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td width="88" bgcolor='#efefef' class='color01 right'>名称</td>
		<td width="81" bgcolor='#efefef' class='color01 right'>主机</td>
		<td width="81" bgcolor='#efefef' class='color01 right'>端口</td>
		<td width="81" bgcolor='#efefef' class='color01 right'>用户名</td>
        <td width="339" bgcolor='#efefef' class='color01 right'>操作</td>
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
        删除</a>]
        [<a href="?c=nodes&a=editForm&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
" title="更改信息">更改信息
        </a>]
		[<a href='?c=vhostproduct&a=refreshTemplete&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
'>刷新模板</a>][<a href="?c=vhostproduct&a=exportConfig&name=<?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
">导出配置文件</a>] </td>
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
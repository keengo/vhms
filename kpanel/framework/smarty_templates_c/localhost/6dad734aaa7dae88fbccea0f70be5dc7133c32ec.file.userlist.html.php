<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 01:53:57
         compiled from "D:\project\janbao\kpanel\admin/views/default\adminuser/userlist.html" */ ?>
<?php /*%%SmartyHeaderCode:62894d057cb535d355-58591700%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6dad734aaa7dae88fbccea0f70be5dc7133c32ec' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\adminuser/userlist.html',
      1 => 1292205232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '62894d057cb535d355-58591700',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -> 用户列表</div>
<div class="topimg pal1">共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td class='color01 right' bgcolor='#efefef'>用户名</td>
        <td class='color01 right' bgcolor='#efefef'>操作</td>
      </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
        <td class="right"><?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
</td>
        <td>
		[<a href="javascript:if(confirm('确定删除<?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
?')){location='?c=adminuser&a=del&username=<?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
';}" title="删除用户"><img src='images/b_drop.gif' alt='删除用户' border="0" align="absmiddle"></a>]
		</td>
      </tr>
	  <?php }} ?>
    </table>
    <div align="left">
	</div>
  </div>
</div>
</body>
</html>

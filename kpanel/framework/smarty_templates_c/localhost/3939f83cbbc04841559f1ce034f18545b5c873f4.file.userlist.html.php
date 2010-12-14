<?php /* Smarty version Smarty-3.0.5, created on 2010-12-14 06:19:36
         compiled from "D:\project\janbao\kpanel\user/views/default\user/userlist.html" */ ?>
<?php /*%%SmartyHeaderCode:119794d070c78373722-56686429%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3939f83cbbc04841559f1ce034f18545b5c873f4' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\user/views/default\\user/userlist.html',
      1 => 1292296878,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '119794d070c78373722-56686429',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">
  <form name="form1" method="post" action="?c=<?php echo $_smarty_tpl->getVariable('_c')->value;?>
&a=<?php echo $_smarty_tpl->getVariable('_a')->value;?>
">
    用户名:
    <input name="username" type="text" id="username">
    <input type="submit" name="Submit" value="搜索">
  </form>
  </div>
<div class="topimg pal1">共计 <?php echo $_smarty_tpl->getVariable('sum')->value;?>
 条记录</div>
  <div id="main" class="wid"> 
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td class='color01 right' bgcolor='#efefef'>用户名</td>
		<td class='color01 right' bgcolor='#efefef'>真实姓名</td>
		<td class='color01 right' bgcolor='#efefef'>身份号码</td>
		<td class='color01 right' bgcolor='#efefef'>电子邮件</td>
		<td class='color01 right' bgcolor='#efefef'>注册时间</td>
		<td class='color01 right' bgcolor='#efefef'>余额(分)</td>
		<td class='color01 right' bgcolor='#efefef'>操作</td>
	  </tr>
	  <?php  $_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('list')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['row']->key => $_smarty_tpl->tpl_vars['row']->value){
?>
      <tr>
	  <td ><a href="?c=user&a=editForm&username=<?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
</a></td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['name'];?>
</td>
		 <td><?php echo $_smarty_tpl->tpl_vars['row']->value['id'];?>
</td>
		  <td><?php echo $_smarty_tpl->tpl_vars['row']->value['email'];?>
</td>
		   <td><?php echo $_smarty_tpl->tpl_vars['row']->value['regtime'];?>
</td>
		 <td><a href="?c=user&a=editMoneyForm&username=<?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
"><?php echo $_smarty_tpl->tpl_vars['row']->value['money'];?>
</a></td>
		<td class="right">[<a href="?c=user&a=editForm&username=<?php echo $_smarty_tpl->tpl_vars['row']->value['username'];?>
" title="更改信息">更改</a>][进入管理]</td>
	  </tr>
	  <?php }} ?>
    </table>
   </div>
</div>
</body>
</html>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
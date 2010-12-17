<?php /* Smarty version Smarty-3.0.5, created on 2010-12-17 07:15:06
         compiled from "D:\project\janbao\kpanel\admin/view/default\user/moneyedit.html" */ ?>
<?php /*%%SmartyHeaderCode:254864d0b0dfa85b596-68443202%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'eca05cb2f34984df088856ba82e6e2dc5b10be9a' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/view/default\\user/moneyedit.html',
      1 => 1292297348,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '254864d0b0dfa85b596-68443202',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：<span class="color01 right">增减余额</span></div>
  <div id="main" class="wid">
  <form  action="?c=user&a=editMoney&username=<?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
" method='post'>
    <table cellpadding=0 cellspacing=1>
      <tr>
        <td width="99" bgcolor='#efefef' class='color01 right'>用户名</td>
        <td width="168"><?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
</td>
      </tr>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>当前余额(分)</td>
        <td><?php echo $_smarty_tpl->getVariable('user')->value['money'];?>
</td>
      </tr>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>增减余额(分)<br></td>
        <td><input name='money' id="money" value="0"/></td>
      </tr>
	   <tr>
        <td colspan="2" bgcolor='#efefef' class='color01 center' align="center"><button type="submit">
          修改
          </button></td>
        </tr>
    </table>
	<div>
	<!--S 协议--><!--E 协议-->
	</div>
	</form>
  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:16:55
         compiled from "D:\project\janbao\user/view/default\changePassword.html" */ ?>
<?php /*%%SmartyHeaderCode:312954d0f10f7b07bd6-71991358%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'edfe7f721afa9ac357cb9b65386bca4cf85a6680' => 
    array (
      0 => 'D:\\project\\janbao\\user/view/default\\changePassword.html',
      1 => 1292824772,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '312954d0f10f7b07bd6-71991358',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000">
<script language="javascript">
function checkPassword()
{
	if(frm.passwd.value==""){
		alert('新密码不能为空');
		return;
	}
	if(frm.passwd.value!=frm.passwd2.value){
		alert('两次密码不相等');
		return;
	}
	frm.submit();
}
</script>
<div id="container">
<div class="topimg"></div>
  <div id="main" class="wid">
  <form name='frm' action="?c=session&a=changePassword" method="post">
    <table>
      <tr>
        <td bgcolor='#efefef' class='color01 right'>旧密码</td>
        <td><input type='password' name='oldpasswd' id='oldpasswd' ></td>
      </tr>
      <tr>
        <td bgcolor='#efefef' class='color01 right'>新密码</td>
        <td><input type='password' name='passwd' id='passwd' ></td>
      </tr>
		<tbody>
		<tr>
        <td width="131" bgcolor='#efefef' class='color01 right'>确认新密码</td>
        <td width="312"><input type='password' name='passwd2' id='passwd2'></td>
      </tr>
		  	  	 	   <tr>
        <td class="color01 right" bgcolor="#efefef"></td>
        <td>
	 <button type="button" onClick="checkPassword()">确定</button>  </td>
      </tr>
    </tbody></table>
  </form>

  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:58:17
         compiled from "D:\project\janbao/view/default\session/changePassword.html" */ ?>
<?php /*%%SmartyHeaderCode:167674d12c8d934ff55-29575737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '16ccbd221d2c33bf278e1910cfbff6e5f7bf0620' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\session/changePassword.html',
      1 => 1293074642,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '167674d12c8d934ff55-29575737',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<script language="javascript">
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

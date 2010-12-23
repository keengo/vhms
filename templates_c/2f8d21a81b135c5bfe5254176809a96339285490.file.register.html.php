<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 12:12:17
         compiled from "D:\project\janbao/view/default\public/register.html" */ ?>
<?php /*%%SmartyHeaderCode:112074d12cc21a3a543-86205490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f8d21a81b135c5bfe5254176809a96339285490' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\public/register.html',
      1 => 1293074848,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112074d12cc21a3a543-86205490',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script language="javascript">
function show(url) 
{ 
	window.open(url,'','height=100,width=250,resize=no,scrollbars=no,toolsbar=no,top=200,left=200');
}
function check_user()
{
	show('?c=public&a=checkUser&username='+document.reg.username.value);
}
function check_register()
{
	if(reg.username.value.length<3){
		alert('用户名长度最小为3个字母');
		return false;
	}
	if(reg.passwd.value.length<5){
		alert('密码长度最小要6位');
		return false;
	}
	if(reg.passwd.value!=reg.passwd2.value){
		alert('两次密码不对');
		return false;
	}
	if(reg.email.value==""){
		alert('电子邮件不能为空');
		return false;
	}
	if(!reg.agree.checked){
		alert('您还没有同意注册协议');
		return false;
	}
	reg.submit();
}
</script>
<div id="container">
<div class="topimg"></div>
  <div id="main" class="wid">
  <form  name='reg' action="?c=public&a=register" method='post'>
    <table cellpadding=0 cellspacing=1 align=center>
      <tr>
        <td width="71" bgcolor='#efefef' class='color01 right'>用户名</td>
        <td ><input name='username' type='text' id='username' onBlur="checkUsername();" value="" size="10"/>
          <span class="STYLE1">*</span>
           <input type="button" name="Submit" value="检测用户名" onClick="check_user()">
        </td>
      </tr>

	  <tr>
        <td class='color01 right' bgcolor='#efefef'>密码</td>
        <td><input name='passwd' type='password' id='passwd' value="" size="16"/>
        <span id='check'><span class="STYLE1">*</span></span></td>
      </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>确认密码</td>
	    <td><input name='passwd2' type='password' id='passwd2'  value="" size="16"/>
	      <span id='check'><span class="STYLE1">*</span></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>电子邮件</td>
	    <td><input name='email' type='text' id='email' value="" size="16"/>
	      <span class="STYLE1">*</span>&nbsp;&nbsp;<span id='check'></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>真实姓名</td>
	    <td><input name='name' type='text' id='name'  value="" size="12"/>
	      &nbsp;&nbsp;<span id='check'></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>身份证</td>
	    <td><input type='text' name='id' id='id' value="" />
	      &nbsp;&nbsp;<span id='check'></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>&nbsp;</td>
	    <td>&nbsp;&nbsp;
	      <input name="agree" type="checkbox" id="agree" value="1">
	      我已阅读并同意<a href="?c=">注册协议</a></td>
	    </tr>

	   <tr>
        <td class='color01 right' bgcolor='#efefef'></td>
        <td><button type="button" onClick="check_register()">注册</button></td>
      </tr>
    </table>
	<div>
	<!--S 协议--><!--E 协议-->
	</div>
	</form>
  </div>
</div>

<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:53:48
         compiled from "D:\project\janbao\user/view/default\login.html" */ ?>
<?php /*%%SmartyHeaderCode:209184d106b1c087224-76809250%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b260931a17a529d44275f859f4d019ccfb1cbaf9' => 
    array (
      0 => 'D:\\project\\janbao\\user/view/default\\login.html',
      1 => 1292826603,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '209184d106b1c087224-76809250',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
!{include file='common/head.html'}
<body>
<link rel="stylesheet" rev="stylesheet" href="!{$STATIC}style/login.css" type="text/css" media="all" />
<div id="header"></div>

<div id="login">
	<div id="logo">用户控制面板</div>

	<div id="warning"></div>
	<div id="login_top"></div>
	<div id="login_main">
		<form action="index.php?c=session&a=login" method=post name="form1" onSubmit='return ValidateForm()'>
		<div class="input_title">用户名</div>
		<div class="input_box" style="margin-bottom:10px;"><input type="text" name="username" /></div>
		<div class="input_title">密码</div>
		<div class="input_box">		
		<input type="password" name="passwd" /></div>
		<div class="login_button">
		<input type="submit" value="登 录" />
		</div>
		</form>
	</div>
	<div id="login_bottom"></div>
</div>
</body>

  <SCRIPT>
function ValidateForm() 
{
	if ( document.form1.LoginName.value=="" || document.form1.LoginPass.value=="" || document.form1.CheckCode.value=="") 
		{
		alert("please enter ur name and passwd and checkcode!");
		return false;
	}
	else { 
		return true;
	}
}
</SCRIPT>

</html>
											
<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:53:53
         compiled from "D:\project\janbao\vhost/view/default\login.html" */ ?>
<?php /*%%SmartyHeaderCode:56684d106b21302977-82774728%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aafdabbdbca5b68c893936ece0b88fb96968b4fb' => 
    array (
      0 => 'D:\\project\\janbao\\vhost/view/default\\login.html',
      1 => 1292826628,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '56684d106b21302977-82774728',
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
	<div id="logo">虚拟主机控制面板</div>

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
											
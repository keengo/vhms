<?php /* Smarty version Smarty-3.0.5, created on 2010-12-15 07:45:42
         compiled from "D:\project\janbao\kpanel\admin/views/default\login.html" */ ?>
<?php /*%%SmartyHeaderCode:235994d087226548bc4-71454067%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2b14fc1096f84ce5fe633dc53d64f65c20b57df' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\login.html',
      1 => 1292399138,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '235994d087226548bc4-71454067',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body>
<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/login.css" type="text/css" media="all" />
<div id="header"></div>

<div id="login">
	<div id="logo">主机管理后台</div>

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
											
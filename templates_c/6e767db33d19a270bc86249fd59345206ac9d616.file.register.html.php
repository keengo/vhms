<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 12:04:38
         compiled from "D:\project\janbao/view/default\register.html" */ ?>
<?php /*%%SmartyHeaderCode:192034d1027562c0ff7-03836526%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6e767db33d19a270bc86249fd59345206ac9d616' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\register.html',
      1 => 1292901809,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '192034d1027562c0ff7-03836526',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<style type="text/css">
<!--
.STYLE1 {color: #FF0000}
-->
</style>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -&gt; 增加用户</div>
  <div id="main" class="wid">
  <form  action="?c=user&a=insert" method='post'>
    <table cellpadding=0 cellspacing=1>
      <tr>
        <td width="71" bgcolor='#efefef' class='color01 right'>用户名</td>
        <td width="173"><input name='username' type='text' id='username' onBlur="checkUsername();" value="" size="10"/>
          <span class="STYLE1">*</span>
            <button type="submit">检查 </button>
          <span id='check'></span></td>
      </tr>

	  <tr>
        <td class='color01 right' bgcolor='#efefef'>密码</td>
        <td><input name='passwd' type='password' id='passwd' value="" size="12"/>&nbsp;&nbsp;<span id='check'><span class="STYLE1">*</span></span></td>
      </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>确认密码</td>
	    <td><input name='passwd2' type='password' id='passwd2' onBlur="checkPasswd();" value="" size="12"/>
	      &nbsp;&nbsp;<span id='check'><span class="STYLE1">*</span></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>电子邮件</td>
	    <td><input name='email' type='password' id='email' onBlur="checkPasswd();" value="" size="16"/>
	      <span class="STYLE1">*</span>&nbsp;&nbsp;<span id='check'></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>真实姓名</td>
	    <td><input name='name' type='password' id='name' onBlur="checkPasswd();" value="" size="12"/>
	      &nbsp;&nbsp;<span id='check'></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>身份证</td>
	    <td><input type='text' name='id' id='id' value="" onBlur="checkPasswd();"/>
	      &nbsp;&nbsp;<span id='check'></span></td>
	    </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>&nbsp;</td>
	    <td>&nbsp;&nbsp;
	      <input type="checkbox" name="checkbox" value="checkbox">
	      我已阅读并同意<a href="?c=">注册协议</a></td>
	    </tr>

	   <tr>
        <td class='color01 right' bgcolor='#efefef'></td>
        <td><button type="submit">注册</button></td>
      </tr>
    </table>
	<div>
	<!--S 协议-->
	请阅读服务协议
	<!--E 协议-->
	</div>
	</form>
  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
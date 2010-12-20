<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 17:55:01
         compiled from "D:\project\janbao\admin/view/default\user/useradd.html" */ ?>
<?php /*%%SmartyHeaderCode:9204d0f27f51142a4-72024815%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0efdc8fbe7dea36c878b1e80beddacfe492f48e1' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\user/useradd.html',
      1 => 1291967478,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9204d0f27f51142a4-72024815',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -&gt; 增加用户</div>
  <div id="main" class="wid">
  <form  action="?c=user&a=insert" method='post'>
    <table cellpadding=0 cellspacing=1>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>用户名</td>
        <td><input type='text' name='username' id='username' value="" onblur="checkUsername();"/>&nbsp;&nbsp;<span id='check'></span></td>
      </tr>

	  <tr>
        <td class='color01 right' bgcolor='#efefef'>密码</td>
        <td><input type='password' name='passwd' id='passwd' value=""/>&nbsp;&nbsp;<span id='check'></span></td>
      </tr>
	  <tr>
        <td class='color01 right' bgcolor='#efefef'>确认密码</td>
        <td><input type='password' name='passwd2' id='passwd2' value="" onblur="checkPasswd();"/>&nbsp;&nbsp;<span id='check'></span></td>
      </tr>

	   <tr>
        <td class='color01 right' bgcolor='#efefef'></td>
        <td><button type="submit">同意以下服务条款，提交注册信息</button></td>
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
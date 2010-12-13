<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 02:00:45
         compiled from "D:\project\janbao\kpanel\admin/views/default\adminuser/useradd.html" */ ?>
<?php /*%%SmartyHeaderCode:145674d057e4dac3409-17822757%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '168ded600d26b69e936b49d8fcc7524d3ea3afd0' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\adminuser/useradd.html',
      1 => 1292205449,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '145674d057e4dac3409-17822757',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
<title>主机列表</title>
<link rel='stylesheet' type='text/css' href='/css/style.css'>
<script language="javascript" src="scripts/jquery.js"></script>
<script language="javascript" src="scripts/common.js"></script>
</head>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -&gt; 增加管理员用户</div>
  <div id="main" class="wid">
  <form  action="?c=adminuser&a=insert" method='post'>
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
        <td><button type="submit">增加</button></td>
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
</html>
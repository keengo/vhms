<?php /* Smarty version Smarty-3.0.5, created on 2010-12-10 14:14:36
         compiled from "I:\janbao\kpanel\admin/views/default\adminuser/userlist.html" */ ?>
<?php /*%%SmartyHeaderCode:60114d0235cc8b2353-95959480%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f1ab459f20107691267b3744cacd4fc2923d081' => 
    array (
      0 => 'I:\\janbao\\kpanel\\admin/views/default\\adminuser/userlist.html',
      1 => 1291953828,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '60114d0235cc8b2353-95959480',
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
</head>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -> 用户列表</div>
<div class="topimg pal1">共计 <<?php ?>%$sum%<?php ?>> 条记录</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td class='color01 right' bgcolor='#efefef'>用户名</td>
      </tr>
	  <<?php ?>%foreach from=$list item=row%<?php ?>>
      <tr>
        <td class="right"><a href="/?c=user&a=info&username=<<?php ?>%$row.username%<?php ?>>"><<?php ?>%$row.username%<?php ?>></a>
		[<a href="javascript:if(confirm('确定删除<<?php ?>%$row.username%<?php ?>>?')){location='/?c=user&a=delete&username=<<?php ?>%$row.username%<?php ?>>';}" title="删除用户"><img src='images/b_drop.gif' alt='删除用户' border="0" align="absmiddle"></a>][<a href="/?c=user&a=edit&username=<<?php ?>%$row.username%<?php ?>>" title="更改信息"><img src='images/b_edit.gif' alt='更改信息' border="0" align="absmiddle"></a>]
		</td>
      </tr>
	  <<?php ?>%/foreach%<?php ?>>
    </table>
    <div align="left">
	</div>
  </div>
</div>
</body>
</html>

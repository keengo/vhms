<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:43:10
         compiled from "D:\project\janbao\admin/view/default\vhostproduct/showVhost.html" */ ?>
<?php /*%%SmartyHeaderCode:53444d10689ee09de5-57310683%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '95ff9aa243583414fecd401d299e0b011ea2b8f0' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\vhostproduct/showVhost.html',
      1 => 1292900715,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '53444d10689ee09de5-57310683',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿!{include file='common/head.html'}
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000"> 
 <form name="form1" method="post" action="?c=vhostproduct&a=showVhost">
    输入ftp用户名或#uid或域名
    <input name="user" type="text" id="user" value="!{$user}">
    <input type="submit" name="Submit" value="搜索">
  </form>
<div id="container">

  !{if $row}
  
    <table width="224" border="1">
    <tr>
      <td>用户名</td>
      <td>!{$row.name}</td>
    </tr>
    <tr>
      <td width="75">UID</td>
      <td width="133">!{$row.uid}</td>
    </tr>

    <tr>
      <td>所属用户</td>
      <td>!{$row.username}</td>
    </tr>
    <tr>
      <td>产品ID</td>
      <td>!{$row.product_id}</td>
    </tr>
    <tr>
      <td>网页大小</td>
      <td>!{$row.web_quota}</td>
    </tr>
    <tr>
      <td>数据库大小</td>
      <td>!{$row.db_quota}</td>
    </tr>
    <tr>
      <td>所在服务器</td>
      <td>!{$row.node}</td>
    </tr>
    <tr>
      <td>创建时间</td>
      <td>!{$row.create_time}</td>
    </tr>
    <tr>
      <td>过期时间</td>
      <td>!{$row.expire_time}</td>
    </tr>
	<tr>
      <td>状态</td>
      <td>!{$row.state}</td>
    </tr>
  </table>
  !{if $list}
  <table >
  <tr id="ttitle"><td class='color01 right' bgcolor='#efefef'>域名</td><td class='color01 right' bgcolor='#efefef'>目录</td></tr>
  !{foreach from=$list item=row}
  <tr><td>!{$row.domain}</td><td>!{$row.dir}</td></tr>
  !{/foreach}
  !{/if}
  </table>
  !{/if}  
</div>
</body>
!{include file='common/foot.html'}
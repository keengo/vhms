<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:04:03
         compiled from "D:\project\janbao\admin/view/default\adminuser/userlist.html" */ ?>
<?php /*%%SmartyHeaderCode:48364d105f73ca57a8-86539126%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1721add7d0565d3cc399ead85f0b9e4cafcf4065' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\adminuser/userlist.html',
      1 => 1292205232,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '48364d105f73ca57a8-86539126',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
!{include file='common/head.html'}
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -> 用户列表</div>
<div class="topimg pal1">共计 !{$sum} 条记录</div>
  <div id="main" class="wid">
    <table cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td class='color01 right' bgcolor='#efefef'>用户名</td>
        <td class='color01 right' bgcolor='#efefef'>操作</td>
      </tr>
	  !{foreach from=$list item=row}
      <tr>
        <td class="right">!{$row.username}</td>
        <td>
		[<a href="javascript:if(confirm('确定删除!{$row.username}?')){location='?c=adminuser&a=del&username=!{$row.username}';}" title="删除用户"><img src='images/b_drop.gif' alt='删除用户' border="0" align="absmiddle"></a>]
		</td>
      </tr>
	  !{/foreach}
    </table>
    <div align="left">
	</div>
  </div>
</div>
</body>
</html>

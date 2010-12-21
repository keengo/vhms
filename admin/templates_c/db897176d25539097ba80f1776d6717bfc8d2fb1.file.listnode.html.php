<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:40:32
         compiled from "D:\project\janbao\admin/view/default\listnode.html" */ ?>
<?php /*%%SmartyHeaderCode:298964d106800dbb2a9-01438887%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db897176d25539097ba80f1776d6717bfc8d2fb1' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\listnode.html',
      1 => 1292227179,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '298964d106800dbb2a9-01438887',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿!{include file='common/head.html'}
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：主机管理 -> 主机列表 -> 返回<a href="/?c=user&a=listvh&username=!{$username}">!{$username}</></div>
<div class="topimg pal1">共计 !{$sum} 条记录</div>
  <div id="main" class="wid">
    <table width="657" cellpadding=0 cellspacing=1 id="table">
      <tr id="ttitle">
        <td width="88" bgcolor='#efefef' class='color01 right'>名称</td>
		<td width="81" bgcolor='#efefef' class='color01 right'>主机</td>
		<td width="81" bgcolor='#efefef' class='color01 right'>端口</td>
		<td width="81" bgcolor='#efefef' class='color01 right'>用户名</td>
        <td width="339" bgcolor='#efefef' class='color01 right'>操作</td>
      </tr>
	  !{foreach from=$list item=row}
      <tr>
        <td class="right">!{$row.name}</td>
		<td class="right">!{$row.host}</td>
		<td class="right">!{$row.port}</td>
		<td class="right">!{$row.user}</td>
        <td class="right">[<a href="javascript:if(confirm('确定删除!{$row.name}?')){location='?c=nodes&a=del&name=!{$row.name}';}" title="删除主机">
        删除</a>]
        [<a href="?c=nodes&a=editForm&name=!{$row.name}" title="更改信息">更改信息
        </a>]
		[<a href='?c=vhostproduct&a=refreshTemplete&name=!{$row.name}'>刷新模板</a>][<a href="?c=vhostproduct&a=exportConfig&name=!{$row.name}">导出配置文件</a>] </td>
      </tr>
	  !{/foreach}
    </table>
    <div align="left">
	</div>
  </div>
</div>
</body>
!{include file='common/foot.html'}
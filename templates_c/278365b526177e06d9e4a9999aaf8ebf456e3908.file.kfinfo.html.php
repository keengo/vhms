<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 09:43:43
         compiled from "D:\project\janbao/view/default\kfinfo.html" */ ?>
<?php /*%%SmartyHeaderCode:161774d12a94f85cd14-03281490%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '278365b526177e06d9e4a9999aaf8ebf456e3908' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\kfinfo.html',
      1 => 1292400996,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '161774d12a94f85cd14-03281490',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
!{include file='common/head.html'}
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<table width="329" border="1" align="center">
  <tr>
    <td width="99">用户名</td>
    <td width="214">!{$user.username}</td>
  </tr>
  <tr>
    <td>姓名</td>
    <td>!{$user.name}</td>
  </tr>
  <tr>
    <td>身份证</td>
    <td>!{$user.id}</td>
  </tr>
  <tr>
    <td>电子邮件</td>
    <td>!{$user.email}</td>
  </tr>
  <tr>
    <td>账户余额(元)</td>
    <td>!{$user.money/100}</td>
  </tr>
</table>
<div id="container">
<div class="topimg">
</div>
</div>
</body>
</html>

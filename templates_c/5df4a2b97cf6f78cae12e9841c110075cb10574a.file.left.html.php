<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 13:39:23
         compiled from "D:\project\janbao/view/default\user/left.html" */ ?>
<?php /*%%SmartyHeaderCode:157894d12e08ba4ea10-36434846%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5df4a2b97cf6f78cae12e9841c110075cb10574a' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\user/left.html',
      1 => 1293082760,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '157894d12e08ba4ea10-36434846',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<link rel="stylesheet" rev="stylesheet" href="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
style/left.css" type="text/css" media="all" />

<table cellpadding="0" cellspacing="0" class="lefttd">
<tr><td width="154">
<script type="text/javascript">

function SwitchMenu(obj,sty)
{
}
</script>
<div id="masterdiv">
	<h1 id="m5" onClick="SwitchMenu('sub5','m5')" class="menu">
	  帐户管理
	</h1>
	<ul class="submenu" id="sub5" >
		<li><a href="?c=user&a=index" >帐户信息</a></li>
		<li><a href="?c=user&a=changeForm" >修改资料</a></li>
		<li><a href="?c=session&a=changePasswordForm" >修改密码</a></li>
	    <li><a href="?c=session&a=logout" >退出</a></li>
	</ul>
	<!-- 
	<h1 id="m4" onClick="SwitchMenu('sub4','m4')" class="menu">财务管理</h1>
	<ul class="submenu" id="sub4" >
		<li><a href="">充值金额</a></li>	
		<li><a href="?c=nodes&a=addNode" >消费记录</a></li>
		<li><a href="?c=nodes&a=addNode" >充值记录</a></li>
	    </ul>
	-->
	<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu">	
	    我的产品	 
	</h1>
	<ul class="submenu" id="sub6" >
	    <li><a href="?c=vhostproduct&a=show">我的虚拟主机</a></li>
		</ul>
</div>
</td></tr>
</table>

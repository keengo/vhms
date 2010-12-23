<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 09:43:43
         compiled from "D:\project\janbao/view/default\left.html" */ ?>
<?php /*%%SmartyHeaderCode:186344d12a94f60eb60-19798395%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a38c1a0f14ae93754e31b38b50952ca63e1f7ba8' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\left.html',
      1 => 1292994856,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '186344d12a94f60eb60-19798395',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body style="overflow-x:hidden; overflow-y:auto;">
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
		<li><a href="?c=index&a=main" target='main'>帐户信息</a></li>
		<li><a href="?c=session&a=changePasswordForm" target='main'>修改密码</a></li>
	    <li><a href="?c=session&a=logout" target='_top'>退出</a></li>
	</ul>
	<h1 id="m4" onClick="SwitchMenu('sub4','m4')" class="menu">财务管理</h1>
	<ul class="submenu" id="sub4" >
		<li><a href="">充值金额</a></li>	
		<li><a href="?c=nodes&a=addNode" target='main'>消费记录</a></li>
		<li><a href="?c=nodes&a=addNode" target='main'>充值记录</a></li>
	    </ul>
	<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu">	
	    我的产品	 
	</h1>
	<ul class="submenu" id="sub6" >
	    <li><a href="?c=vhostproduct&a=show" target='main'>我的虚拟主机</a></li>
		</ul>
</div>
</td></tr>
</table>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
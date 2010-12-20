<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 17:54:23
         compiled from "D:\project\janbao\admin/view/default\left.html" */ ?>
<?php /*%%SmartyHeaderCode:279574d0f27cfac1e29-36723372%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '85ce7d1d451d5350ef0c35ce293d96f4ccadedc5' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\left.html',
      1 => 1292827713,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '279574d0f27cfac1e29-36723372',
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
<tr><td>
<script type="text/javascript">

function SwitchMenu(obj,sty)
{
/*	if(document.getElementById)
	{
	var el = document.getElementById(obj);
	var ml = document.getElementById(sty);
	var ar = document.getElementById("masterdiv").getElementsByTagName("ul"); 
	var mr = document.getElementById("masterdiv").getElementsByTagName("h1"); 
		if(el.style.display != "block")
		{ 
			for (var i=0; i<ar.length; i++)
			{
				if (ar[i].className == "submenu")
				ar[i].style.display = "none";	
				if (mr[i].className == "menu1")
				mr[i].className = "menu";	
			}
			el.style.display = "block";
			ml.className ="menu1";
		}
		else
		{
			el.style.display = "none";
			ml.className ="menu";
		}
	}
	*/
}
</script>
<div id="masterdiv">
<h1 id="m2" onClick="SwitchMenu('sub2','m2')" class="menu"><ol id="p2">账号管理</ol></h1>
	<ul class="submenu" id="sub2" >
		<li><a href="?c=index&a=main" target='main'>我的信息</a></li>	
		<li><a href="?c=session&a=changePasswordForm" target='main'>修改密码</a></li>	
		<li><a href="?c=session&a=logout" target='_top'>退出登录</a></li>
	</ul>
<h1 id="m3" onClick="SwitchMenu('sub3','m3')" class="menu"><ol id="p3">管理员管理</ol></h1>
	<ul class="submenu" id="sub3" >
		<li><a href="?c=adminuser&a=listUser" target='main'>管理员列表</a></li>	
		<li><a href="?c=adminuser&a=add" target='main'>增加管理员</a></li>
		<li><a href="?c=session&a=logout" target='_top'>退出登录</a></li>
	</ul>
	<h1 id="m5" onClick="SwitchMenu('sub5','m5')" class="menu"><ol id="p5">用户管理</ol></h1>
	<ul class="submenu" id="sub5" >
		<li><a href="?c=user&a=listUser" target='main'>用户列表</a></li>
		<li><a href="?c=user&a=add" target='main'>增加用户</a></li>	
	</ul>
	<h1 id="m4" onClick="SwitchMenu('sub4','m4')" class="menu"><ol id="p4">主机管理</ol></h1>
	<ul class="submenu" id="sub4" >
		<li><a href="?c=nodes&a=listNode" target='main'>主机列表</a></li>	
		<li><a href="?c=nodes&a=addNode" target='main'>增加主机</a></li>
	</ul>
	<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu"><ol id="p6">
	  虚拟主机产品
	</ol>
	</h1>
	<ul class="submenu" id="sub6" >
		<li><a href="?c=vhostproduct&a=showProduct" target='main'>产品列表</a></li>	
		<li><a href="?c=vhostproduct&a=addProductForm" target='main'>增加产品</a></li>
	</ul>
</div>
</td></tr>
</table>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
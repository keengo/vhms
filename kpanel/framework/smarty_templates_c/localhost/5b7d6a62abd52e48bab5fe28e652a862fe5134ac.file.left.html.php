<?php /* Smarty version Smarty-3.0.5, created on 2010-12-17 07:08:25
         compiled from "D:\project\janbao\kpanel\admin/view/default\left.html" */ ?>
<?php /*%%SmartyHeaderCode:63784d0b0c69880898-13048699%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5b7d6a62abd52e48bab5fe28e652a862fe5134ac' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/view/default\\left.html',
      1 => 1292558092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '63784d0b0c69880898-13048699',
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
	<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu"><ol id="p6">虚拟主机产品管理</ol></h1>
	<ul class="submenu" id="sub6" >
		<li><a href="?c=vhostproduct&a=showTemplete" target='main'>模板列表</a></li>
		<li><a href="?c=vhostproduct&a=showProduct" target='main'>产品列表</a></li>	
		<li><a href="?c=vhostproduct&a=addProductForm" target='main'>增加产品</a></li>
	</ul>
</div>
</td></tr>
</table>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
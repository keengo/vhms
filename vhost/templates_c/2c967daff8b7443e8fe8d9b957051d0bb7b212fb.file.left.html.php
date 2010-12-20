<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:14:10
         compiled from "D:\project\janbao\vhost/view/default\left.html" */ ?>
<?php /*%%SmartyHeaderCode:195754d0f1052329e00-42007795%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c967daff8b7443e8fe8d9b957051d0bb7b212fb' => 
    array (
      0 => 'D:\\project\\janbao\\vhost/view/default\\left.html',
      1 => 1292826159,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '195754d0f1052329e00-42007795',
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
/*
	if(document.getElementById)
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

	<h1 id="m5" onClick="SwitchMenu('sub5','m5')" class="menu">
	账户管理
	</h1>
	<ul class="submenu" id="sub5" >
		<li><a href="?c=index&a=main" target='main'>帐户信息</a></li>
		<li><a href="?c=session&a=changePasswordForm" target='main'>修改密码</a></li>
	    <li><a href="?c=session&a=logout" target='_top'>退出</a></li>
	</ul>
		<h1 id="m5" onClick="SwitchMenu('sub5','m5')" class="menu">
	域名绑定
	</h1>
		<ul class="submenu" id="sub6" >
		<li><a href="?c=domain&a=show" target='main'>绑定域名列表</a></li>	
		<li><a href="?c=domain&a=addForm" target='main'>新增绑定域名</a></li>	
	</ul>
	</div>
</td></tr>
</table>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
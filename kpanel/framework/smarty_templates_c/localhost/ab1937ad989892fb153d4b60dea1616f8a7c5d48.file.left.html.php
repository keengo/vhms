<?php /* Smarty version Smarty-3.0.5, created on 2010-12-14 06:19:29
         compiled from "D:\project\janbao\kpanel\user/views/default\left.html" */ ?>
<?php /*%%SmartyHeaderCode:316634d070c71b96a83-94722769%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab1937ad989892fb153d4b60dea1616f8a7c5d48' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\user/views/default\\left.html',
      1 => 1292307559,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '316634d070c71b96a83-94722769',
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
	  帐户管理
	</h1>
	<ul class="submenu" id="sub5" >
		<li><a href="?c=user&a=listUser" target='main'>帐户信息</a></li>
		<li><a href="?c=user&a=add" target='main'>产品价格</a></li>	
	    <li>购物车</li>
	    <li>退出</li>
	</ul>
	<h1 id="m4" onClick="SwitchMenu('sub4','m4')" class="menu">财务管理</h1>
	<ul class="submenu" id="sub4" >
		<li><a href="http://www.512j.com/member/member.php?flag=add_fee">充值金额</a></li>	
		<li><a href="?c=nodes&a=addNode" target='main'>消费记录</a></li>
		<li><a href="?c=nodes&a=addNode" target='main'>充值记录</a></li>
	    </ul>
	<h1 id="m6" onClick="SwitchMenu('sub6','m6')" class="menu">
	
	    我的产品
	 
	</h1>
	<ul class="submenu" id="sub6" >
	    <li><a href="?c=vhostproduct&a=showTemplete" target='main'>我的虚拟主机</a></li>
		</ul>
</div>
</td></tr>
</table>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
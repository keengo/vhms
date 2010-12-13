<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 01:56:08
         compiled from "D:\project\janbao\kpanel\admin/views/default\addnode.html" */ ?>
<?php /*%%SmartyHeaderCode:247844d057d38242568-70443519%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3fa54a634aa5c6ef9ee31892d49fa74f2b2906c8' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\addnode.html',
      1 => 1291990420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '247844d057d38242568-70443519',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000">
<div id="container">
<div class="topimg">当前位置：主机管理 -> 增加主机</div>
  <div id="main" class="wid">
  <form name='nodeform' action="?c=nodes&a=<?php echo $_smarty_tpl->getVariable('action')->value;?>
&oldname=<?php echo $_smarty_tpl->getVariable('node')->value['name'];?>
" method="post">
    <table>
		<tbody>
		<tr>
        <td class='color01 right' bgcolor='#efefef'>名字</td>
        <td><input type='text' name='name' id='name' value="<?php echo $_smarty_tpl->getVariable('node')->value['name'];?>
" onBlur="checkName();"
        <?php if ($_smarty_tpl->getVariable('action')->value=="edit"){?>
        	readonly
        <?php }?>
        />
          &nbsp;<font color=red>*必填</font></td>
      </tr>
			<tr>
			 <td class="color01 right" bgcolor="#efefef">主机</td>
			 <td><input name="host" type="text" id="host" value="<?php echo $_smarty_tpl->getVariable('node')->value['host'];?>
">
		      <font color=red>*必填</font></td>
			</tr>
			<tr>
			 <td class="color01 right" bgcolor="#efefef">管理端口</td>
			 <td><input name="port" value="<?php echo $_smarty_tpl->getVariable('node')->value['port'];?>
" type="text">
			   <font color=red>*必填</font></td>
			</tr>
			<tr>
                <td class="color01 right" bgcolor="#efefef">用户名</td>
				<td><input name="user" type="text" id="user" value="<?php echo $_smarty_tpl->getVariable('node')->value['user'];?>
">
				   <font color=red>*必填</font></td>
		  </tr>
		  	  	 	  		  			  
		  	  	 	  		  			<tr>
			 <td class="color01 right" bgcolor="#efefef">密码</td>

			 <td><input name="passwd" type="text" id="passwd" value="<?php echo $_smarty_tpl->getVariable('node')->value['passwd'];?>
">
			   <font color=red>*必填</font></td>
			</tr>
		  	  	 	   <tr>
        <td class="color01 right" bgcolor="#efefef"></td>
        <td>
	 <button type="submit">确认提交</button>  </td>
      </tr>
    </tbody></table>
  </form>

  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
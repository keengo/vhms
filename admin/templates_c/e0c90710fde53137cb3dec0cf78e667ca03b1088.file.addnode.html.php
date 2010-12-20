<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 17:55:05
         compiled from "D:\project\janbao\admin/view/default\addnode.html" */ ?>
<?php /*%%SmartyHeaderCode:172504d0f27f9b3c6f4-44937591%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e0c90710fde53137cb3dec0cf78e667ca03b1088' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\addnode.html',
      1 => 1291990420,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '172504d0f27f9b3c6f4-44937591',
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
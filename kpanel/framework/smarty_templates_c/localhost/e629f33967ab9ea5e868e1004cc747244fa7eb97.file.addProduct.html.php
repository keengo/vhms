<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 10:49:58
         compiled from "D:\project\janbao\kpanel\admin/views/default\vhostproduct/addProduct.html" */ ?>
<?php /*%%SmartyHeaderCode:258794d05fa56ed9e55-64530600%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e629f33967ab9ea5e868e1004cc747244fa7eb97' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\vhostproduct/addProduct.html',
      1 => 1292237386,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '258794d05fa56ed9e55-64530600',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000">
<div id="container">
<div class="topimg"><?php if ($_smarty_tpl->getVariable('action')->value=='addProduct'){?>增加虚拟主机产品<?php }else{ ?>修改虚拟主机产品<?php }?></div>
  <div id="main" class="wid">
  <form name='nodeform' action="?c=vhostproduct&a=<?php echo $_smarty_tpl->getVariable('action')->value;?>
&id=<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['id'];?>
" method="post">
    <table>
		<tbody>
		<tr>
        <td width="131" bgcolor='#efefef' class='color01 right'>产品名称</td>
        <td width="312"><input type='text' name='name' id='name' value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['name'];?>
" onBlur="checkName();"><font color=red>*必填</font></td>
      </tr>
			
			<tr>
			 <td class="color01 right" bgcolor="#efefef">空间大小(M)</td>
			 <td><input name="web_quota" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['web_quota'];?>
" type="text">
			   <font color=red>*必填</font></td>
			</tr>
			<tr>
                <td class="color01 right" bgcolor="#efefef">数据库大小(M)</td>
				<td><input name="db_quota" type="text" id="db_quota" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['db_quota'];?>
">
				   <font color=red>*必填</font></td>
		  </tr>		  	  	 	  		  			  
		  	 <tr>
			 <td class="color01 right" bgcolor="#efefef">模板</td>
			 <td><select name='templete'>
			 <?php  $_smarty_tpl->tpl_vars['templete'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('templetes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['templete']->key => $_smarty_tpl->tpl_vars['templete']->value){
?>
			 <option value='<?php echo $_smarty_tpl->tpl_vars['templete']->value;?>
' <?php if ($_smarty_tpl->tpl_vars['templete']->value==$_smarty_tpl->getVariable('vhostproduct')->value['templete']){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['templete']->value;?>
</option>
			 <?php }} ?>
			 </select></td>
			</tr>
		  	  	 	   <tr>
        <td class="color01 right" bgcolor="#efefef"></td>
        <td>
	 <button type="submit">确定</button>  </td>
      </tr>
    </tbody></table>
  </form>

  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
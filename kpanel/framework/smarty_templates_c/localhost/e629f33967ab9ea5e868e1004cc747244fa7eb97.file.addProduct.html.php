<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 05:32:10
         compiled from "D:\project\janbao\kpanel\admin/views/default\vhostproduct/addProduct.html" */ ?>
<?php /*%%SmartyHeaderCode:143264d05afdac73285-46362155%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e629f33967ab9ea5e868e1004cc747244fa7eb97' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\vhostproduct/addProduct.html',
      1 => 1292215107,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143264d05afdac73285-46362155',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000">
<div id="container">
<div class="topimg">增加虚拟主机产品</div>
  <div id="main" class="wid">
  <form name='nodeform' action="?c=vhostproduct&a=<?php echo $_smarty_tpl->getVariable('action')->value;?>
&id=<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['id'];?>
" method="post">
    <table>
		<tbody>
		<tr>
        <td width="103" bgcolor='#efefef' class='color01 right'>产品名称</td>
        <td width="340"><input type='text' name='name' id='name' value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['name'];?>
" onBlur="checkName();"><font color=red>*必填</font></td>
      </tr>
			
			<tr>
			 <td class="color01 right" bgcolor="#efefef">空间大小</td>
			 <td><input name="web_quota" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['web_quota'];?>
" type="text">
			   <font color=red>*必填</font></td>
			</tr>
			<tr>
                <td class="color01 right" bgcolor="#efefef">数据库大小</td>
				<td><input name="db_quota" type="text" id="db_quota" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['db_quota'];?>
">
				   <font color=red>*必填</font></td>
		  </tr>		  	  	 	  		  			  
		  	 <tr>
			 <td class="color01 right" bgcolor="#efefef">模板</td>
			 <td><input name="templete" type="text" id="templete"></td>
			</tr>
		  	  	 	   <tr>
        <td class="color01 right" bgcolor="#efefef"></td>
        <td>
	 <button type="submit">增加</button>  </td>
      </tr>
    </tbody></table>
  </form>

  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
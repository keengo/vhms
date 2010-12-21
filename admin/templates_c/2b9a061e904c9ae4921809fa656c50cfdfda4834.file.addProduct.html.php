<?php /* Smarty version Smarty-3.0.5, created on 2010-12-21 16:39:52
         compiled from "D:\project\janbao\admin/view/default\vhostproduct/addProduct.html" */ ?>
<?php /*%%SmartyHeaderCode:324424d1067d84d6eb9-87746243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2b9a061e904c9ae4921809fa656c50cfdfda4834' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\vhostproduct/addProduct.html',
      1 => 1292920789,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '324424d1067d84d6eb9-87746243',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>}}
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
" onBlur="checkName();"></td>
      </tr>
			
			<tr>
			 <td class="color01 right" bgcolor="#efefef">空间大小(M)</td>
			 <td><input name="web_quota" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['web_quota'];?>
" type="text"></td>
			</tr>
			<tr>
              <td class="color01 right" bgcolor="#efefef">数据库大小(M)</td>
			  <td><input name="db_quota" type="text" id="db_quota" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['db_quota'];?>
"></td>
		  </tr>
			<tr>
                <td class="color01 right" bgcolor="#efefef">价格(分/年)</td>
			  <td><input name="price" type="text" id="price" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['price'];?>
"></td>
		  </tr>		  	
		   	<tr>
                <td class="color01 right" bgcolor="#efefef">模板</td>
			  <td><input name="templete" type="text" value="<?php echo $_smarty_tpl->getVariable('vhostproduct')->value['templete'];?>
"></td>
		  	</tr>		 	 	  		  			  
		  	 <tr>
			 <td class="color01 right" bgcolor="#efefef">主机</td>
			 <td><select name='node'>
			 <?php  $_smarty_tpl->tpl_vars['node'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('nodes')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['node']->key => $_smarty_tpl->tpl_vars['node']->value){
?>
			 <option value='<?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
' <?php if ($_smarty_tpl->tpl_vars['node']->value['name']==$_smarty_tpl->getVariable('vhostproduct')->value['node']){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['node']->value['name'];?>
</option>
			 <?php }} ?>
			 </select></td>
			</tr>
		  	 <tr>
               <td class="color01 right" bgcolor="#efefef">状态</td>
		  	   <td><input type="radio" name="state" value="0" <?php if ($_smarty_tpl->getVariable('vhostproduct')->value['state']==0){?> checked <?php }?>>
		  	     暂停销售
		  	       <input type="radio" name="state" value="1" <?php if ($_smarty_tpl->getVariable('vhostproduct')->value['state']==1){?> checked <?php }?>>
		  	       购买
		  	       <input type="radio" name="state" value="2" <?php if ($_smarty_tpl->getVariable('vhostproduct')->value['state']==2){?> checked <?php }?>>
试用</td>
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
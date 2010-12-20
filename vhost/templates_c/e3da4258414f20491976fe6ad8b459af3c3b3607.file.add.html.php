<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:10:14
         compiled from "D:\project\janbao\vhost/view/default\domain/add.html" */ ?>
<?php /*%%SmartyHeaderCode:246714d0f0f66c09620-88252313%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e3da4258414f20491976fe6ad8b459af3c3b3607' => 
    array (
      0 => 'D:\\project\\janbao\\vhost/view/default\\domain/add.html',
      1 => 1292820636,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '246714d0f0f66c09620-88252313',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000">
<div id="container">
<div class="topimg"><?php if ($_smarty_tpl->getVariable('action')->value=='add'){?>增加域名绑定<?php }else{ ?>修改域名绑定<?php }?></div>
  <div id="main" class="wid">
  <form name='nodeform' action="?c=domain&a=<?php echo $_smarty_tpl->getVariable('action')->value;?>
" method="post">
    <table>
		<tbody>
		<tr>
        <td width="131" bgcolor='#efefef' class='color01 right'>域名</td>
        <td width="312"><input type='text' name='domain' id='domain' value="<?php echo $_smarty_tpl->getVariable('domain')->value['domain'];?>
" onBlur="checkName();"></td>
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
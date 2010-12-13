<?php /* Smarty version Smarty-3.0.5, created on 2010-12-13 09:45:10
         compiled from "D:\project\janbao\kpanel\admin/views/default\vhostproduct/editTemplete.html" */ ?>
<?php /*%%SmartyHeaderCode:112484d05eb26d42977-81231460%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1927a5e408adc5343405473b3982926ef59244a2' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\vhostproduct/editTemplete.html',
      1 => 1292233468,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '112484d05eb26d42977-81231460',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
﻿<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body leftmargin="0" topmargin="0" bgcolor="#ffffff" text="#000000">
<div id="container">
<div class="topimg">修改模板权重(值越大，该类型虚拟主机分配到该主机的可能性越大,设置为0表示不分配到该主机上)</div>
  <div id="main" class="wid">
  <form name='nodeform' action="?c=vhostproduct&a=editTemplete&node=<?php echo $_smarty_tpl->getVariable('templete')->value['node'];?>
&templete=<?php echo $_smarty_tpl->getVariable('templete')->value['templete'];?>
" method="post">
    <table>
		<tbody>
		<tr>
        <td width="131" bgcolor='#efefef' class='color01 right'>主机</td>
        <td width="264"><?php echo $_smarty_tpl->getVariable('templete')->value['node'];?>
</td>
		</tr>
			
			<tr>
			 <td class="color01 right" bgcolor="#efefef"><p>模板</p>		      </td>
			 <td><?php echo $_smarty_tpl->getVariable('templete')->value['templete'];?>
</td>
			</tr>
			<tr>
                <td class="color01 right" bgcolor="#efefef">权重</td>
				<td><input name="weight" type="text" id="weight" value="<?php echo $_smarty_tpl->getVariable('templete')->value['weight'];?>
"></td>
		  </tr>
		  	  	 	   <tr>
        <td class="color01 right" bgcolor="#efefef"></td>
        <td>
	 <button type="submit">修改</button>  </td>
      </tr>
    </tbody></table>
  </form>

  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
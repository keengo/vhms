<?php /* Smarty version Smarty-3.0.5, created on 2010-12-14 03:12:04
         compiled from "D:\project\janbao\kpanel\admin/views/default\user/useredit.html" */ ?>
<?php /*%%SmartyHeaderCode:302734d06e084971598-70947116%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '73cfdfb693aa437926be8bb00eccb994b407f98c' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\admin/views/default\\user/useredit.html',
      1 => 1292296319,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '302734d06e084971598-70947116',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template('common/head.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body bgcolor='#ffffff' text='#000000' leftmargin='0' topmargin='0'>
<div id="container">
<div class="topimg">当前位置：修改用户资料</div>
  <div id="main" class="wid">
  <form  action="?c=user&a=edit&username=<?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
" method='post'>
    <table cellpadding=0 cellspacing=1>
      <tr>
        <td width="74" bgcolor='#efefef' class='color01 right'>用户名</td>
        <td width="168"><?php echo $_smarty_tpl->getVariable('user')->value['username'];?>
</td>
      </tr>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>密码</td>
        <td><input type='password' name='passwd' id='passwd' value=""/></td>
      </tr>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>姓名</td>
        <td><input name='name' value="<?php echo $_smarty_tpl->getVariable('user')->value['name'];?>
"/>          </td>
      </tr>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>身份证</td>
        <td><input name='id'  value="<?php echo $_smarty_tpl->getVariable('user')->value['id'];?>
"/>
          &nbsp;&nbsp;<span id='check'></span></td>
      </tr>
      <tr>
        <td class='color01 right' bgcolor='#efefef'>电子邮件</td>
        <td><input name='email' value="<?php echo $_smarty_tpl->getVariable('user')->value['email'];?>
"/></td>
      </tr>
	   <tr>
        <td colspan="2" bgcolor='#efefef' class='color01 center' align="center"><button type="submit">
          修改
          </button></td>
        </tr>
    </table>
	<div><!--E 协议-->
	</div>
	</form>
  </div>
</div>
</body>
<?php $_template = new Smarty_Internal_Template('common/foot.html', $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
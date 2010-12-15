<?php /* Smarty version Smarty-3.0.5, created on 2010-12-15 03:43:37
         compiled from "D:\project\janbao\kpanel\user/views/default\product_list.js" */ ?>
<?php /*%%SmartyHeaderCode:143054d0839696a3bf2-78020321%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '23e019ab3b9cd6c65818309478245314113184ce' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\user/views/default\\product_list.js',
      1 => 1292384615,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '143054d0839696a3bf2-78020321',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
function go_product_form(product)
{
	if(product[0]=='_'){
		return;
	}
	<?php echo $_smarty_tpl->getVariable('target')->value;?>
.window.location='?c=product&a=sellForm&product='+product;
}
document.write('<select name="product" onChange=go_product_form(this.value)>');
document.write('<option value="_">--产品快速导航--</option>');
<?php  $_smarty_tpl->tpl_vars['product'] = new Smarty_Variable;
 $_from = $_smarty_tpl->getVariable('products')->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
if ($_smarty_tpl->_count($_from) > 0){
    foreach ($_from as $_smarty_tpl->tpl_vars['product']->key => $_smarty_tpl->tpl_vars['product']->value){
?>
document.write('<option value="<?php echo $_smarty_tpl->tpl_vars['product']->value['type'];?>
_<?php echo $_smarty_tpl->tpl_vars['product']->value['id'];?>
"><?php if ($_smarty_tpl->tpl_vars['product']->value['type']!=''){?>&nbsp;&nbsp;<?php }?><?php echo $_smarty_tpl->tpl_vars['product']->value['name'];?>
</option>');
<?php }} ?>
document.write('</select>');
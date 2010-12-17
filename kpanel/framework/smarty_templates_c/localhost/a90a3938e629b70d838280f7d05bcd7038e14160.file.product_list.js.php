<?php /* Smarty version Smarty-3.0.5, created on 2010-12-17 07:14:42
         compiled from "D:\project\janbao\kpanel\user/view/default\product_list.js" */ ?>
<?php /*%%SmartyHeaderCode:154804d0b0de2ae0af9-15244369%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a90a3938e629b70d838280f7d05bcd7038e14160' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\user/view/default\\product_list.js',
      1 => 1292384615,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '154804d0b0de2ae0af9-15244369',
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
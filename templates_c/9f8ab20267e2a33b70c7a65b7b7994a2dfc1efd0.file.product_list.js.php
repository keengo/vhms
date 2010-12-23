<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:56:21
         compiled from "D:\project\janbao/view/default\product/product_list.js" */ ?>
<?php /*%%SmartyHeaderCode:12064d12c86541b4a5-62537347%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f8ab20267e2a33b70c7a65b7b7994a2dfc1efd0' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\product/product_list.js',
      1 => 1293070622,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12064d12c86541b4a5-62537347',
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
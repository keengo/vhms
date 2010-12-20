<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 16:14:06
         compiled from "D:\project\janbao\user/view/default\product_list.js" */ ?>
<?php /*%%SmartyHeaderCode:300504d0f104e8b8ba4-25956805%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd79e3f057e3aa774339b26929ff93a4348355ca0' => 
    array (
      0 => 'D:\\project\\janbao\\user/view/default\\product_list.js',
      1 => 1292384615,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '300504d0f104e8b8ba4-25956805',
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
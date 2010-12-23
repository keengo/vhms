<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 11:35:28
         compiled from "D:\project\janbao/view/default\sell_vproduct.html" */ ?>
<?php /*%%SmartyHeaderCode:288964d12c3807e4263-24357798%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '634adb6785dfd6bee613b3d6edfb5d4ec2046fb2' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\sell_vproduct.html',
      1 => 1293075327,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '288964d12c3807e4263-24357798',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<script language="javascript">
function show(url) 
{ 
	window.open(url,'','height=100,width=250,resize=no,scrollbars=no,toolsbar=no,top=200,left=200');
}
function check_user()
{
	show('?c=product&a=check&product_type=vhost&param='+document.vhostform.param.value);
}

</script>
<div id="container">
<div class="topimg">购买虚拟主机产品!</div>
  <div id="main" class="wid">
  <form name='vhostform' action="?c=product&a=sell&product_id=<?php echo $_smarty_tpl->getVariable('product')->value['id'];?>
&product_type=vhost" method="post">
    <table>
		<tbody>
		<tr>
        <td width="131" bgcolor='#efefef' class='color01 right'>产品名称</td>
        <td width="312"><?php echo $_smarty_tpl->getVariable('product')->value['name'];?>
</td>
      </tr>
		<tr>
          <td class="color01 right" bgcolor="#efefef">FTP用户名</td>
		  <td><input name="param" type="text" id="param">
		    <input type="button" name="Submit" value="检测用户名" onClick="check_user()"></td>
		  </tr>
		<tr>
          <td class="color01 right" bgcolor="#efefef">密码</td>
		  <td><input name="passwd" type="password" id="passwd"></td>
		  </tr>
		<tr>
          <td class="color01 right" bgcolor="#efefef">确认密码</td>
		  <td><input name="passwd2" type="password" id="passwd2"></td>
		  </tr>
		<tr>
          <td class="color01 right" bgcolor="#efefef">购买时间</td>
		  <td><input type=radio name=month value=12 checked>1年
			<input type=radio name=month value=24>2年
			<input type=radio name=month value=36>3年</td>
		  </tr>
			
			<tr>
			 <td class="color01 right" bgcolor="#efefef">空间大小</td>
			 <td><?php echo $_smarty_tpl->getVariable('product')->value['web_quota'];?>
M</td>
			</tr>
			<?php if ($_smarty_tpl->getVariable('product')->value['db_quota']>0){?>
			<tr>
              <td class="color01 right" bgcolor="#efefef">数据库大小</td>
			  <td><?php echo $_smarty_tpl->getVariable('product')->value['db_quota'];?>
M</td>
			</tr>
			<?php }?>
			<tr>
                <td class="color01 right" bgcolor="#efefef">价格</td>
			    <td><?php echo $_smarty_tpl->getVariable('product')->value['price']/100;?>
元/年</td>
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

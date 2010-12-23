<?php /* Smarty version Smarty-3.0.5, created on 2010-12-23 09:43:43
         compiled from "D:\project\janbao/view/default\top.html" */ ?>
<?php /*%%SmartyHeaderCode:33644d12a94f3fa370-21436499%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5eb9ec0ec5b477373bca8dc4149dbfd5a23c89b6' => 
    array (
      0 => 'D:\\project\\janbao/view/default\\top.html',
      1 => 1292995720,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '33644d12a94f3fa370-21436499',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("common/head.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body>
<table width="100%" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td id="t1"><a href='?c=public&a=index' target=_top><img src="<?php echo $_smarty_tpl->getVariable('STATIC')->value;?>
/style/logo.gif" alt="logo" width="164" height="60" border='0'/></a></td>
        <td id="t2">
<SCRIPT language="javascript">
<!--
function initArray()
 {
  for(i=0;i<initArray.arguments.length;i++)
  this[i]=initArray.arguments[i];
 }}
 var isnMonths=new initArray("1.","2.","3.","4.","5.","6.","7.","8.","9.","10.","11.","12.");
 var isnDays=new initArray("星期日","星期一","星期二","星期三","星期四","星期五","星期六","星期日");
 today=new Date();
 hrs=today.getHours();
 min=today.getMinutes();
 sec=today.getSeconds();
 clckh=""+((hrs>12)?hrs-12:hrs);
 clckm=((min<10)?"0":"")+min;clcks=((sec<10)?"0":"")+sec;
 clck=(hrs>=12)?"下午":"上午";
 var stnr="";
 var ns="0123456789";
 var a="";

function getFullYear(d)
{
  yr=d.getYear();if(yr<1000)
  yr+=1900;return yr;}}
  document.write("<table>");
    document.write("<TR><TD>"+getFullYear(today)+"."+isnMonths[today.getMonth()]+""+today.getDate()+" "+isnDays[today.getDay()]+"</tr></td>");
  document.write("</table>");
//-->
</SCRIPT>

</td>
<td align="right"><script language="javascript" src="?c=product&a=productList&target=parent.main">
</script>
</td>
  </tr>
</table>

</body>
</html>

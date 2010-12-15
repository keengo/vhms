<?php /* Smarty version Smarty-3.0.5, created on 2010-12-15 03:41:18
         compiled from "D:\project\janbao\kpanel\user/views/default\top.html" */ ?>
<?php /*%%SmartyHeaderCode:205934d0838de537444-74557226%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a6228117d97a5a4e900ef5ca06da50aa1e59f70f' => 
    array (
      0 => 'D:\\project\\janbao\\kpanel\\user/views/default\\top.html',
      1 => 1292384476,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '205934d0838de537444-74557226',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<?php $_template = new Smarty_Internal_Template("common/head.html", $_smarty_tpl->smarty, $_smarty_tpl, $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null);
 echo $_template->getRenderedTemplate();?><?php $_template->updateParentVariables(0);?><?php unset($_template);?>
<body>
<table width="90%" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td id="t1"><img src="images/top-left.gif" alt="top-left" width="18" height="60" /><img src="images/logo.gif" alt="logo" width="164" height="60" /></td>
        <td id="t2">
<SCRIPT language="javascript">
<!--
function initArray()
 {
  for(i=0;i<initArray.arguments.length;i++)
  this[i]=initArray.arguments[i];
 }
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
  yr+=1900;return yr;}
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

<?php /* Smarty version Smarty-3.0.5, created on 2010-12-20 17:54:23
         compiled from "D:\project\janbao\admin/view/default\top.html" */ ?>
<?php /*%%SmartyHeaderCode:252474d0f27cf6df2a9-86086252%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '682deeffdfe4e1004a7346830a08421ebcf6570b' => 
    array (
      0 => 'D:\\project\\janbao\\admin/view/default\\top.html',
      1 => 1291874826,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '252474d0f27cf6df2a9-86086252',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
)); /*/%%SmartyHeaderCode%%*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- html标识扩展，定义名字空间 -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="utf-8">
<head>
<title>登陆页面</title>
<!-- 定义语言编码 -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="utf-8" />
<!-- 定义链接样式表 -->
<link rel="stylesheet" rev="stylesheet" href="css/style.css" type="text/css" media="all" />
<link rel="stylesheet" rev="stylesheet" href="css/header.css" type="text/css" media="all" />
<base target="content" />
</head>
<body>
<table id="t" cellpadding="0" cellspacing="0">
  <tr>
    <td>
	<table cellspacing="0" cellpadding="0" width="100%">
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
        </tr>
    </table>	</td>
  </tr>
</table>

</body>
</html>
<!--
          <map name="Map" id="Map">
            <area shape="rect" coords="45,2,120,60" href="domainmanage.htm" target='main' />
            <area shape="rect" coords="141,2,216,60" href="hostlist.htm" target='main'/>
            <area shape="rect" coords="236,2,291,60" href="funddetail.htm" target='main'/>
            <area shape="rect" coords="310,2,361,60" href="cgi-bin/userself/pricelist.cgi" target='main'/>
	    <area shape="rect" coords="384,2,434,59" href="renewlist.htm" target='main'/>
	    <area shape="rect" coords="526,2,577,60" href="cgi-bin/logout.cgi" target='_top'/>
		<area shape="rect" coords="458,0,510,59" href="cgi-bin/miscservice/techsupport.cgi" target='main' />
</map>
-->
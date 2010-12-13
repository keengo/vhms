<?php
session_start();
header("Content-Type: text/html; charset=gbk");
?>
你好:<?php echo $_SESSION["name"];?>
<br><br>
<table>
<tr><td><a href='main.php' target='mainFrame'>信息</a></td></tr>
<tr><td><a href='domain.php' target='mainFrame'>绑定域名</a></td></tr>
<tr><td><a href='changepassword.php' target='mainFrame'>修改密码</a></td></tr>
<tr><td><a href='logout.php' target='_top'>退出</a></td></tr>
</table>

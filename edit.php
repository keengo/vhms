<?php
include("./check_login.php");
include("./connect.php");
$domain=$_REQUEST["domain"];
$sql = "select dir from domain where domain='".$domain."' and name='".$_SESSION["name"]."'";
$rs = mysql_fetch_array(mysql_query($sql,$cn));
if(!$rs){
	die("没有该域名:".$domain);
}
?>
修改域名:<?php echo $domain;?>
<form action='do.php?action=edit&domain=<?php echo $domain;?>' method='post'>
目录:<input name='dir' value='<?php echo $rs["dir"];?>'>
<input type=submit value='修改'>
</form>

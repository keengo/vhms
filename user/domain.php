<?php
include("./check_login.php");
include("./connect.php");
$domain=$_REQUEST["domain"];
$sql = "select domain,dir from domain where name='".$_SESSION["name"]."'";

?>
<table><tr><td>
<form action='do.php?action=add' method='post'>
域名:<input name='domain' value=''>目录:<input name='dir' value='www'>
<input type=submit value='增加'>
</form>
</td></tr></table>

<table><tr><td>操作</td><td>域名</td><td>目录</td></tr>
<?php
//echo $sql."<br>";
$result = mysql_query($sql,$cn);
while($rs=mysql_fetch_array($result)){
?>
<tr><td>[<a href='edit.php?domain=<?php echo $rs["domain"];?>'>修改</a>] [<a href='do.php?action=del&domain=<?php echo $rs["domain"];?>'>删除</a>]</td>
<td><?php echo $rs["domain"];?></td>
<td><?php echo $rs["dir"];?></td>
</tr>
<?php
}
?>

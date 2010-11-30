<?php
header("Content-Type: text/html; charset=gbk");
?>
<script language='javascript'>
function checkform()
{

	if(document.regform.name.value==""){
		alert("用户名没有写");
		return;
	}
	if(document.regform.passwd.value!=document.regform.passwd2.value){
		alert("两次密码不一样!");
		return;
	}
	document.regform.submit();

}
function show(url) 
{ 
	window.open(url,'','height=100,width=250,resize=no,scrollbars=no,toolsbar=no,top=200,left=200');
}
function check_user()
{
	show('check_user.php?name='+document.regform.name.value);
}
</script>
<form action='newuser.php' method='post' name='regform'>
用户名:<input type=text name='name'> <input type=button onclick="check_user()" value="检测用户名"><br>
密码: <input type='password' name='passwd'><br>
确认密码:<input type='password' name='passwd2'><br>
空间类型:<select name='type'>
<?php
include("./config.php");
reset($space_type);
while (list($name, $val) = each($space_type)) {
	echo "<option value='".$val."'>".$name."</option>\n";
}
?>
</select>
<input type="button"  onclick=checkform() value="确定"> 
</form>

<?php
session_start();
header("Content-Type: text/html; charset=gbk");
if($_SESSION["name"]==""){
?>
kangle virtual host test.<br>
[<a href='register.php'>免费注册空间</a>]
<form action='login.php' method='post'>
用户名:<input name='name'> 
密码:<input name='passwd' type='password'> 
<input type='submit' value='登录'>
</form>
<?php
}else{
?>

<frameset cols="200,*" rows="*" id="mainFrameset">
        <frame frameborder="0" id="frame_navigation"
        src="left.php"
        name="frame_navigation" />
        <frame frameborder="0"
        src="main.php"
        name="mainFrame" />
        <noframes>
       
    </noframes>
</frameset>


<?php
}
?>

<?php
session_start();
header("Content-Type: text/html; charset=gbk");
echo "[<a href='http://".$_SESSION["name"].".kanglesoft.com:81/' target=_blank>空间入口</a>]<br>";
echo "用户名:".$_SESSION["name"]."<br>";
echo "家目录:".$_SESSION["doc_root"]."<br>";
echo "空间类型:".$_SESSION["templete"]."<br>";
echo "ftp服务器:".$_SESSION["name"].".kanglesoft.com 端口:21<br>";
?>
<pre>
空间注意事项:
1.请上传文件到www子目录。

</pre>

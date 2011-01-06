<?php
header("Cache-Control: static; max_age=20");
echo "id=".$_REQUEST["id"];
echo "<br>".time(NULL);
?>
<a href='<?php echo $_SERVER["PHP_SELF"];?>?id=<?php echo $_REQUEST["id"];?>'>ฑพอ๘าณมดฝำ</a>
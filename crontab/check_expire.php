<?php
if($_SERVER["argv"]== null || $_REQUEST!=null ){
	die("crontab cann't run in web model.please run in cli.");
}
die("deprecated use shell.php sync_expire\n");
?>
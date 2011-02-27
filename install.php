<?php
function my_exit($msg)
{
	header("Content-Type: text/html; charset=utf-8");
	die($msg);
}
if(!class_exists('PDO')){
	my_exit("没有开启PDO支持");
}
$drivers = PDO::getAvailableDrivers();
$finded = false;
for($i=0;$i<count($drivers);$i++){
	if($drivers[$i]=='mysql'){
		$finded = true;
		break;
	}
}
if(!$finded){
	my_exit("PDO没有mysql驱动");
}
header("Location: admin/index.php?c=install&a=step1");
?>
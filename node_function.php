<?php
include("./node_config.php");
function get_node($templete)
{
	global $templetes;
	$total_value = 0;
	for($i=0;$i<count($templetes);$i++){
		$total_value+=$templetes[$i][1];
	}
	if($total_value==0){
		return false;
	}
	$value = rand()%$total_value;
	for($i=0;$i<count($templetes);$i++){
		$value-=$templetes[$i][1];
		if($value<=0){
			return $templetes[$i][0];
		}
	}
	return false;
}
function create_node_file()
{
	global $cn;
	$fp = fopen("./node_config.php","wt");
	if(!$fp){
		return false;
	}
	$msg='<?php\r\n';
	$sql = "select name,host,port,user,passwd,state from nodes";
	$result = mysql_query($sql,$cn);
	while($rs=mysql_fetch_array($result)){
		$msg.='$nodes["'.$rs["name"].'"]=array("'.$rs["host"].'",'.$rs["port"].',"'.$rs["user"].'","'.$rs["passwd"].'",'.$rs["state"].');\n';
	}
	$sql="select templetes.node as node,templetes.templete as templete ,templetes.weight as weight from templetes,nodes where nodes.node=templetes.node and nodes.state=0 order by templetes.templete";
	$result = mysql_query($sql,$cn);
	$last_templete="";
	$msg.='$templetes=array(';
	$count=0;
	$array_count=0;
	while($rs=mysql_fetch_array($result)){
		if($last_templete!=$rs["templete"]){
			$last_templete=$rs["templete"];
			if($count!=0){
				$msg.='),';
			}
			$msg.='"'.$last_templete.'"==>array(';
			$array_count=0;
		}
		if($array_count!=0){
			$msg.=',';
		}
		$msg.='array("'.$rs["node"].'",'.$rs["weight"].')';
		$array_count++;
		$count++;
	}
	$msg.=');\n';
	$msg.='?>';
	fwrite($fp,$msg);
	fclose($fp);
	return true;
}
?>

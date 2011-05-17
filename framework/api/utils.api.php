<?php
class UtilsAPI extends API
{
	public function writeConfig($nodes,$keyname,$cfg_name)
	{
		$dir = dirname(dirname(__FILE__))."/configs/";
		@mkdir($dir);
		$file = $dir.$cfg_name.".cfg.php";
		$fp = fopen($file,"wt");
		if(!$fp){
			return trigger_error("cann't open ".$file." to write!Please check right");
		}
		fwrite($fp,"<?php\r\n");
		//$nodes = daocall('nodes','listNodes');
		for($i=0;$i<count($nodes);$i++){
			$this->writeItemConfig($fp,$nodes[$i],$keyname,$cfg_name);
		}
		fwrite($fp,"?>");
		fclose($fp);
		return true;
	}
	private function writeItemConfig($fp,$node,$keyname,$cfg_name)
	{
		$str = "\$GLOBALS['".$cfg_name."_cfg']['".$node[$keyname]."']=array(";
		$item = "";
		$keys = array_keys($node);
		for($i=0;$i<count($keys);$i++){
			$key = $keys[$i];
			$value = $node[$key];
			if($item!=""){
				$item.=",";
			}
			$item.="'".$key."'=>'".addslashes($value)."'";
		}
		$str.=$item.");\r\n";
		fwrite($fp,$str);
	}
	//输入时去除html标签
	function klencode($str)
	{
		$str=str_replace("<","&lt;",$str);
		$str=str_replace(">","&gt;",$str);
		$str=str_replace(chr(34),"&quot;",$str);
		$str=str_replace("\n","<br>",$str);
		$str=str_replace("  "," &nbsp;",$str);
		return $str;
	}
	//显示时去除html标签
	function kldecode($msg)
	{
		$msg=str_replace("<br />",chr(10),$msg);
		$msg=str_replace("<br>",chr(10),$msg);
		$msg=str_replace("&quot;",chr(34),$msg);
		$msg=str_replace("&lt;","<",$msg);
		$msg=str_replace("&gt;",">",$msg);
		$msg=str_replace("&nbsp;"," ",$msg);
		return $msg;
	}

}
?>
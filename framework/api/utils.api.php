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
			if($key!=$keyname){
				$item.="'".$key."'=>'".$value."'";
			}
		}
		$str.=$item.");\r\n";
		fwrite($fp,$str);
	}
}
?>
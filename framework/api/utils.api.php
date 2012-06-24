<?php
class UtilsAPI extends API
{
	
	public function delTempleteFile($temp_dir)
	{
		if (!$temp_dir) {
			$temp_dir = dirname(__FILE__).'/../templates_c/';
		}
		$op = opendir($temp_dir);
		if (!$op) {
			return false;
		}
		while (($file = readdir($op)) !== false) {
			if ($file != '.' && $file != '..') {
				@rmdir($temp_dir.$file);
				if (is_dir($temp_dir.$file)) {
					@unlink($temp_dir.$file);
					if (substr($file,-1) != '/' || substr($file,-1) != '\\') {
						$dir_r = '/';
					}else{
						$dir_r = "";
					}
					$this->delTempleteFile($temp_dir.$file.$dir_r);
				}else{
					@unlink($temp_dir.$file);
				}
			}
			
		}
		@rmdir($temp_dir.$file);
	}
	/**
	 * 写入配置文件
	 * @param  $nodes
	 * @param  $keyname
	 * @param  $cfg_name
	 */
	public function writeConfig($nodes,$keyname,$cfg_name)
	{
		$dir = dirname(dirname(__FILE__))."/configs/";
		@mkdir($dir);
		$file = $dir.$cfg_name.".cfg.php";
		$fp = fopen($file,"wb");
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
		@chmod($file,0600);
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
			$item.="'".$key."'=>\"".addcslashes($value,'\\"$')."\"";
		}
		$str.=$item.");\r\n";
		fwrite($fp,$str);
	}
	/**
	 * 输入时，去除html标签
	 */
	function klencode($str,$html=false)
	{
		if(!$html){
			$str=str_replace("<","&lt;",$str);
			$str=str_replace(">","&gt;",$str);
		}
		$str=str_replace(chr(34),"&quot;",$str);
		$str=str_replace("\n","<br>",$str);
		$str=str_replace("  "," &nbsp;",$str);
		return $str;
	}
	/**
	 * 显示前，去除html标签
	 * @param $msg
	 * @param $html
	 */
	function kldecode($msg,$html=false)
	{
		$msg=str_replace("<br />",chr(10),$msg);
		$msg=str_replace("<br>",chr(10),$msg);
		$msg=str_replace("&quot;",chr(34),$msg);
		$msg=str_replace("&nbsp;"," ",$msg);
		if(!$html){
			$msg=str_replace("&lt;","<",$msg);
			$msg=str_replace("&gt;",">",$msg);
		}
		return $msg;
	}

}
?>
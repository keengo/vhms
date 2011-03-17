<?php
class InstallAPI extends API
{
	public function writeVersion()
	{
		$fp = @fopen($GLOBALS['lock_file'],'wt');
		if(!$fp){
			return false;
		}
		//写入version
		fwrite($fp,VHMS_VERSION);
		fclose($fp);
		return true;
	}
}
?>
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
	public function executeSql($pdo,$sqlfile)
	{

		$files = file($sqlfile);
		if(!$files || count($files)<=0){
			trigger_error('无法打开'.$$sqlfile.'文件');
			return false;
		}
		$sql = "";
		for($i=0;$i<count($files);$i++){
			if(strncmp($files[$i],'-- ',3)==0){
				//it is a comment
				continue;
			}
			$sql.= $files[$i];
			//rtrim($files[$i]);
			if(substr($files[$i],-2)==";\n" || substr($files[$i],-3)==";\r\n"){
				//echo "sql=".$sql;
				@$pdo->exec($sql);
				$sql = "";
			}
		}
		return true;	
	}
}
?>
<?php
class ShellAPI extends API
{
	public function sync($host)
	{
		if($host==null){
			die("Usage: sync host\n");
		}
		$vhosts = daocall('vhost','listVhostByNode',array($host));
		echo "begin sync,total count=".count($vhosts)."\n";
		foreach($vhosts as $vhost){
			echo "now sync :".$vhost['name']." result=".apicall('vhost','sync',array($vhost))."\n";
		}
		echo "done..\n";
	}
}
?>
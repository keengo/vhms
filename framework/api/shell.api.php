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
	/**
	 * 同步所有主机的流量
	 */
	public function sync_flow()
	{
		$t = date('YmdH',time(NULL));
		$nodes = daocall('nodes','getAllNodes');
		//print_r($nodes);
		//echo $t;
		foreach ($nodes as $node) {
			$this->sync_host_flow($node['name'],$t);
		}	
	}
	public function sync_host_flow($node,$t)
	{
		echo "sync ".$node." flow...\n";		
		$month = substr($t,0,6);
		$day = substr($t,0,8);
		$hour = $t;
		$whm = apicall('nodes','makeWhm',array($node));
		$whmCall = new WhmCall('dump_flow');
		$result = $whm->call($whmCall,300);
		$flow = (String)$result->get('flow');
		$lines = explode("\n",$flow);
		foreach ($lines as $line) {
			if (strlen($line)<2) {
				continue;
			}
			//print_r("line=".$line);
			$item = explode("\t",$line);
			//print_r($item);
			$name = $item[0];
			$flow = $item[1];
			$count = $item[2];
			echo $name." flow=".$flow."\n";
			apicall('vhost','addFlow',array($name,$month,$day,$hour,$flow));
		}
	}
}
?>
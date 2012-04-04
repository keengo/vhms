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
		foreach ($nodes as $node) {
			$this->sync_host_flow($node['name'],$t);
		}
		$setting = daocall('setting','getAll2',array());
		if ($setting['set_mail'] == 1) {
			$this->sendMail();
		}
	}
	public function sendMail()
	{
		return apicall('mail','sendExMail',array());
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
	/*暂停，删除过期空间*/
	public function sync_expire()
	{
		$day = 1; //查询过期天数
		$expire_save_day = daocall('setting','get',array('expire_save_day'));
		$del_day = $expire_save_day ? $expire_save_day : 30;//过期多少天删除空间

		$vhosts = daocall('vhost','selectListByExpire_time',array($day)); //获取过期空间	
		if ($vhosts) {
			foreach ($vhosts as $vhost) {
				if(!$nodes = daocall('nodes','getNode',array($vhost['node']))){
					echo "sync_expire ",$vhost['name']." failed<-------not node------->\r\n";
					continue;
				}
				try{
					if(!$return = apicall('vhost','changeStatus',array($vhost['node'],$vhost['name'],1))){
						echo "sync_expire ",$vhost['name']." failed<-------sync failed------->\r\n";
						continue;
					}
				}catch(Exception $e){
					//print_r($e);
				}
				echo "sync_expire ",$vhost['name']." success\r\n";
			}
		}
		
		//查询过期达到指定天数的网站，并删除
		$del_vhosts = daocall('vhost','selectListByExpire_time',array($del_day,-1));
		
		if (count($del_vhosts) >0) {
			foreach ($del_vhosts as $del_vhost) {
				if(!$nodes = daocall('nodes','getNode',array($del_vhost['node']))) {
					echo "del  ",$del_vhost['name']." failed<-------not node------->\r\n";
					continue;
				}
				if(!$result = apicall('vhost','del',array($del_vhost['node'],$del_vhost['name']))){
					echo "del  ",$del_vhost['name']." failed<-------sync failed------->\r\n";
					continue;
				}
				echo "del  ",$del_vhost['name']." success\r\n";
			}
		}
	}
	
	//获取数据库的使用量;
	private function getDbUsed($nodename,$name)
	{
		$whm = apicall('nodes','makeWhm',array($nodename));
		$whmCall = new WhmCall('getDbUsed');
		$whmCall->addParam('name', $name);
		return $whm->call($whmCall,10);
	}
}
?>
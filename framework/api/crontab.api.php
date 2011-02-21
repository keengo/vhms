<?php
class CrontabAPI extends API
{
	/**
	 * 每日运行
	 */
	public function runDay()
	{
		/*
		 * 设置过期用户 
		 */
		daocall('vhost','expireUser');
		/*
		 * 通知所有节点重新加载虚拟主机
		 */
		$nodes = daocall('nodes','listNodes');
		for($i=0;$i<count($nodes);$i++){
			$this->reloadNode($nodes[$i]);
		}
	}
	public function runHour()
	{

	}
	private function reloadNode($node)
	{
		$whm = apicall('nodes','makeWhm2',array($node['host'],$node['port'],$node['user'],$node['passwd']));
		$whmCall = new WhmCall('core.whm','reload_all_vh');
		return $whm->call($whmCall,10);
	}
}
?>

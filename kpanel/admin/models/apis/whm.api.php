<?php
class WhmAPI extends API{
	public function __construct()
	{
		load_lib('pub:whm');
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function refreshTemplete($host)
	{
		$node = daocall('nodes', 'getNode', array($host));
		if(!$node || $node==null){
			return false;
		}
		return $this->refreshHostTemplete($node);
	}
	protected function refreshHostTemplete($node)
	{
		$whm = new WhmClient();
		$whm->setAuth($node['user'],$node['passwd']);
		$whm->setWhmUrl("http://".$node['host'].":".$node['port']."/core.whm");
		$call = new WhmCall("list_tvh");
		$result = $whm->call($call);
		if(!$result){
			die('failed');
			return false;
		}
		for($i=0;;$i++){
			$callName = $result->get("tvh",$i);
			if(!$value){
				break;
			}
			echo "tvh=".$tvh."\n";
		}
		die('');
	}
}
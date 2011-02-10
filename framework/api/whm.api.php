<?php
//@过时
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
	public function getTemplete($node)
	{
		
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
		
		daocall('vhosttemplete','updateNodeState',array($node['name']));
		$whm = new WhmClient();
		$whm->setAuth($node['user'],$node['passwd']);
		$whm->setWhmUrl("http://".$node['host'].":".$node['port']."/core.whm");
		$call = new WhmCall("list_tvh");
		$result = $whm->call($call);
		if(!$result){
			die('failed');
			return false;
		}
		$templete = array();
		for($i=0;;$i++){
			$value = $result->get("name",$i);
			if(!$value){
				break;
			}
			$templete[] = $value;
			//echo "tvh=".$value."\n";
		}
		daocall('vhosttemplete','updateNodeTemplete',array($node['name'],$templete));
		//die('success');
	}
}
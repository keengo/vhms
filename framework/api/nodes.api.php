<?php
class NodesAPI extends API
{
	private $MAP_ARR;
	public function __construct()
	{
		
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function checkNodes($node)
	{
		return $ret;
	}
	public function edit($arr = array())
	{
		
	}
	public function makeWhm($node)
	{
		load_conf('pub:node');
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if(!is_array($node_cfg)){
			return trigger_error('没有节点'.$node.'的配置文件，请更新配置文件');
		}
		load_lib("pub:whm");
		$whm = new WhmClient();
		$whmUrl = "http://".$node_cfg['host'].":".$node_cfg['port']."/";
		$whm->setUrl($whmUrl);
		$whm->setAuth($node_cfg['user'], $node_cfg['passwd']);
		return $whm;
	}
	public function isWindows($node)
	{
		if(strncmp($node,'win_',4)==0){
			return true;
		}
		return false;
	}
	public function init($node)
	{
		$whm = $this->makeWhm($node);
		$driver = "bin/vhs_mysql.so";
		$tpl = tpl::singleton();
		$tpl->assign('driver',$driver);
		$tpl->assign('col_map',daocall('vhost','getColMap', array(null)));
		$tpl->assign('load_sql',daocall('vhost','getLoadSql', array($node)));
		$tpl->assign('flush_sql',daocall('vhost','getFlushSql', array(null)));
		$tpl->assign('load_host_sql',daocall('domain','getLoadHostSql', array(null)));
		global $db_cfg;
		$db_local = $this->isLocalHost($db_cfg['default']['host']);
		$node_local = $this->isLocalHost($GLOBALS['node_cfg'][$node]['host']);
		if($db_local && !$node_local){
			//如果db host是local,而节点不是local,则要替换db的host为公网IP
			$db_cfg['default']['host'] = $_SERVER['SERVER_ADDR'];
		}
		$tpl->assign('db',$db_cfg['default']);
		$whmCall = new WhmCall('core.whm','write_ext');
		$whmCall->addParam('file', 'vh_db.xml');		
		$content = $tpl->fetch('config/vh.xml');
		$whmCall->addParam('content',base64_encode($content));
		$result = $whm->call($whmCall);
		if($result){
			$whmCall = new WhmCall('core.whm','reboot');
			return $whm->call($whmCall);
		}
		return false;
	}
	/**
	 * 
	 * 重建节点配置文件
	 */
	public function flush()
	{
		$file = dirname(dirname(__FILE__))."/configs/node.cfg.php";
		$fp = fopen($file,"wt");
		if(!$fp){
			return trigger_error("cann't open ".$file." to write!Please check right");
		}
		fwrite($fp,"<?php\r\n");
		$nodes = daocall('nodes','listNodes');
		for($i=0;$i<count($nodes);$i++){
			$this->write_node_config($fp,$nodes[$i]);
		}
		fwrite($fp,"?>");
		fclose($fp);
		return true;
	}
	private function write_node_config($fp,$node)
	{
		$str = "\$GLOBALS['node_cfg']['".$node['name']."']=array(";
		$item = "";
		$keys = array_keys($node);
		for($i=0;$i<count($keys);$i++){
			$key = $keys[$i];
			$value = $node[$key];
			if($item!=""){
				$item.=",";
			}
			if($key!='name'){
				$item.="'".$key."'=>'".$value."'";
			}
		}
		$str.=$item.");\r\n";
		fwrite($fp,$str);
	}
	public function isLocalHost($host)
	{
		if(strcasecmp($host,'localhost')==0){
			return true;
		}
		if(strncmp($host,'127.0.0.',8)==0){
			return true;
		}
		if($host=='::1'){
			return true;
		}
		return false;
	}
}
?>

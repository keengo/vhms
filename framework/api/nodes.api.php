<?php
class NodesAPI extends API
{
	private $MAP_ARR;
	/**
	 * ���캯��
	 **/
	public function __construct()
	{
		load_lib("pub:whm");
	}
	/**
	 * �������� 
	 **/
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
	public function init($node)
	{
		$driver = "bin/vhs_mysql.so";
		Control::$_tpl->assign('driver',$driver);
		Control::$_tpl->assign('col_map',daocall('vhost','getColMap', array(null)));
		Control::$_tpl->assign('load_sql',daocall('vhost','getLoadSql', array(null)));
		Control::$_tpl->assign('flush_sql',daocall('vhost','getFlushSql', array(null)));
		Control::$_tpl->assign('load_host_sql',daocall('domain','getLoadHostSql', array(null)));
		global $db_cfg;
		Control::$_tpl->assign('db',$db_cfg['default']);
		$str = Control::$_tpl->fetch('config/vh.xml');
		
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
		$str = "\$node_cfg['".$node['name']."']=array(";
		$item = "";
		for($i=0;$i<count($node);$i++){
			$key = key($node[$i]);
			$value = $node[$i];
			if($item!=""){
				$item.=",";
			}
			if($key!='name'){
				$item.="'".$key."'=>'".$value."'";
			}			
		}
		echo $item;
		$str.=$item.");\r\n";
		fwrite($fp,$str);
	}
}
?>

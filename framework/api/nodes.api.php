<?php
class NodesAPI extends API
{
	private $MAP_ARR;
	public function __construct()
	{
		load_conf('pub:node');
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function getInfo($node)
	{
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if(!is_array($node_cfg)){
			return trigger_error('没有节点'.$node.'的配置文件，请更新配置文件');
		}
		return $node_cfg;
	}
	public function listTemplete($node)
	{
		$whm = $this->makeWhm($node);
		if(!$whm){
			return false;
		}
		$call = new WhmCall('core.whm',"list_gtvh");
		$result = $whm->call($call,5);
		if(!$result){
			return false;
		}
		$templete = array();
		for($i=0;;$i++){
			$value = $result->get("name",$i);
			if(!$value){
				break;
			}
			$templete[] = $value;
		}
		return $templete;
	}
	public function makeWhm2($host,$port,$user,$passwd)
	{
		load_lib("pub:whm");
		$whm = new WhmClient();
		$whmUrl = "http://".$host.":".$port."/";
		$whm->setUrl($whmUrl);
		$whm->setAuth($user, $passwd);
		return $whm;
	}
	public function makeDbProduct($node)
	{
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if(!is_array($node_cfg)){
			return trigger_error('没有节点'.$node.'的配置文件，请更新配置文件');
		}
		load_lib('pub:dbProduct');
		$db_type = $node_cfg['db_type'];
		if(!$db_type){
			return trigger_error('该节点数据库类型出错!');
		}
		$className = $db_type."DbProduct";
		load_lib('pub:'.$className);
		$className[0] = strtoupper($className[0]);
		$db = new $className;
		if(!$db->connect($node_cfg)){
			//return trigger_error('不能连接节点数据库');
			return false;
		}
		return $db;
	}
	public function makeWhm($node)
	{
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if(!is_array($node_cfg)){
			return trigger_error('没有节点'.$node.'的配置文件，请更新配置文件');
		}
		return $this->makeWhm2($node_cfg['host'],$node_cfg['port'],$node_cfg['user'],$node_cfg['passwd']);
	}
	public function isWindows($node)
	{
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if(!is_array($node_cfg)){
			return trigger_error('没有节点'.$node.'的配置文件，请更新配置文件');
		}
		return $node_cfg['win'] == 1;		
	}
	/**
	 * 
	 * 初始化一个节点
	 * @param $node 节点名称
	 * @param $level 初始化级别
	 * 0   全部(首次初始化开始)
	 * 1  除首次初始化全部
	 */
	public function init($node,$config_flag ,$init_flag ,$reboot_flag)
	{
		$whm = $this->makeWhm($node);
		$result = true;
		if($config_flag == 1){
			$node_cfg = $GLOBALS['node_cfg'][$node];
			/*
			 * 生成数据库连接文件etc/vh_db.xml
			 * 这个文件为什么要放到etc呢？而不放到ext下面?
			 * 问得好！权限问题，数据库连接文件包含重要的密码信息，要确保除超级用户外无人可访问。
			 * 而ext目录下面是扩展目录，普通用户需要读和运行的权限。
			 * 我们可以在ext/templete.xml放入一条<!--#include etc/vh_db.xml -->,把数据库连接文件包含进来.
			 * 这样就可以加载etc/vh_db.xml文件了。
			 */
			$win = $node_cfg['win'];
			if($win){
				$driver = "bin/vhs_mysql.dll";
			}else{
				$driver = "bin/vhs_mysql.so";
			}
			$phpmyadmin_password = getRandPasswd(12);
		
			$tpl = tpl::singleton();
			$tpl->assign('phpmyadmin_password',$phpmyadmin_password);
			$tpl->assign('win',$win);
			$tpl->assign('skey',$GLOBALS['skey']);
			$tpl->assign('node',$node);
			$tpl->assign('driver',$driver);
			$tpl->assign('col_map',daocall('vhost','getColMap', array($node)));
			$tpl->assign('load_sql',daocall('vhost','getLoadSql', array($node)));
			$tpl->assign('flush_sql',daocall('vhost','getFlushSql', array(null)));
			$tpl->assign('load_info_sql',daocall('vhostinfo','getLoadInfoSql', array(null)));
			$tpl->assign('table',daocall('vhost','getTable'));
			$tpl->assign('col',daocall('vhost','getCols'));
			global $db_cfg;
			if($db_cfg['ftp']){
				$db = $db_cfg['ftp'];
			}else{
				$db = $db_cfg['default'];
			}
			$db_local = $this->isLocalHost($db['host']);
			$node_local = $this->isLocalHost($node_cfg['host']);
			if($db_local && !$node_local){
				$host = $_SERVER['SERVER_ADDR'];
				if($host==""){
					$host = $_SERVER['SERVER_NAME'];
				}
				if($host=="" || $this->isLocalHost($host)){
					trigger_error("Cann't init node,I Cann't translate the db host.");
					return false;
				}
				//如果db host是local,而节点不是local,则要替换db的host为公网IP
				$db['host'] = $host;
			}
			$tpl->assign('db',$db);	
			$tpl->assign('dev',$node_cfg['dev']);
			$whmCall = new WhmCall('core.whm','write_file');
			$whmCall->addParam('file', 'etc/vh_db.xml');
			
			$content = $tpl->fetch('config/vh_db.xml');
			$whmCall->addParam('content',base64_encode($content));
			$result = $whm->call($whmCall);	
			
			/*
			 * 写入模板文件,etc/templete.xml
			 */
			$content = $tpl->fetch('config/templete.xml');
			$whmCall = new WhmCall('core.whm','write_file');
			$whmCall->addParam('file', 'ext/templete.xml');
			$whmCall->addParam('content',base64_encode($content));
			$result = $whm->call($whmCall);
			/*
			 * 写入ftp配置文件
			 */
			$whmCall = new WhmCall('core.whm','write_file');
			if($win){
				$content = $tpl->fetch('config/linxftp.conf');			
				$whmCall->addParam('file','etc/linxftp.conf');
			}else{
				$content = $tpl->fetch('config/proftpd.conf');
				$whmCall->addParam('file','/vhs/proftpd/etc/proftpd.conf');
			}
			$whmCall->addParam('content',base64_encode($content));
			$result = $whm->call($whmCall);			
			/*
			 * 写do_config.php
			 */
			$content = $tpl->fetch('config/db_config.conf');
			$whmCall = new WhmCall('core.whm','write_file');
			$whmCall->addParam('file', 'etc/db_config.php');
			$whmCall->addParam('content',base64_encode($content));
			$result = $whm->call($whmCall);
			$whmCall = new WhmCall('vhost.whm','reboot_ftp');
			$result = $whm->call($whmCall);
		}
		if($init_flag == 1){
			/*
			 * 调用init_node，初始化节点，如开启磁盘quota等等操作
			 */
			$whmCall = new WhmCall('vhost.whm','init_node');
			$whmCall->addParam('dev',$node_cfg['dev']);
			$whmCall->addParam('prefix',apicall('vhost','getPrefix'));
			$whmCall->addParam('phpmyadmin_password',$phpmyadmin_password);
			$result = $whm->call($whmCall);
		}
		if($reboot_flag == 1){
			/*
			 * 调用重启,使设置生效
			 */
			$whmCall = new WhmCall('core.whm','reboot');
			$whm->call($whmCall);
		}
		if(!$result){
			trigger_error($whmCall->getCallName()." ".$whm->err_msg);
			return false;
		}
		return true;		
	}
	/**
	 * 
	 * 重建节点配置文件
	 */
	public function flush()
	{
		$nodes = daocall('nodes','listNodes');
		return apicall('utils','writeConfig',array($nodes,'name','node'));
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
	public function checkNode($node)
	{
		$whm = $this->makeWhm($node);
		$ret = array();
		$ret['whm'] = 0;
		if($whm){		
			$whmCall = new WhmCall('core.whm','check_vh_db');
			$result = $whm->call($whmCall,5);
			if($result && intval($result->get('status'))==1){
				$ret['whm'] = 1;
			}
		}
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if($node_cfg['db_type'] != "" && $node_cfg['db_user']!=""){
			$db = $this->makeDbProduct($node);
			if($db){
				$ret['db'] = 1;
			}else{
				$ret['db'] = 0;
			}
		}else{
			$ret['db'] = 2;
		}
		return $ret;
	}
	public function checkNodes()
	{
		$node_cfgs = $GLOBALS['node_cfg'];
		$nodes = array();
		$keys = array_keys($node_cfgs);
		for($i = 0;$i<count($keys);$i++){
			$nodes[$keys[$i]] = $this->checkNode($keys[$i]);
		}
		return $nodes;
	}
}
?>

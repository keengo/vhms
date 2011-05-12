<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class VhostDAO extends DAO{
	private $vh_col_map = array('name','doc_root','user','group','templete','status');
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"name" => 'name',
			'passwd'=>'passwd',
			'doc_root'=>'doc_root',
			'uid'=>'uid',
			'gid'=>'gid',
		 	'templete'=>'templete',
			'subtemplete'=>'subtemplete',
			'create_time'=>'create_time',
			'expire_time'=>'expire_time',
			'status'=>'status',
			'node'=>'node',
			'product_id'=>'product_id',
			'username'=>'username'
		);
		$this->MAP_TYPE = array(
			'passwd'=>FIELD_TYPE_MD5,
			'uid'=>FIELD_TYPE_INT,
			'state'=>FIELD_TYPE_INT,
			'product_id'=>FIELD_TYPE_INT,
			'create_time'=>FIELD_TYPE_DATETIME,
			'expire_time'=>FIELD_TYPE_DATETIME		
		);
		$this->_TABLE = DBPRE . 'vhost';
	}
	/*
	public function getVhostByname($name)
	{
		return $this->select(null,$this->getFieldValue2('name', $name),'row');
	}
	*/
	public function pageVhostByuser($username,$page,$page_count,&$count)
	{
		return $this->selectPage(
					array('name','uid','templete','node','create_time','expire_time','status','product_id','username'),
					$this->getFieldValue2('username',$username), 
					'name', 
					true, 
					$page,
					$page_count,
					$count
				);
	}
	public function pageVhost($page,$page_count,&$count)
	{
		return $this->selectPage(
					array('name','uid','username','templete','node','doc_root','create_time','expire_time','product_id','status'),
					null, 
					'uid', 
					true, 
					$page,
					$page_count,
					$count
				);
	}
	
	public function updateMinUid(&$uid)
	{
		$min_uid = 1000;
		$arr = array('uid'=>$min_uid+$uid);
		$result = $this->update($arr,$this->getFieldValue2('uid', $uid));
		if($result){
			$uid += $min_uid;
		}
		return $result;
	}
	public function check($user)
	{
		$sql = "SELECT 1 FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('name', $user);
		return $this->executex($sql,'row');
	}
	public function addMonth($name,$month)
	{
		$arr = array('expire_time' => 'ADDDATE('.$this->MAP_ARR['expire_time'].',INTERVAL '.$month.' MONTH)');
		return $this->update($arr, $this->getFieldValue2('name', $name));
	}
	public function changeProduct($name,$product_id)
	{
		$arr = array('product_id'=>$product_id);
		return $this->update($arr,$this->getFieldValue2('name', $name));
	}
	/**
	 * 插入用户信息信息
	 */
	public function insertVhost($username,$name,$passwd,$doc_root,$group,$templete,$subtemplete,$status,$node,$product_id,$month)
	{
		$arr=array();
		$arr['username']=$username;
		$arr['name'] = $name;
		$arr['passwd'] = $passwd;
		$arr['doc_root'] = $doc_root;
		$arr['gid'] = $group;
		$arr['templete'] = $templete;
		$arr['subtemplete'] = $subtemplete;
		$arr['status'] = $status;
		$arr['node'] = $node;
		$arr['product_id'] = $product_id;
		$arr['create_time'] = 'NOW()';
		$arr['expire_time'] = 'ADDDATE(NOW(),INTERVAL '.$month.' MONTH)';
		$result = $this->insertData($arr);
		
		if($result){
			try{
				$id = $this->db->lastInsertId();				
			}catch(PDOException $e){
				//print_r($e);
				//todo alter use select to select id;
			}
			return $id;
		}
		return false;
	}
	public function updatePassword($username,$passwd)
	{
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('passwd',$passwd)." WHERE ".$this->getFieldValue2('name', $username);
		return $this->executex($sql);
	}
	/**
	 * 更新用户信息
	 */
	public function updateVhost($vhostName, $arr)
	{
		return $this->update($arr,$this->getFieldValue2('name', $vhostName));
	}
	/**
	 * 删除用户信息
	 */
	public function delVhost($vhostName,$username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		if($username){
			$sql = "DELETE FROM {$tbl} WHERE `name` = '{$vhostName}' and `username`='{$username}' LIMIT 1";
		}else{
			$sql = "DELETE FROM {$tbl} WHERE `name` = '{$vhostName}' LIMIT 1";
		}
		$ret = $this->execute($host, $dbname, $sql);
		if($ret || is_array($ret) && count($ret) == 1) {
			return true;
		}else {
			return false;
		}
	}
	public function listVhostByNode($node)
	{
		return $this->getData($this->getFieldValue2('node', $node));
	}
	public function listVhostByUid($uid,$result='rows')
	{
		$where = $this->getFieldValue2('uid', $uid);
		return $this->getData($where,$result);
	}
	public function listVhostByName($name,$result='rows')
	{
		$where = $this->getFieldValue2('name', $name);
		return $this->getData($where,$result);
	}
	public function listVhost($username,$result='rows')
	{
		$where = "";
		if($username){
			$where = $this->getFieldValue2('username', $username);
		}
		return $this->getData2(array('name','uid','create_time','expire_time','status','node','product_id'),$where,$result);
	}
	public function listMyVhost($username,$result='rows')
	{
		if($username=="" || $username==null){
			return false;
		}
		return $this->listVhost($username,$result);
	}
	public function getFlushSql()
	{
		return " AND ".$this->MAP_ARR['name']."='%s'";
	}
	public function getLoadSql($node)
	{
		$sql = "SELECT ";
		for($i=0;$i<count($this->vh_col_map);$i++){
			if($i>0){
				$sql.=',';
			}
			$col_name = $this->vh_col_map[$i];
			if($col_name=='user'){
				$col_name = $this->getUserColName($node);
			}else if($col_name=='group'){
				$col_name = $this->getGroupColName($node);
			}else if($col_name=='doc_root'){
				$col_name = $this->getDocRootColName($node);
			}else if($col_name=='templete'){
				$col_name = "CONCAT(".$this->MAP_ARR['templete'].",':',".$this->MAP_ARR['subtemplete'].") AS templete";
			}else{
				$col_name = $this->MAP_ARR[$col_name];
			}
			$sql.= $col_name;
		}
		$sql .= " FROM ".$this->_TABLE." WHERE ";
		$sql.=$this->getFieldValue2('node', $node);
		return $sql;
	}
	public function getColMap($node)
	{
		for($i=0;$i<count($this->vh_col_map);$i++){
			if($i>0){
				$col_map.=',';
			}
			if($this->vh_col_map[$i]=="group"){
				$col_map.=$this->getGroupKangleName($node);
			}else{
				$col_map.=$this->vh_col_map[$i];
			}
		}
		return $col_map;
	}
	private function getGroupColName($node)
	{
		if(apicall('nodes','isWindows',array($node))){
			return $this->MAP_ARR['gid']." AS `group`";
		}else{
			return "CONCAT('#',".$this->MAP_ARR['gid'].") AS `group`";
		}
	}
	private function getDocRootColName($node)
	{
		load_conf('pub:node');
		$node_cfg = $GLOBALS['node_cfg'][$node];
		if(is_array($node_cfg) && $node_cfg['win'] == 1){
			return "CONCAT('".$node_cfg['dev']."'".",".$this->MAP_ARR['doc_root'].") AS doc_root";
		}
		return $this->MAP_ARR['doc_root'];
	}
	private function getUserColName($node)
	{
		if(apicall('nodes','isWindows',array($node))){
			return "CONCAT('a',".$this->MAP_ARR['uid'].") AS user";
		}else{
			return "CONCAT('#',".$this->MAP_ARR['uid'].") AS user";
		}
	}
	public function getVhost($name,$fields=null)
	{
		return $this->getData2($fields,$this->getFieldValue2('name', $name),'row');
	}
	public function getNode($name){
		$sql = "SELECT ".$this->MAP_ARR['node']." FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('name', $name);
		$row = $this->executex($sql,'row');
		return $row['node'];
	}
	public function getGroupKangleName($node)
	{
		if(apicall('nodes','isWindows',array($node))){
			return "password";
		}
		return "group";
	}
	public function expireUser()
	{
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('status', 9)." WHERE ".$this->MAP_ARR['expire_time']."<NOW()";
		return $this->executex($sql,'result');
	}
}
?>
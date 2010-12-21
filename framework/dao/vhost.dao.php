<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class VhostDAO extends DAO{
	
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
			'create_time'=>'create_time',
			'expire_time'=>'expire_time',
			'state'=>'state',
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
	public function check($user)
	{
		$sql = "SELECT 1 FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('name', $user);
		return $this->executex($sql,'row');
	}
	/**
	 * 查询用户信息信息
	 */
	public function getVhost($vhostName)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl} WHERE `name`='{$vhostName}'";
		$value = $this->execute($host, $dbname, $sql, "row");
		if($value === false) {
			return false;
		}
		if(!$value && is_array($value)) {
			return null;
		}
		return $value;
	}
	/**
	 * 插入用户信息信息
	 */
	public function insertVhost($username,$name,$passwd,$doc_root,$group,$templete,$state,$node,$product_id,$month)
	{
		$arr=array();
		$arr['username']=$username;
		$arr['name'] = $name;
		$arr['passwd'] = $passwd;
		$arr['doc_root'] = $doc_root;
		$arr['gid'] = $group;
		$arr['templete'] = $templete;
		$arr['state'] = $state;
		$arr['node'] = $node;
		$arr['product_id'] = $product_id;
		$arr['create_time'] = 'NOW()';
		$arr['expire_time'] = 'ADDDATE(NOW(),INTERVAL '.$month.' MONTH)';
		return $this->insertData($arr);		
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
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$update_str = $this->updateFields($arr,$this->MAP_ARR);
		$sql = "UPDATE {$tbl} SET ".$update_str." WHERE `name` = '{$vhostName}' limit 1";
		return $this->execute($host, $dbname, $sql);
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
		return $this->getData2(array('name','uid','create_time','expire_time','state','node','product_id'),$where,$result);
	}
	public function listMyVhost($username,$result='rows')
	{
		if($username=="" || $username==null){
			return false;
		}
		return $this->listVhost($username,$result);
	}
}
?>
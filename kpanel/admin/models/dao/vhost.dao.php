<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class VhostDAO extends DAO{
	
	private $_TABLE	= 'hosts';

	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"name" => 'name',
			"username" => 'username',
			"ftpuser"=>'ftpuser',
			"ftppwd"=>'ftppwd',
		);
		$this->_TABLE = DBPRE . $this->_TABLE;
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
	public function insertVhost($arr)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = $this->insertSql($tbl,$arr,$this->MAP_ARR);
		$ret = $this->execute($host, $dbname, $sql);
		return $ret;
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
	/**
	 * 删除用户信息
	 */
	public function listVhost($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		if($username){
			$sql = "SELECT * FROM {$tbl} WHERE `username` = '{$username}'";
		}else{
			$sql = "SELECT * FROM {$tbl}";
		}
		$ret = $this->execute($host, $dbname, $sql,'rows');
		if($ret) {
			return $ret;
		}else {
			return false;
		}
	}

}
?>
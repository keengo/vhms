<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class AdminUserDAO extends DAO{
	
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"username" => 'username',
			"passwd" => 'passwd',
			"last_login" => 'last_login',
			"last_ip" => 'last_ip',
			"right" => 'right'
		);
		$this->_TABLE = DBPRE . 'admin_users';
	}
	/**
	 * 查询用户信息信息
	 */
	public function getUser($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl} WHERE `username`='{$username}'";
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
	public function insertUser($arr)
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
	public function updateUser($username, $arr)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$update_str = $this->updateFields($arr,$this->MAP_ARR);
		$sql = "UPDATE {$tbl} SET ".$update_str." WHERE `username` = '{$username}' limit 1";
		return $this->execute($host, $dbname, $sql);
	}

	/**
	 * 删除用户信息
	 */
	public function delUser($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "DELETE FROM {$tbl} WHERE `username` = '{$username}' LIMIT 1";
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
	public function list_user()
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl}";
		$ret = $this->execute($host, $dbname, $sql,'rows');
		if($ret) {
			return $ret;
		}else {
			return false;
		}
	}

}
?>
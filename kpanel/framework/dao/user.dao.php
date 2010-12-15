<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class UserDAO extends DAO{
	

	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"username" => 'username',
			"passwd" => 'passwd',
			"email" => 'email',
			"regtime" => 'regtime',
			"name" => 'name',
			"money" => 'money',
			"id"=>'id'
		);
		$this->MAP_TYPE = array(
			'money'=>FIELD_TYPE_INT,
			'passwd'=>FIELD_TYPE_MD5
		);
		$this->_TABLE = DBPRE . 'users';
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
		$sql = "SELECT * FROM {$tbl} WHERE ".$this->getFieldValue2('username',$username);
	//	echo $sql;
		return $this->executex($sql, "row");		
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
	public function updateMoney($username,$money)
	{
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->MAP_ARR['money']."=".$this->MAP_ARR['money']."+".intval($money)." WHERE username='".$username."'";
		//die($sql);
		return $this->executex($sql);
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
	public function listUser($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl}";
		if($username!=""){
			$sql.=" WHERE ".$this->getFieldValue2('username', $username);
		}
		return $this->executex($sql,'rows');
	}

}
?>
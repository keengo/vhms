<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class FtpDAO extends DAO{
	
	private $_TABLE	= 'ftpuser';

	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"ftpname" => 'ftpname',
			"ftppasswd" => 'ftppasswd',
			"homedir" => 'homedir',
			"accessed" => 'accessed',
			"username" => 'username',
			"spacetype" => 'spacetype',
			"uid"=>'uid',
			"gid"=>'gid',
		);
		$this->_TABLE = DBPRE . $this->_TABLE;
	}
	/**
	 * 查询用户信息信息
	 */
	public function getFtp($ftpname)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl} WHERE `ftpname`='{$ftpname}'";
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
	public function insertFtp($arr)
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
	public function updateFtp($ftpname, $arr)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$update_str = $this->updateFields($arr,$this->MAP_ARR);
		$sql = "UPDATE {$tbl} SET ".$update_str." WHERE `ftpname` = '{$ftpname}' limit 1";
		return $this->execute($host, $dbname, $sql);
	}

	/**
	 * 删除用户信息
	 */
	public function delFtp($ftpname,$username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		if($username){
			$sql = "DELETE FROM {$tbl} WHERE `ftpname` = '{$ftpname}' and `username	='{$username}' LIMIT 1";
		}else{
			$sql = "DELETE FROM {$tbl} WHERE `ftpname` = '{$ftpname}' LIMIT 1";
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
	public function listFtp($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		if($username){
			$sql = "SELECT * FROM {$tbl} WHERE `username`='".$username."'";
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
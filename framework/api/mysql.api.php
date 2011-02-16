<?php
class MysqlAPI extends API
{
	public function add($node,$user,$passwd)
	{
		$sqls = array(
			"CREATE USER '".$user."'@'localhost' IDENTIFIED BY '".$passwd."'",
			"CREATE DATABASE IF NOT EXISTS `".$user."`",
			"GRANT ALL PRIVILEGES ON `".$user."` . * TO '".$user."'@'localhost'"
		);
		return $this->query($node,$sqls);
	}
	public function remove($node,$user)
	{
		$sqls = array(
			"DROP USER '".$user."'@'localhost'",
			"DROP DATABASE '".$user."'"
		);
		return $this->query($node,$user);
	}
	public function password($node,$user,$passwd)
	{
		return $this->query($node,array("SET PASSWORD FOR '".$user."'@'localhost' = PASSWORD( '".$passwd."' )"));
	}
	public function used($node,$user)
	{
		$sql = "SELECT sum(Data_length ) + sum( Index_length ) FROM information_schema.`TABLES` WHERE TABLE_SCHEMA = '".$user."'";
		
	}
	public function connect($node)
	{
		
	}
	private function query($node,array $sqls)
	{
		$pdo = $this->connect($node);
		for($i=0;$i<count($sqls);$i++){
			$pdo->execute($sqls[$i]);
		}
	}
}
?>

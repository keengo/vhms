<?php
abstract class DbProduct
{
	static public function getUser($uid)
	{
		return "a".$uid;
	}
	public function connect($node)
	{

		$dsn = $node['db_type'].":host=".$node['host'];
		$db_port = $node['db_port'];
		if($db_port){
			$dsn.=';port='.$db_port;
		}
		try{
			$this->pdo = new PDO($dsn,$node['db_user'],$node['db_passwd']);
		}catch(Exception $e){
			return false;
		}
		return true;
	}
	abstract public function add($uid,$passwd);
	abstract public function remove($uid);
	abstract public function password($uid,$passwd);
	abstract public function used($uid);
	protected $pdo;
};
?>

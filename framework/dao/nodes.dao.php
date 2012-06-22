<?php
class NodesDAO extends DAO 
{
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(	
			"name" 		=> 'name',
			"host" 		=> 'host',
			"port"		=> 'port',
			"passwd"	=> 'passwd',
			'nickname'	=> 'nickname'
		);
		$this->MAP_TYPE = array(
			'port'		=>FIELD_TYPE_INT
		);
		$this->_TABLE = DBPRE . 'nodes';
	}
	
	public function getNode($name)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl} WHERE `name`='{$name}'";
		$value = $this->execute($host, $dbname, $sql, "row");
		if($value === false) {
			return false;
		}
		if(!$value && is_array($value)) {
			return null;
		}
		return $value;
	}
	
	public function insertNode($arr)
	{
		return $this->insertData($arr);		
	}

	public function updateNode($name, $arr)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$update_str = $this->updateFields($arr,$this->MAP_ARR);
		$sql = "UPDATE {$tbl} SET ".$update_str." WHERE `name` = '{$name}' limit 1";
		return $this->execute($host, $dbname, $sql);
	}
	public function del($name)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "DELETE FROM {$tbl} WHERE `name` ='{$name}' LIMIT 1";
		$ret = $this->execute($host, $dbname, $sql);
		if($ret || is_array($ret) && count($ret) == 1) {
			return true;
		}else {
			return false;
		}
	}
	public function getAllNodes()
	{
		return $this->getData2(array('name'));
	}
	public function listNodes()
	{
		$sql = "SELECT ".$this->AllQueryFields()." FROM ".$this->_TABLE;
		return $this->executex($sql,'rows');
	}
}
?>
<?php

/**
 * �û���Ϣ��ϢDAO��������
 */
class NodesDAO extends DAO {

	

	public function __construct()
	{	//���ػ�db�ļ�
		parent::__construct();
		$this->MAP_ARR 	= array(		//�û���Ϣ��Ϣ�ֶζ��ձ�
			"name" => 'name',
			"host" => 'host',
			"port"=> 'port',
			"user"=>'user',
			"passwd"=>'passwd',
			"state"=>'state'
		);
		$this->MAP_TYPE = array(
			'port'=>FIELD_TYPE_INT
		);
		$this->_TABLE = DBPRE . 'nodes';
	}
	/**
	 * ��ѯ�û���Ϣ��Ϣ
	 */
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
	/**
	 * �����û���Ϣ��Ϣ
	 */
	public function insertNode($arr)
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
	 * �����û���Ϣ
	 */
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

	/**
	 * ɾ���û���Ϣ
	 */
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
	/**
	 * ɾ���û���Ϣ
	 */
	public function listNodes()
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
			return null;
		}
	}

}
?>
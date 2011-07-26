<?php
class VhostinfoDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR 	= array(
			"vhost" => 'vhost',
			'type'=> 'type',
			"name" => 'name',
			"value"=> 'value'
			);
			$this->MAP_TYPE = array(
			'type'=>FIELD_TYPE_INT
			);
			$this->_TABLE = DBPRE . 'vhost_info';
	}
	public function getDomainCount($vhost)
	{
		$sql = "SELECT COUNT(*) FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('vhost',$vhost)." AND ".$this->getFieldValue2('type', 0);
		$ret = $this->executex($sql,'row');
		if (!$ret) {
			return false;
		}
		return $ret[0];
	}
	public function findDomain($domain)
	{
		$where = $this->getFieldValue2('name',$domain)." AND ".$this->getFieldValue2('type', 0);
		return $this->getData2(array('vhost'),$where,'row');
	}
	public function delAllInfo($vhost)
	{
		return $this->delData($this->getFieldValue2('vhost',$vhost));
	}
	public function delInfo($vhost,$name,$type,$value)
	{
		$where = $this->getFieldValue2('vhost',$vhost);
		$where.=' AND '.$this->getFieldValue2('type', $type);
		$where.=' AND '.$this->getFieldValue2('name', $name);
		if($value!=null){
			$where.=' AND '.$this->getFieldValue2('value', $value);
		}
		return $this->delData($where);
	}
	public function addInfo($vhost,$name,$type,$value,$multi=true)
	{
		if(!$multi){
			$this->delInfo($vhost,$name,$type,null);
		}
		return $this->insert(array('vhost'=>$vhost,'name'=>$name,'type'=>$type,'value'=>$value));
	}
	public function getInfo($name,$type=null)
	{
		$where = $this->getFieldValue2('vhost',$name);
		if($type){
			$where.=" AND ".$this->getFieldValue2('type', $type);
		}
		return $this->getData2(array('name','type','value'),$where);
	}
	public function getDomain($name)
	{
		$where = $this->getFieldValue2('vhost',$name)." AND ".$this->getFieldValue2('type', 0);
		return $this->getData2(array('name','value'),$where);
	}
	public function delDomain($name,$domain)
	{
		$where = $this->getFieldValue2('vhost',$name)." AND ".$this->getFieldValue2('type', 0);
		$where.=' AND ';
		$where.= $this->getFieldValue2('name', $domain);
		return $this->delData($where);
	}
	public function getLoadInfoSql()
	{
		$sql = "SELECT ".$this->MAP_ARR['type'].",".$this->MAP_ARR['name'].",".$this->MAP_ARR['value']." FROM ".$this->_TABLE." WHERE ".$this->MAP_ARR['vhost']."='%s'";
		return $sql;
	}
}
?>

<?php
class DomainDAO extends DAO
{
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(
			"name" => 'name',
			"domain" => 'domain',
			"dir"=> 'dir'
		);
		$this->_TABLE = DBPRE . 'domain';
	}
	public function findDomain($domain)
	{
		$where = $this->getFieldValue2('domain',$domain);
		return $this->getData2(array('name'),$where);
	}
	public function getDomain($name)
	{
		$where = $this->getFieldValue2('name',$name);
		return $this->getData2(array('domain','dir'),$where);
	}
	public function delDomain($name,$domain)
	{
		$where = $this->getFieldValue2('name', $name);
		$where.=' AND ';
		$where.= $this->getFieldValue2('domain', $domain);
		return $this->delData($where);
	}
}
?>

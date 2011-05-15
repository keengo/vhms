<?php
class SettingDAO extends DAO
{
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(
			"name" => 'name',
			"value" => 'value'
		);
		$this->MAP_TYPE = array(
		);
		$this->_TABLE = DBPRE . 'setting';
	}
	public function add($name,$value)
	{
		$arr['name'] = $name;
		$arr['value'] = $value;
		return $this->insert($arr,'REPLACE');
	}
	public function get($name)
	{
		$ret = $this->getData2(array('value'),$this->getFieldValue2('name', $name),'row');
		if(!$ret){
			return null;
		}
		return $ret['value'];
	}
	public function getAll()
	{
		return $this->getData();
	}
}
?>

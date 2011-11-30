<?php
class MproductgroupDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR = array(
			'id' => 'id',
			'name' => 'name',
			'describe' => 'describe'
		);
		$this->MAP_TYPE = array(
			'id' => FIELD_TYPE_INT|FIELD_TYPE_AUTO
		);
		$this->_TABLE = 'mproduct_group';
	}
	
	public function add($arr)
	{
		if ($_REQUEST['id']) {
			return $this->update($arr, $this->getFieldValue2('id', $id));
		}
		return $this->insert($arr);
	}
	public function del($id)
	{
		return $this->delData($this->getFieldValue2('id', $id));
	}
	public function getMproductgroup($id)
	{
		return $this->select(null,$this->getFieldValue2('id', $id));
	}
		
		
		
		
		
}
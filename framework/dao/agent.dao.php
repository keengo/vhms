<?php
class AgentDAO extends DAO
{
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"id" => 'id',
			"name" => 'name'
			);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_INT|FIELD_TYPE_AUTO
			);
			$this->_TABLE = DBPRE . 'agent';
	}
	public function add($attr)
	{
		$arr['name'] = $attr['name'];
		if($attr['id'])
		{
			return $this->update($arr, $this->getFieldValue2('id', $attr['id']));
		}
		return $this->insert($arr);
	}
	public function del($id)
	{
		return $this->delData($this->getFieldValue2('id',$id));
	}
	public function get($id)
	{
		return $this->select(array('id','name'),$this->getFieldValue2('id', $id));
	}
	public function selectList()
	{
		return $this->select(null);
	}
	
}
?>
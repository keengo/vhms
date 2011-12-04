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
		if ($arr['id']) {
			return $this->update($arr, $this->getFieldValue2('id', $arr['id']));
		}
		return $this->insert($arr);
	}
	public function del($id)
	{
		return $this->delData($this->getFieldValue2('id', $id));
	}
	public function getMproductgroup($id=null)
	{
		$where = "";
		if($id != null) {
			$where = $this->getFieldValue2('id', $id);
		}
		return $this->select(null,$where);
	}
	public function pageList($page,$page_count,&$count,$order)
	{
		$where="";
		if($order) {
			$order_field = $order;
		}else{
			$order_field='id';
		}
		
		return $this->selectPage(array('id','name','describe'),
									 $where,
									 $order_field,
									 true,
									 $page,
									 $page_count,
									 $count
								);
	}
		
		
		
		
		
}
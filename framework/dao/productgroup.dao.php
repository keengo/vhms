<?php 
class ProductgroupDAO extends DAO
{
	public function __construct()
	{
		$this->MAP_ARR = array(
			'group_id'		=> 'group_id',
			'group_name'	=> 'group_name',
		
		);
		$this->MAP_TYPE = array(
			'group_id'		=>FIELD_TYPE_INT|FIELD_TYPE_AUTO,
		);
		$this->_TABLE = 'product_group';
	}
	public function productgroupAdd($arr)
	{
		return $this->insert($arr);
	}
	public function productgroupUpdate($group_id,$arr)
	{
		return $this->update($arr, $this->getFieldValue2('group_id', $group_id));
	}
	public function productgroupDel($group_id)
	{
		return $this->delData($this->getFieldValue2('group_id', $group_id));
	}
	public function productgroupGet($group_id)
	{
		return $this->select(null,$this->getFieldValue2('group_id', $group_id),'row');
	}
	public function productgroupGetAll()
	{
		$where = null;
		return $this->select(null,$where);
	}
	public function productgroupPageList($page,$page_count,&$count)
	{
		return $this->selectPage(
							array('group_id','group_name'),
							null,
							'group_id',
							true,
							$page,
							$page_count,
							$count
						);
	}
}




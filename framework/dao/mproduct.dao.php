<?php
class MproductDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR = array(
			'id' => 'id',
			//产品名称
			'name' => 'name',
			//产品类型ID
			'group_id' => 'group_id',
			//产品组ID，升级使用，同组产品可升级
			'upid' => 'upid',
			//产品介绍
			'describe' => 'describe',
			//价格
			'price' => 'price',
			//支持月付
			'month_flag' => 'month_flag',
			//是否暂停销售
			'pause_flag' =>'pause_flag'
		);
		$this->MAP_TYPE = array(
			'id' => FIELD_TYPE_INT|FIELD_TYPE_AUTO,
			'group_id' => FIELD_TYPE_INT,
			'upid' => FIELD_TYPE_INT,
			'price' => FIELD_TYPE_INT,
			'month_flag' => FIELD_TYPE_INT,
			'pause_flag' => FIELD_TYPE_INT
		);
		$this->_TABLE = 'mproduct';
	}
	public function add($arr)
	{
		if($arr['id']){
			return $this->update($arr, $this->getFieldValue2('id', $arr['id']));
		}
		return $this->insert($arr);
	}
	public function del($id)
	{
		return $this->delData($this->getFieldValue2('id', $id));
	}
	public function pageList($page,$page_count,&$count,$selectwhere)
	{
		$where = "";
		if($selectwhere['group_id']) {
			$where .= $this->getFieldValue2('group_id', $selectwhere['group_id']);
		}
		if($selectwhere['pause_flag']) {
			$where .= $this->getFieldValue2('pause_flag', $selectwhere['pause_flag']);
		}
		return $this->selectPage(array('id','name','group_id',
								'upid','describe','price',
								'month_flag','pause_flag'),
				 				$where, 'id', true,
				 				 $page, $page_count, $count
				 				 );
	}
	
}
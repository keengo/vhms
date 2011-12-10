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
			//支持月付,1支持,0不支持
			'month_flag' => 'month_flag',
			//是否暂停销售,1暂停,
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
	public function getMproductByGroupid($groupid)
	{
		return $this->select(null,$this->getFieldValue2('group_id', $groupid),'rows');
	}
	public function getMproductById($id=null)
	{
		$where = "";
		$type = 'rows';
		if($id != null) {
			$where = $this->getFieldValue2('id', $id);
			$type = 'row';
		}
		return $this->select(null,$where,$type);
	}
	public function add($arr)
	{
		$arr['price']*=100;
		if($arr['id']){
			return $this->update($arr, $this->getFieldValue2('id', $arr['id']));
		}
		$result = $this->insert($arr);
		if($result){
			try{
				$id = $this->db->lastInsertId();
			}catch(PDOException $e){
				//print_r($e);
				//todo alter use select to select id;
			}
			return $id;
		}
		return false;
	}
	public function del($id)
	{
		return $this->delData($this->getFieldValue2('id', $id));
	}
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $page
	 * @param unknown_type $page_count
	 * @param unknown_type $count
	 * @param 排序字段 $order
	 * @param unknown_type $selectwhere
	 */
	public function pageList($page,$page_count,&$count,$order,$selectwhere=null)
	{
		$where = "";
		if($selectwhere['group_id']) {
			$where .= $this->getFieldValue2('group_id', $selectwhere['group_id']);
		}
		if($selectwhere['pause_flag']) {
			$where .= $this->getFieldValue2('pause_flag', $selectwhere['pause_flag']);
		}
		if($order){
			$order_field = $order;
		}else{
			$order_field = 'id';
		}
		return $this->selectPage(array('id',
									'name',
									'group_id',
									'upid',
									'describe',
									'price',
									'month_flag',
									'pause_flag'
									),
				 					$where,
				 					$order_field, 
				 					true, 
				 					$page, 
				 					$page_count, 
				 					$count 
				 				);
	}
	
}
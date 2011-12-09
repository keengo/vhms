<?php
class MproductorderDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR = array(
			'id' => 'id',
			'username' => 'username',
			'product_id' => 'product_id',
			'client_msg' => 'client_msg',
			'admin_msg' => 'admin_msg',
			'admin_mem' => 'admin_mem',
			'price' => 'price',
			'month' => 'month',
			'create_time' => 'create_time',
			'expire_time' => 'expire_time',
			'status' => 'status'
			);
		$this->MAP_TYPE = array(
			'id' => FIELD_TYPE_INT|FIELD_TYPE_AUTO,
			'product_id' =>FIELD_TYPE_INT,
			'price' =>FIELD_TYPE_INT,
			'month' =>FIELD_TYPE_INT,
			'status' =>FIELD_TYPE_INT,
			'create_time' =>FIELD_TYPE_DATETIME,
			'expire_time' =>FIELD_TYPE_DATETIME
			);
		$this->_TABLE = 'mproduct_order';
	}
	/**
	 * 插入和更新  条件$arr['id']
	 * @param  $arr
	 */
	public function add($attr)
	{
		$arr['username'] = $attr['username'];
		
		$arr['client_msg'] = $attr['client_msg'];
		
		if($attr['product_id']) {
			$arr['product_id'] = $attr['product_id'];
		}
		if($attr['admin_msg']) {
			$arr['admin_msg'] = $attr['admin_msg'];
		}
		if($attr['admin_mem']) {
			$arr['admin_mem'] = $attr['admin_mem'];
		}
		
		$arr['price'] = $attr['price'];
		$arr['month'] = $attr['month'];
		$arr['create_time'] = 'NOW()';
		$arr['expire_time'] = time()+$attr['last_month']*2592000;
		$arr['status'] = $attr['status'] or 0;
		if($attr['id']) {
			return $this->update($arr, $this->getFieldValue2('id', $attr['id']));
		}
		return $this->insert($arr);
	}
	public function del($id)
	{
		return $this->delData($this->getFieldValue2('id', $id));
	}
	/**
	 * 查询多个或单个,条件 id
	 * @param where $id
	 * @return Ambigous <boolean, PDOStatement, mixed>
	 */
	public function getMproductorder($id=null)
	{
		$where ="";
		$type='rows';
		if($id != null) {
			$where = $this->getFieldValue2('id', $id);
			$type='row';
		}
		return $this->select(null,$where,$type);
	}
	public function pageList($page,$page_count,&$count,$order,$selectwhere=null)
	{
		$where="";
		if($selectwhere['username'] !=null) {
			$where.=$this->getFieldValue2('username', $selectwhere['username']);
		}
		if($order) {
			$order_field = $order;
		}else{
			$order_field='id';
		}
		
		return $this->selectPage(array('id',
									'username',
									'product_id',
									'client_msg',
									'admin_msg',
									'admin_mem',
									'price',
									'month',
									'create_time',
									'expire_time',
									'status' 
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


?>
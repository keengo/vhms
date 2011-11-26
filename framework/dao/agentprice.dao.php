<?php
class AgentpriceDAO extends DAO
{
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"agent_id" => 'agent_id',
			"product_type" => 'product_type',
			"product_id" =>'product_id',
			"price" =>'price'
			);
		$this->MAP_TYPE = array(
			'agent_id'=>FIELD_TYPE_INT,
			'product_type'=>FIELD_TYPE_INT,
			'product_id'=>FIELD_TYPE_INT,
			'price'=>FIELD_TYPE_INT
			);
			$this->_TABLE = DBPRE . 'agent_price';
	}
	public function getAllAgentprice()
	{
		return $this->select(null);
	} 
	
	/**
	 * @deprecated 暂未用
	 * 
	 */
	//产品更新所用。
	public function updateAgentprice($arr)
	{
		
		$where = $this->getFieldValue2('agent_id', $arr['agent_id']);
		$where.=" and ".$this->getFieldValue2('product_type', $arr['product_type']);
		$where.=" and ".$this->getFieldValue2('product_id', $arr['product_id']);
		return $this->update($arr, $where);
	}
	
	//删除产品时所用，同步删除代理价格设置。
	public function delAgentprice($arr)
	{
		$where=$this->getFieldValue2('product_id', $arr['product_id']);
		$where.=" and ".$this->getFieldValue2('product_type', $arr['product_type']);
		return $this->delData($where);
	}
	
	//产品修改时所用，调用product_id显示代理价格
	/**
	 * 取得代理价格
	 * agent_id代理ID
	 * product_type产品分类，0虚拟主机，其他未定
	 * product_id产品ID
	 * Enter description here ...
	 * @param unknown_type $arr
	 */
	public function getAgentprice($arr)
	{
		$where = $this->getFieldValue2('agent_id', $arr['agent_id']);
		$where.=" and ".$this->getFieldValue2('product_type', $arr['product_type']);
		$where.=" and ".$this->getFieldValue2('product_id', $arr['product_id']);
		return $this->select(null,$where);
	}
	public function addAgentprice($attr)
	{
		$arr['agent_id'] = $attr['agent_id'];
		$arr['product_type'] = $attr['ptoduct_type'];
		$arr['product_id'] = $attr['product_id'];
		$arr['price'] = $attr['price'];
		return $this->insert($arr,'REPLACE');
	}
	public function pageListAgentprice($page,$page_count,&$count)
	{
		return $this->selectPage(array('agent_id','product_type','product_id','price'),
									 null,
									 'agent_id',
									 true,
									 $page,
									 $page_count,
									 $count
									);
	}
		
}
?>
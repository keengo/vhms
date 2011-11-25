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
	public function getAgentprice($arr)
	{
		return $this->select(null,
						$this->getFieldValue2('agent_id', $arr['agent_id'])
						." and ".
						$this->getFieldValue2('product_type', $arr['product_type'])
						." and ".
						$this->getFieldValue2('product_id', $arr['product_id'])
						);
	}
	public function addAgentprice($attr)
	{
		$arr['agent_id'] = $attr['agent_id'];
		$arr['product-type'] = $attr['ptoduct_type'];
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
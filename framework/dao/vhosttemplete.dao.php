<?php
class VhosttempleteDAO extends DAO {

	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(		
			"node" => 'node',
			"templete"=> 'templete',
			"weight"=>'weight',
			"state"=>'state'
		);
		$this->MAP_TYPE = array(
			'weight'=>FIELD_TYPE_INT,
			'state'=>FIELD_TYPE_INT,
		);
		$this->_TABLE = DBPRE . 'vhost_templete';
	}
	/**
	 * 更新模板state为无效，自动更新某服务器模板前先前调用。
	 * @param $node 服务器节点
	 */
	public function updateNodeState($node)
	{
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('state',0)." WHERE ".$this->getFieldValue2('node',$node);
		return $this->executex($sql);
	}
	/**
	 * 更新某服务器节点模板，如果已经存在就只更新state为有效，否则增加记录。
	 * @param $node 服务器节点
	 * @param $templete 模板(数组)
	 */
	public function updateNodeTemplete($node,$templete)
	{
		for($i=0;$i<count($templete);$i++){
			$where = $this->getFieldValue2('node',$node)." AND ".$this->getFieldValue2('templete', $templete[$i]);
			$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('state',1)." WHERE ".$where;
			if(!$this->executex($sql)){
				$sql = "INSERT ".$this->_TABLE." (node,templete,state) VALUES (".$this->getFieldValue('node',$node).",";
				$sql.=$this->getFieldValue('templete',$templete[$i]).",1)";
				$this->executex($sql);
			}			
		}
	}
	public function updateNodeTempleteWeight($node,$templete,$weight)
	{
		$where = $this->getFieldValue2('node',$node)." AND ".$this->getFieldValue2('templete', $templete);
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('weight', $weight)." WHERE ".$where;
		return $this->executex($sql,'result');
	}
	public function getAllTemplete()
	{
		$sql="SELECT templete FROM ".$this->_TABLE." GROUP BY templete";
		$result = $this->executex($sql,'rows');
		$templetes = array();
		for($i=0;$i<count($result);$i++){
			$templetes[] = $result[$i]['templete'];
		}
		return $templetes;
	}
	public function getTemplete($node,$templete)
	{
		$where = $this->getFieldValue2('node',$node)." AND ".$this->getFieldValue2('templete', $templete);
		return $this->getData($where,'row');
	}
	public function del($node,$templete)
	{
		$where = $this->getFieldValue2('node',$node)." AND ".$this->getFieldValue2('templete', $templete);
		return $this->delData($where);
	}
}
?>
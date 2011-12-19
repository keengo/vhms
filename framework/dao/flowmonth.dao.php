<?php
class FlowmonthDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR 	= array(
			"name" => 'name',
			"t" => 't',
			"flow" => 'flow'
			);
			$this->MAP_TYPE = array(

			);
			$this->_TABLE = DBPRE . 'flow_month';
	}
	public function add($name,$t,$flow)
	{
		$sql = "UPDATE ".$this->_TABLE." SET flow=flow + '".addslashes($flow)."' WHERE ".$this->getFieldValue2('name',$name);
		$sql.=" AND ".$this->getFieldValue2('t',$t);
		$result = $this->executex($sql,'result');
		if (!$result) {
			$arr = array(
			'name'=>$name,
			't'=>$t,
			'flow'=>$flow
			);
			return $this->insert($arr);
		}
		return $result;
	}
	public function get($name,$t)
	{
		$where = $this->getFieldValue2('name', $name);
		$where .= ' and '.$this->getFieldValue2('t', $t);
		return $this->select('flow',$where,'row');
	}

}
?>
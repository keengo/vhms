<?php
class VhostproductDAO extends DAO {
//	private $_TABLE	= 'vhost_product';
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(		
			"id" => 'id',
			"name" => 'name',
			"web_quota"=> 'web_quota',
			"db_quota"=>'db_quota',
			"templete"=>'templete',
			'price'=>'price',
			'pause_flag'=>'pause_flag',
			'node'=>'node',
			'try_flag'=>'try_flag',
			'month_flag'=>'month_flag'
		);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_INT|FIELD_TYPE_AUTO,
			'web_quota'=>FIELD_TYPE_INT,
			'db_quota'=>FIELD_TYPE_INT,
			'price'=>FIELD_TYPE_INT,
			'pause_flag'=>FIELD_TYPE_INT,
			'try_flag'=>FIELD_TYPE_INT,
			'month_flag'=>FIELD_TYPE_INT,
		);
		$this->_TABLE = DBPRE .'vhost_product';
	}
	public function delProduct($id)
	{
		return $this->delData($this->getFieldValue2('id',intval($id)));
	}
	public function getProduct($id,$fields=null)
	{
		$where = $this->getFieldValue2('id',$id);
		return $this->getData2($fields,$where,'row');
	}
	public function updateNode($id,$node)
	{
		return $this->update(array('node'=>$node),$this->getFieldValue2('id', $id));
	}
	public function updateProduct($arr)
	{
		$fields = $this->getFields(array('name','web_quota','db_quota','templete','price','pause_flag','node'), $arr);
		$sql = "UPDATE ".$this->_TABLE." SET ".$fields." WHERE ".$this->getFieldValue2('id',$arr['id']);
		return $this->executex($sql);
	}
	public function getSellProducts()
	{
		$where = $this->MAP_ARR['pause_flag'].'=0';
		return $this->getData2(array('id','name'),$where);
	}
	public function getProducts($flag)
	{
		
		switch($flag){
			case 1:
				$where = $this->MAP_ARR['pause_flag']."!=0";
				break;
			case 2:
				$where = $this->MAP_ARR['pause_flag']."=0";
				break;
		}
		//die("where=".$where);
		return $this->getData($where);
	}
}
?>
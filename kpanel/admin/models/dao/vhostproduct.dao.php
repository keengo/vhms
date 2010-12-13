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
			"templete"=>'templete'
		);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_INT|FIELD_TYPE_AUTO,
			'web_quota'=>FIELD_TYPE_INT,
			'db_quota'=>FIELD_TYPE_INT
		);
		$this->_TABLE = DBPRE .'vhost_product';
	}
	public function delProduct($id)
	{
		return $this->delData("id=".intval($id));
	}
	public function getProduct($id)
	{
		$where = $this->getFieldValue2('id',$id);
		return $this->getData($where,'row');
	}
	public function update($arr)
	{
		$fields = $this->getFields(array('name','web_quota','db_quota','templete'), $arr);
		$sql = "UPDATE ".$this->_TABLE." SET ".$fields." WHERE ".$this->getFieldValue2('id',$arr['id']);
		return $this->executex($sql);
	}
}
?>
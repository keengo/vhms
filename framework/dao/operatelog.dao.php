<?php 
class OperatelogDAO extends DAO
{
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(	
			"id" 			=> 'id',
			"admin" 		=> 'admin',
			"operate"		=> 'operate',
			"operate_object"=> 'operate_object',
			'operate_time'	=> 'operate_time',
			'mem'			=> 'mem',
			'mem2'			=> 'mem2'
		);
		$this->MAP_TYPE = array(
			'id'			=>FIELD_TYPE_INT|FIELD_TYPE_AUTO,
			'operate_time'	=>FIELD_TYPE_DATETIME
		);
		$this->_TABLE = DBPRE . 'operate_log';
	}
	public function operatelogAdd($arr)
	{
		$arr['operate_time'] = 'NOW()';
		return $this->insert($arr);
	}
	public function operatelogUpdate($id,$arr)
	{
		return $this->update($arr, $this->getFieldValue2('id', $id));
	}
	
}

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
	/**
	 * 
	 * Enter description here ...
	 * @param  $page
	 * @param  $page_count
	 * @param  $count
	 * @param  $select_where array
	 */
	public function operatelogPageList($page,$page_count,&$count,$order,$select_where=null)
	{
		$where = '';
		if ($select_where != null) {
			if ($select_where['id']) {
				$where = $this->getFieldValue2('id', $select_where['id']);
			}
			if ($select_where['admin']) {
				$where = $this->getFieldValue2('admin', $select_where['admin']);
			}
		}
		if (!$order) {
			$order = 'id';
		}
		return $this->selectPage(null, $where, $order, false, $page, $page_count, $count);
		
		
		
	}
}

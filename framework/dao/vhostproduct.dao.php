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
			'month_flag'=>'month_flag',
			'subdir_flag'=>'subdir_flag',
			'subdir'=>'subdir',
			'describe'=>'describe',
			'domain'=>'domain',
			'subtemplete'=>'subtemplete',
			'upid'=>'upid',
			'htaccess'=>'htaccess',
			'max_connect'=>'max_connect',
			'ftp'=>'ftp',
			'log_file'=>'log_file',
			'access'=>'access',
			'speed_limit'=>'speed_limit',
			'view'=>'view'
		);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_INT|FIELD_TYPE_AUTO,
			'web_quota'=>FIELD_TYPE_INT,
			'db_quota'=>FIELD_TYPE_INT,
			'price'=>FIELD_TYPE_INT,
			'pause_flag'=>FIELD_TYPE_INT,
			'try_flag'=>FIELD_TYPE_INT,
			'month_flag'=>FIELD_TYPE_INT,
			'subdir_flag'=>FIELD_TYPE_INT,
			'domain'=>FIELD_TYPE_INT,
			'upid'=>FIELD_TYPE_INT,
			'ftp'=>FIELD_TYPE_INT,
			'max_connect'=>FIELD_TYPE_INT,
			'speed_limit'=>FIELD_TYPE_INT,
			'access'=>FIELD_TYPE_INT,
			'log_file'=>FIELD_TYPE_INT,
			'htaccess'=>FIELD_TYPE_INT,
			'view'=>FIELD_TYPE_INT
		);
		$this->_TABLE = DBPRE .'vhost_product';
	}
	public function updateProductView($id,$view)
	{
		return $this->update(array('view'=>$view),$this->getFieldValue2('id', $id));
	}
	public function delProduct($id)
	{
		return $this->delData($this->getFieldValue2('id',intval($id)));
	}
	public function getProductList($flag=0,$view=0)
	{
		return $this->select(null,$this->getFieldValue2('pause_flag', $flag)." and ".$this->getFieldValue2('view', $view));
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
		$fields = $this->getFields(
		array(
			'name',
			'web_quota',
			'db_quota',
			'templete',
			'price',
			'pause_flag',
			'month_flag',
			'node',
			'subdir_flag',
			'subdir',
			'describe',
			'domain',
			'subtemplete',
			'upid',
			'ftp',
			'max_connect',
			'access',
			'htaccess',
			'log_file',
			'speed_limit'
		), $arr);
		$sql = "UPDATE ".$this->_TABLE." SET ".$fields." WHERE ".$this->getFieldValue2('id',$arr['id']);
		return $this->executex($sql);
	}
	public function getSellProducts()
	{
		$where = $this->MAP_ARR['pause_flag'].'=0';
		return $this->getData2(array('id','name'),$where);
	}
	public function selectPageList($page,$page_count,&$count,$flag=null,$view=null)
	{
		if($flag != null)
		{
			$where = $this->MAP_ARR['pause_flag']."=".$flag;
		}else{
			$where=$this->MAP_ARR['pause_flag']."=0";
		}
		if($view != null)
		{
			$where.= " and ".$this->MAP_ARR['view']."=".$view;
		}else{
			$where.= " and ".$this->MAP_ARR['view']."=0";
		}
		return $this->selectPage(array('id','name','web_quota','db_quota',
										'templete','price','pause_flag',
										'month_flag','node','describe',
										'subtemplete','ftp','max_connect',
										'access','htaccess','log_file',
										'speed_limit','domain','subdir',
										'subdir_flag','upid','try_flag'),
										 $where, 'id',false, $page, $page_count, $count);
		
	}
	public function getProducts($flag,$view=0)
	{
		
		switch($flag){
			case 1:
				$where = $this->MAP_ARR['pause_flag']."!=0";
				break;
			case 2:
				if($view != 0){
					$where = $this->MAP_ARR['pause_flag']."=0 and ".$this->MAP_ARR['view']."=".$view;
				}else{
					$where = $this->MAP_ARR['pause_flag']."=0 and ".$this->MAP_ARR['view']."=0";
				}
				break;
		}
		//die("where=".$where);
		return $this->getData($where);
	}
}
?>
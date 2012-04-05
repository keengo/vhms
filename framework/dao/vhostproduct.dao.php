<?php
class VhostproductDAO extends DAO {
//	private $_TABLE	= 'vhost_product';
	public function __construct()
	{	
		//show_price前台金额显示方式，0为默认按年显示
		//view更改为前台显示顺序
		//speed_limit带宽限制
		//cdn是否为cdn，或虚拟主机
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
			'speed_limit'=>'speed_limit',/*带宽限制*/
			'view'=>'view',/*前台显示*/
			'cs'=>'cs',/*多引擎切换,0不切换，1随时切换，2购买切换*/
			'cdn'=>'cdn',/*是否为CDN，1为CDN，0为虚拟主机*/
			'envs'=>'envs',/*管理变量*/
			'show_price'=>'show_price',/*前台按月显示价格*/
			'flow'=>'flow',/*流量*/
			'db_type'=>'db_type',/*数据库类型*/
			'max_subdir'=>'max_subdir',/*最大子目录个数*/
			'max_worker'=>'max_worker',/*商业，最多工作者*/
			'max_queue'=>'max_queue',/*商业，最多队列*/
			'log_handle'=>'log_handle'/*日志分析*/
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
			'view'=>FIELD_TYPE_INT,
			'cdn'=>FIELD_TYPE_INT,
			'cs'=>FIELD_TYPE_INT,
			'show_price'=>FIELD_TYPE_INT,
			'flow'=>FIELD_TYPE_INT,
			'max_subdir'=>FIELD_TYPE_INT,
			'max_worker'=>FIELD_TYPE_INT,
			'max_queue'=>FIELD_TYPE_INT,
			'log_handle'=>FIELD_TYPE_INT
		);
		$this->_TABLE = DBPRE .'vhost_product';
	}
	public function addProduct($arr)
	{
		$result = $this->insert($arr);
		if($result){
			try{
				$id = $this->db->lastInsertId();
			}catch(PDOException $e){
				//todo alter use select to select id;
			}
			return $id;
		}
		return false;
	}
	public function updateProductView($id,$view)
	{
		return $this->update(array('view'=>$view),$this->getFieldValue2('id', $id));
	}
	public function delProduct($id)
	{
		return $this->delData($this->getFieldValue2('id',intval($id)));
	}
	public function getProductList($flag=0,$view=1)
	{
		return $this->getProducts(2,1);
		//return $this->select(null,$this->getFieldValue2('pause_flag', $flag)." and ".$this->getFieldValue2('view', $view));
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
			'speed_limit',
			'envs',
			'cs',
			'cdn',
			'view',
			'show_price',
			'db_type',
			'max_subdir',
			'max_worker',
			'max_queue',
			'log_handle'
		), $arr);
		$sql = "UPDATE ".$this->_TABLE." SET ".$fields." WHERE ".$this->getFieldValue2('id',$arr['id']);
		return $this->executex($sql);
	}
	public function getSellProducts()
	{
		$where = $this->MAP_ARR['pause_flag'].'=0 order by `view`';
		return $this->getData2(array('id','name'),$where);
	}

	public function pageListProduct($page,$page_count,&$count,$flag=null,$view=null)
	{
		if($flag != null)
		{
			$where = $this->MAP_ARR['pause_flag']."=".$flag;
		}else{
			$where = $this->MAP_ARR['pause_flag']."=0";
		}
		if($view != null)
		{
			$where.= " and ".$this->MAP_ARR['view']."=".$view;
		}else{
			$where.= " and ".$this->MAP_ARR['view'].">0";
		}
		$field = $this->MAP_ARR;
		
		return $this->selectPage($field,$where, 'view',false, $page, $page_count, $count);
//		return $this->selectPage(array('id','name','web_quota','db_quota',
//										'templete','price','pause_flag',
//										'month_flag','node','describe',
//										'subtemplete','ftp','max_connect',
//										'access','htaccess','log_file',
//										'speed_limit','domain','subdir',
//										'subdir_flag','upid','try_flag',
//										'describe','show_price','db_type','log_handle','max_subdir','max_worker','max_queue'),
//										 $where, 'view',false, $page, $page_count, $count);
//		
	}
	//代理设置新增时所用。
	public function selectProduct()
	{
		return $this->select(array('id','name'));
	}
	public function getProducts($flag=0,$view=0)
	{
		switch($flag){
			case 0:
				$where = "1=1 order by `view`";
				break;
			case 1:
				$where = $this->MAP_ARR['pause_flag']."!=0 order by `view`";
				break;
			case 2:
				if($view != 0){
					$where = $this->MAP_ARR['pause_flag']."=0 and ".$this->MAP_ARR['view'].">0 order by `view`";
				}else{
					$where = $this->MAP_ARR['pause_flag']."=0 and ".$this->MAP_ARR['view']."=0 order by `view`";
				}
				break;
		}
		//die("where=".$where);
		return $this->getData($where);
	}
}
?>
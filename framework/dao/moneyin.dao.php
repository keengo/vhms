<?php
class MoneyinDAO extends DAO{
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"id"=>'id',
			"username" => 'username',
			"money" => 'money',
			"start_time" => 'start_time',
			"end_time" => 'end_time',
			"gw" => 'gw',
			"status"=>'status',
			"gwid"=>'gwid'
		);
		$this->MAP_TYPE = array(
		'start_time'=>FIELD_TYPE_DATETIME,
		'end_time'=>FIELD_TYPE_DATETIME
		);
		$this->_TABLE = DBPRE . 'money_in';
	}
	public function updateStatus($id){
		$arr['status']=1;
		return $this->update($arr,$this->getFieldValue2('id', $id));
	}
	public function add($username,$money,$gw)
	{
		$arr['username']=$username;
		$arr['money']=$money;
		$arr['gw']=$gw;
		$arr['start_time']='NOW()';
		$result=$this->insertData($arr);
		if($result){
			try{
				$id = $this->db->lastInsertId();				
			}catch(PDOException $e){
				//print_r($e);
				//todo alter use select to select id;
			}
			return $id;
		}
		return false;
	}
	public function pageMoneyin($page,$page_count,&$count)
	{
		return $this->selectPage(
							array('id','username','money','start_time','end_time','gw','gwid','status'),
							null,
							'start_time',
							true,
							$page,
							$page_count,
							$count
						);
	}
	
	public function pageByUser($username,$page,$page_count,&$count)
	{
		
		return $this->selectPage(
							array('id','username','money','start_time','end_time','gw','gwid','status'),
							$this->getFieldValue2('username', $username),
							'start_time',
							true,
							$page,
							$page_count,
							$count
						);
	}
	public function get($id)
	{
		return $this->select(null,$this->getFieldValue2('id',$id),'row');
	}
	public function del($id)
	{
		return $this->delete($this->getFieldValue2('id', $id));
	}
}

?>
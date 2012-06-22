<?php
class MoneyinDAO extends DAO{
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"id"			=> 'id',
			"username" 		=> 'username',
			"money" 		=> 'money',
			"start_time" 	=> 'start_time',
			"end_time" 		=> 'end_time',
			"gw" 			=> 'gw',
			"status"		=> 'status',
			"gwid"			=> 'gwid'
		);
		$this->MAP_TYPE = array(
			'id'			=>FIELD_TYPE_AUTO,
			'money'			=>FIELD_TYPE_INT,
			'gw'			=>FIELD_TYPE_INT,
			'status'		=>FIELD_TYPE_INT,
			'start_time'	=>FIELD_TYPE_DATETIME,
			'end_time'		=>FIELD_TYPE_DATETIME
		);
		$this->_TABLE = DBPRE . 'money_in';
	}
	public function updateStatus($id,$money){
		$arr['status']=1;
		$arr['end_time']='NOW()';
		$where = $this->getFieldValue2('id', $id)." AND ".$this->getFieldValue2('status', 0);
		if($money!=null){
			$where .=' AND '.$this->getFieldValue2('money', $money);
		}
		return $this->update($arr,$where);
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
							'id',
							true,
							$page,
							$page_count,
							$count
						);
	}
	
	public function pageByUser($username,$page,$page_count,&$count)
	{
		
		return $this->selectPage(
							array('username','money','start_time','end_time','gw','gwid','status'),
							$this->getFieldValue2('username', $username)." AND ".$this->getFieldValue2('status', 1),
							'id',
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
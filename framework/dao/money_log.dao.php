<?php
class Money_logDAO extends DAO{
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
		$this->_TABLE = DBPRE . 'money_log';
	}
	public function add($username,$money,$gw,$gwid,$status)
	{
		$arr['username']=$username;
		$arr['money']=$money;
		$arr['gw']=$gw;
		$arr['gwid']=$gwid;
		$arr['status']=$status;
		$arr['start_time']='NOW()';
		return $this->insertData($arr);
	}
	public function pageMoney_logByUsername($username,$page,$page_count,&$count)
	{
		
		return $this->selectPage(
							array('id','username','money','start_time','end_time','gw','gwid'),
							'username',
							'start_time',
							true,
							$page,
							$page_count,
							$count
						);
	}
	public function get($username)
	{
		return $this->select(null,$this->getFieldValue2('id',$id),'row');
	}
	public function del($id)
	{
		return $this->delete($this->getFieldValue2('id', $id));
	}
}

?>
<?php
class MoneyoutDAO extends DAO{
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(
			"id"=>'id',
			"username" => 'username',
			"money" => 'money',
			"add_time" => 'add_time',
			"mem" => 'mem',
		);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_AUTO,
			'money'=>FIELD_TYPE_INT,
			'add_time'=>FIELD_TYPE_DATETIME,
		);
		$this->_TABLE = DBPRE . 'money_out';
	}
	public function add($username,$money,$mem)
	{
		$arr['username'] = $username;
		$arr['money'] = $money;
		$arr['mem'] = $mem;
		$arr['add_time'] = 'NOW()';
		return $this->insert($arr);
		
	}
	public function pageMoneyout($page,$page_count,&$count)
	{
		return $this->selectPage(
							array('id','username','money','add_time','mem'),
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
							array('username','money','add_time','mem'),
							$this->getFieldValue2('username', $username),
							'id',
							true,
							$page,
							$page_count,
							$count
						);
	}
}
?>
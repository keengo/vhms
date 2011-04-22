<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class UserDAO extends DAO{
	

	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"username" => 'username',
			"passwd" => 'passwd',
			"email" => 'email',
			"regtime" => 'regtime',
			"name" => 'name',
			"money" => 'money',
			"id"=>'id'
		);
		$this->MAP_TYPE = array(
			'money'=>FIELD_TYPE_INT,
			'passwd'=>FIELD_TYPE_MD5,
			'regtime'=>FIELD_TYPE_DATETIME
		);
		$this->_TABLE = DBPRE . 'users';
	}
	
	public function pageUsers($page,$page_count,&$count)
	{
		return $this->selectPage(
					array('username','email','name','money','id','regtime'),
					null, 
					'regtime', 
					true, 
					$page,
					$page_count,
					$count
				);
	}
		
	/**
	 * 查询用户信息信息
	 */
	public function getUser($username)
	{
		return $this->getData($this->getFieldValue2('username',$username),'row');		
	}
	public function checkUser($username)
	{
		$sql = "SELECT 1 FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('username',$username);
		return $this->executex($sql,'row');
	}
	/**
	 * 插入用户信息信息
	 */
	public function newUser($username,$passwd,$email,$name,$id)
	{
		$arr['username'] = $username;
		$arr['passwd'] = $passwd;
		$arr['email']= $email;
		$arr['name'] = $name;
		$arr['id'] = $id;
		$arr['regtime'] = 'NOW()';
		return $this->insertData($arr);
	}
	public function updatePassword($username,$passwd)
	{
		//$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('passwd',$passwd)." WHERE ".$this->getFieldValue2('username', $username);
		$arr['passwd'] = $passwd;
		return $this->update($arr,$this->getFieldValue2('username', $username));
	}
	/**
	 * 更新用户信息
	 */
	public function updateUser($username,$name,$email,$id)
	{
		$arr['email']= $email;
		$arr['name'] = $name;
		$arr['id'] = $id;
		return $this->update($arr,$this->getFieldValue2('username', $username));
	}
	public function addMoney($username,$money)
	{
		$where = $this->getFieldValue2('username', $username);
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->MAP_ARR['money']."=".$this->MAP_ARR['money']."+".intval($money)." WHERE ".$where;
		return $this->executex($sql);
	}
	public function decMoney($username,$money)
	{
		$where = $this->getFieldValue2('username', $username).' AND '.$this->MAP_ARR['money'].'>='.$money;
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->MAP_ARR['money']."=".$this->MAP_ARR['money']."-".intval($money)." WHERE ".$where;
		return $this->executex($sql);
	}
	/**
	 * 删除用户信息
	 */
	public function delUser($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "DELETE FROM {$tbl} WHERE `username` = '{$username}' LIMIT 1";
		$ret = $this->execute($host, $dbname, $sql);
		if($ret || is_array($ret) && count($ret) == 1) {
			return true;
		}else {
			return false;
		}
	}
	/**
	 * 删除用户信息
	 */
	public function listUser($username)
	{
		$tbl = $this->_TABLE;
		if(!$tbl) {
			return false;
		}
		$sql = "SELECT * FROM {$tbl}";
		if($username!=""){
			$sql.=" WHERE ".$this->getFieldValue2('username', $username);
		}
		return $this->executex($sql,'rows');
	}

}
?>
<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class UserDAO extends DAO{


	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"uid"=>'uid',
			"username" => 'username',
			"passwd" => 'passwd',
			"email" => 'email',
			"regtime" => 'regtime',
			"name" => 'name',
			"money" => 'money',
			"id"=>'id',
			'agent_id'=>'agent_id',
			'flow'=>'flow'
			);
			$this->MAP_TYPE = array(
				'uid'=>FIELD_TYPE_INT,
				'money'=>FIELD_TYPE_INT,
				'agent_id'=>FIELD_TYPE_INT,
				'flow'=>FIELD_TYPE_INT,
				'passwd'=>FIELD_TYPE_MD5,
				'regtime'=>FIELD_TYPE_DATETIME
			);

			$this->_TABLE = DBPRE . 'users';
	}
	/*用于邮件群发时，获取所有邮件distinct防重复*/
	public function getAllMail($where)
	{
		$sql = 'select distinct email as email from '.$this->_TABLE;
		if ($where) {
			$sql .= ' where '.$where;
		}
		return $this->executex($sql,'rows');
		
	}
	//用于当前代理ID被删除时，用户的代理身份也要更新
	public function updateUserAgent_idByAent_id($agent_id)
	{
		$arr['agent_id'] = 0;
		return $this->update($arr,$this->getFieldValue2('agent_id', $agent_id));
	}
	public function updateUserUid($username,$uid){
		$arr['uid']=$uid;
		return $this->update($arr, $this->getFieldValue2('username', $username));
	}
	public function delUserById($id){
		return $this->delData($this->getFieldValue2('id',$id),'row');
	}
	public function pageUsers($page,$page_count,&$count)
	{
		return $this->selectPage(
		array('username','email','name','money','id','regtime','agent_id'),null,'regtime',true,$page,$page_count,$count);
	}

	/**
	 * 查询用户信息信息
	 */
	public function getUserById($uid){
		return $this->getData($this->getFieldValue2('uid',$uid),'row');
	}
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
	public function newUser($username,$passwd,$email,$name,$id,$uid=0)
	{
		$arr['username'] = $username;
		$arr['passwd'] = $passwd;
		$arr['email']= $email;
		$arr['name'] = $name;
		$arr['id'] = $id;
		$arr['uid']=$uid;
		$arr['regtime'] = 'NOW()';
		return $this->insert($arr);
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
	
	/**
	 * 更改user信息 最新函数，其他弃用
	 * Enter description here ...
	 * @param unknown_type $username
	 * @param unknown_type $arr
	 */
	public function changUser($username,$arr)
	{
		return $this->update($arr, $this->getFieldValue2('username', $username));
	}
	public function updateMoney($username,$money)
	{
		$arr['money']=$money;
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
<?php
/**
 * 用户信息信息DAO层基本函数生成
 */
class VhostDAO extends DAO{
	private $vh_col_map = array('name','doc_root','user','group','templete','status');
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"name" => 'name',
			'passwd'=>'passwd',
			'doc_root'=>'doc_root',
			'uid'=>'uid',
		 	'templete'=>'templete',
			'subtemplete'=>'subtemplete',
			'create_time'=>'create_time',
			'expire_time'=>'expire_time',
			'status'=>'status',
			'node'=>'node',
			'product_id'=>'product_id',
			'username'=>'username',
			'flow'=>'flow'
			);
			$this->MAP_TYPE = array(
			'passwd'=>FIELD_TYPE_MD5,
			'uid'=>FIELD_TYPE_INT,
			'status'=>FIELD_TYPE_INT,
			'product_id'=>FIELD_TYPE_INT,
			'create_time'=>FIELD_TYPE_DATETIME,
			'expire_time'=>FIELD_TYPE_DATETIME
			);
			$this->_TABLE = DBPRE . 'vhost';
	}
	public function addFlow($name,$flow)
	{
		$sql = "UPDATE ".$this->_TABLE." SET flow = flow + '".addslashes($flow)."' WHERE ".$this->getFieldValue2('name',$name);
		return $this->executex($sql,'result');
	}
	//执行空间删除shell所用
	public function selectListByExpire_time($day,$status=0)
	{
		if($day==""){
			$day=1;
		}
		$where=' expire_time < subdate(curdate(),interval '.$day.' day)';
		if ($status>=0) {
			$where .= " and ".$this->getFieldValue2('status', $status);
		}
		return $this->select(array('name','username','node','product_id'),$where);
	}


	//管理后台显示过期网站
	public function pageVhostByExpire_time($page,$page_count,&$count,$day,$status)
	{
		$where="";
		if($day==""){
			$day=1;
		}
		$where.=' expire_time < subdate(curdate(),interval '.$day.' day)';

		if($status >= 0){
			$where .= " and ".$this->getFieldValue2('status', $status);
		}
		return $this->selectPage(array('name','create_time','expire_time','username','status'),
		$where,
										'expire_time', 
		false,
		$page,
		$page_count,
		$count
		);
	}

	public function pageVhostByuser($username,$name,$page,$page_count,&$count)
	{
		$where = $this->getFieldValue2('username',$username);
		if($name!=""){
			$where.=" AND ".$this->getFieldValue2('name', $name);
		}
		return $this->selectPage(
		array('name','uid','templete','node','create_time','expire_time','status','product_id','username'),
		$where,
					'uid', 
		true,
		$page,
		$page_count,
		$count
		);
	}
	public function pageVhost($page,$page_count,&$count)
	{
		return $this->selectPage(
		array('name','uid','username','templete','node','doc_root','create_time','expire_time','product_id','status'),
		null,
		'uid', 
		true,
		$page,
		$page_count,
		$count
		);
	}

	public function updateMinUid(&$uid)
	{
		$min_uid = 2000;
		$arr = array('uid'=>$min_uid+$uid);
		$result = $this->update($arr,$this->getFieldValue2('uid', $uid));
		if($result){
			$uid += $min_uid;
		}
		return $result;
	}
	public function check($user)
	{
		$sql = "SELECT 1 FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('name', $user);
		return $this->executex($sql,'row');
	}
	public function addMonth($name,$month)
	{
		$arr = array('expire_time' => 'ADDDATE('.$this->MAP_ARR['expire_time'].',INTERVAL '.$month.' MONTH)');
		return $this->update($arr, $this->getFieldValue2('name', $name));
	}
	public function changeProduct($name,$product_id,$templete)
	{
		$arr = array('product_id'=>$product_id,'templete'=>$templete);
		return $this->update($arr,$this->getFieldValue2('name', $name));
	}
	/**
	 * 插入用户信息信息
	 */
	public function insertVhost($username,$name,$passwd,$doc_root,$group,$templete,$subtemplete,$status,$node,$product_id,$month)
	{
		$arr=array();
		$arr['username']=$username;
		$arr['name'] = $name;
		$arr['passwd'] = $passwd;
		$arr['doc_root'] = $doc_root;
		$arr['gid'] = $group;
		$arr['templete'] = $templete;
		$arr['subtemplete'] = $subtemplete;
		$arr['status'] = $status;
		$arr['node'] = $node;
		$arr['product_id'] = $product_id;
		$arr['create_time'] = 'NOW()';
		$arr['expire_time'] = 'ADDDATE(NOW(),INTERVAL '.$month.' MONTH)';
		$result = $this->insertData($arr);

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
	public function updatePassword($username,$passwd)
	{
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('passwd',$passwd)." WHERE ".$this->getFieldValue2('name', $username);
		return $this->executex($sql);
	}
	/**
	 * 更新用户信息
	 */
	public function updateVhost($vhostName, $arr)
	{
		return $this->update($arr,$this->getFieldValue2('name', $vhostName));
	}

	/**
	 * 删除用户信息
	 */
	public function delVhost($vhostName,$username)
	{
		$where = $this->getFieldValue2('name', $vhostName);
		if($username){
			$where.=' AND '.$this->getFieldValue2('username', $username);
		}
		return $this->delData($where);
	}
	public function listVhostByNode($node)
	{
		return $this->getData($this->getFieldValue2('node', $node));
	}
	public function listVhostByUid($uid,$result='rows')
	{
		$where = $this->getFieldValue2('uid', $uid);
		return $this->getData($where,$result);
	}
	public function listVhostByName($name,$result='rows')
	{
		$where = $this->getFieldValue2('name', $name);
		return $this->getData($where,$result);
	}
	public function listVhost($username,$result='rows')
	{
		$where = "";
		if($username){
			$where = $this->getFieldValue2('username', $username);
		}
		return $this->getData2(array('name','uid','create_time','expire_time','status','node','product_id'),$where,$result);
	}
	public function listMyVhost($username,$result='rows')
	{
		if($username=="" || $username==null){
			return false;
		}
		return $this->listVhost($username,$result);
	}
	public function getMyVhost($username,$name,$fields=null)
	{
		return $this->getData2(
		$fields,
		$this->getFieldValue2('username', $username)." AND ".$this->getFieldValue2('name', $name),
				'row');
	}
	public function getVhost($name,$fields=null)
	{
		return $this->getData2($fields,$this->getFieldValue2('name', $name),'row');
	}
	public function getNode($name){
		$sql = "SELECT ".$this->MAP_ARR['node']." FROM ".$this->_TABLE." WHERE ".$this->getFieldValue2('name', $name);
		$row = $this->executex($sql,'row');
		return $row['node'];
	}
	public function expireUser()
	{
		$sql = "UPDATE ".$this->_TABLE." SET ".$this->getFieldValue2('status', 9)." WHERE ".$this->MAP_ARR['expire_time']."<NOW()";
		return $this->executex($sql,'result');
	}
}
?>
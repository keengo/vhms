<?php
class QuestionDAO extends DAO{
	public function __construct()
	{	//加载基本db文件
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"id"=>'id',
			"username" => 'username',
			"title" => 'title',
			"body"=>'body',
			"add_time" => 'add_time',
			"status"=>'status',
			"reply"=>'reply',
			"reply_time"=>'reply_time',
			"admin"=>'admin',		
		);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_AUTO,
			'status'=>FIELD_TYPE_INT,
			'add_time'=>FIELD_TYPE_DATETIME,
			'reply_time'=>FIELD_TYPE_DATETIME			
		);
		$this->_TABLE = DBPRE . 'question';
	}
	public function updateReply($id,$reply,$admin)
	{
		$arr['reply']=$reply;
		$arr['admin']=$admin;
		$arr['reply_time']='NOW()';
		$arr['status']=1;
		return $this->update($arr,$this->getFieldValue2('id', $id));
	}
	public function add($username,$title,$body)
	{
		$arr['username']=$username;
		$arr['title']=$title;
		$arr['body']=$body;
		$arr['add_time']='NOW()';
		return $this->insertData($arr);
	}

	public function pageQuestion($page,$page_count,&$count)
	{		
		
		return $this->selectPage(
							array('id','username','title','add_time','body','status'),
							null,
							'id',
							true,
							$page,
							$page_count,
							$count
						);
	}
	public function pageByuser($username,$page,$page_count,&$count)
	{		
		return $this->selectPage(
							array('id','username','title','add_time','body','status'),
							$this->getFieldValue2('username', $username),
							'id',
							true,
							$page,
							$page_count,
							$count
						);
	}
	public function del($id)
	{
		return $this->delete($this->getFieldValue2('id', $id));
	}
	public function get($id)
	{
		return $this->select(null,$this->getFieldValue2('id',$id),'row');
	}
}

<?php
class NewsDAO extends DAO{
	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(
			"id"		=> 'id',
			"title" 	=> 'title',
			"body" 		=> 'body',
			"add_time" 	=> 'add_time'			
		);
		$this->MAP_TYPE = array(
			'id'		=>FIELD_TYPE_AUTO,
			'add_time'	=>FIELD_TYPE_DATETIME
		);
		$this->_TABLE = DBPRE . 'news';
	}
	public function addNews($title,$body)
	{
		$arr['title']	= $title;
		$arr['body']	= $body;
		$arr['add_time']= 'NOW()';
		return $this->insert($arr);
	}
	public function getNews($id)
	{
		return $this->select(null,$this->getFieldValue2('id', $id),'row');
	}
	public function updateNews($id,$title,$body)
	{
		$arr['title']=$title;
		$arr['body']=$body;
		return $this->update($arr,$this->getFieldValue2('id', $id));
	}
	public function delNews($id)
	{
		return $this->delData($this->getFieldValue2('id', $id));
	}
	public function getNewsList()
	{
		return $this->select(null);
	}
	public function pageNewsByNumber($number,$page,$page_count,&$count)
	{		
		$where=null;
		if($number!=""){
			$where .= 'order by id desc limit'.$number;
		}
		return $this->selectPage(
							array('id','title','body','add_time'),
							null,
							'id',
							true,
							$page,
							$page_count,
							$count
						);
	}
	public function pageNews($page,$page_count,&$count)
	{		
			return $this->selectPage(
							array('id','title','body','add_time'),
							null,
							'id',
							true,
							$page,
							$page_count,
							$count
						);
	}
	
	
	
}
?>
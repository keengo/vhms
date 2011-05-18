<?php
needRole('admin');
class NewsControl extends Control {
	
	public function addFrom()
	{
		return $this->display('news/add.html');
	}
	public function addNews()
	{
		$new=daocall('news','addNews',array($_REQUEST['title'],$_REQUEST['body']));
		return $this->pageNews();
		
	}
	
	public function pageNews()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 30;
		$count = 0;
		$list = daocall('news','pageNew',array($page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('news/pagelist.html');	
		
	}
	public function delNews()
	{
		daocall('news','delNews',array($_REQUEST['id']));
		return $this->pageNews();
	}
	public function getNews()
	{
		$new=daocall('news','getNews',array($_REQUEST['id']));
		$this->assign('new',$new);
		return $this->fetch('news/list.html');	
	}
	public function updateNews()
	{
		$new=daocall('news','updateNews',array($_REQUEST['id'],$_REQUEST['title'],$_REQUEST['body']));
		return $this->pageNews();
	}
}
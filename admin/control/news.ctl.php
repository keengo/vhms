<?php
needRole('admin');
class NewsControl extends Control {
	
	public function addFrom()
	{
		return $this->display('news/add.html');
	}
	public function add()
	{
		$new=daocall('news','add',array($_REQUEST['title'],$_REQUEST['body']));
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
		$list = daocall('news','pageNews',array($page,$page_count,&$count));
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
	public function del()
	{
		daocall('news','del',array($_REQUEST['id']));
		return $this->pageNews();
	}
	public function get()
	{
		$new=daocall('news','get',array($_REQUEST['id']));
		$this->assign('new',$new);
		return $this->fetch('news/list.html');	
	}
	public function updateNews()
	{
		$new=daocall('news','updateNews',array($_REQUEST['id'],$_REQUEST['title'],$_REQUEST['body']));
		return $this->pageNews();
	}
}
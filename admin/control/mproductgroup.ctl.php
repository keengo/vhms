<?php
needRole('admin');
class MproductgroupControl extends Control
{
	public function addMproductgroupFrom()
	{
		if($_REQUEST['id']) {
			$mproductgroup = daocall('mproductgroup','getMproductgroup',array(intval($_REQUEST['id'])));
			$this->_tpl->assign('edit',1);
			$this->_tpl->assign('mproductgroup',$mproductgroup);
		}
		return $this->_tpl->display('mproductgroup/addfrom.html');
	}
	public function addMproductgroup()
	{
		$result = daocall('mproductgroup','add',array($_REQUEST));
		if (!$result) {
			$this->_tpl->assign('msg','增加失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproductgroup();
	}
	public function delMproductgroup()
	{
		$result = daocall('mproductgroup','del',array(intval($_REQUEST['id'])));
		if (!$result) {
			$this->_tpl->assign('msg','删除失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproductgroup();
	}
	public function pageListMproductgroup()
	{
		
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$order = $_REQUEST['order'] or 'id';//排序字段
		$list = daocall('mproductgroup','pageList',array($page,$page_count,&$count,$order));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('order',$order);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('mproductgroup/pagelistmproductgroup.html');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
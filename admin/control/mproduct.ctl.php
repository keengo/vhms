<?php
needRole('admin');
class MproductControl extends Control
{
	public function addMproductFrom()
	{
		$this->_tpl->assign('action','addMproduct');
		return $this->_tpl->display('mproduct/addfrom.html');
	}
	public function addMproduct()
	{
		$result = daocall('mproduct','add',array($_REQUEST));
		if (!$result) {
			$this->_tpl->assign('msg','增加失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproduct();
	}
	public function delMproduct()
	{
		$id = intval($_REQUEST['id']);
		$result = daocall('mproduct','del',array($id));
		if (!$result) {
			$this->_tpl->assign('msg','增加失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproduct();
	}
	public function pageListMproduct()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$list = daocall('mproduct','pageList',array($page,$page_count,&$count));
		print_r($list);
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('mproduct/pagelistmproduct.html');
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
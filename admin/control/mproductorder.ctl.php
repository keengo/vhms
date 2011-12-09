<?php 
needRole('admin');
class MproductorderControl extends Control
{
	public function addMproductorderFrom()
	{
		if($_REQUEST['id']) {
			
			$mproductorder = daocall('mproductorder','getMproductorder',array(intval($_REQUEST['id'])));
			$this->_tpl->assign('mproductorder',$mproductorder);
			$this->_tpl->assign('edit',1);
		}
		return $this->_tpl->fetch('mproductorder/addfrom.html');
	}
	public function addMproductorder()
	{
		$result = daocall('mproductorder','add',array($_REQUEST));
		if(!$result) {
			$this->_tpl->assign('msg','增加失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproductorder();
	}
	public function delMproductorder()
	{
		$result = daocall('mproductorder','del',array(intval($_REQUEST['id'])));
		if(!$result) {
			$this->_tpl->assign('msg','删除失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproductorder();
	}
	public function pageListMproductorder()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$order = $_REQUEST['order'] or 'id';//排序字段
		$list = daocall('mproductorder','pageList',array($page,$page_count,&$count,$order));
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
		return $this->_tpl->fetch('mproductorder/pagelistmproductorder.html');
		
		
	}
	
	
	
	
}



?>
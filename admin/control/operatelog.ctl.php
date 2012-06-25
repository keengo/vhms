<?php 
needRole('admin');
class OperatelogControl extends control
{
	public function operatelogPageList()
	{
		$page = intval($_REQUEST['page']);
		if($page <= 0){
			$page = 1;
		}
		$page_count = 20;
		$count 		= 0;
		$order = $_REQUEST['order'] ? $_REQUEST['order'] : 'id';
		if ($_REQUEST['id']) {
			$select_where['id'] = $_REQUEST['id'];
		}else if ($_REQUEST['admin']) {
			$select_where['admin'] = $_REQUEST['admin'];
		}else{
			$select_where = null;
		}
		$list 		= daocall('operatelog','operatelogPageList',array($page,$page_count,&$count,$order,$select_where));
		$total_page = ceil($count/$page_count);
		if ($page >= $total_pag) {
			$page = $total_page;
		}
		$this->_tpl->assign('order',$order);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->display('operatelog/pagelist.html');
	}
}

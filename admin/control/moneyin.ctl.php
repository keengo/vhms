<?php
needRole('admin');
class MoneyinControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function pageMoneyinByStatus()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 12;
		$count = 0;
		$list = daocall('moneyin','pageMoneyinByStatus',array(1,$page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('moneyin/pagelist.html');
		
	
	}
	
}
?>
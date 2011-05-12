<?php
class Money_logControl extends Control {
	
	
	public function pageMoney_logByUsername()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 12;
		$count = 0;
		$list = daocall('webapp','pageApp',array($appname,$file_exts,$page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('money_log/pagelist.html');
	}
	
	public function add()
	{
		$log=daocall('money_log','add',array($_REQUEST['username'],$_REQUEST['money'],$_REQUEST['gw'],$_REQUEST['gwid'],1));
	}
}
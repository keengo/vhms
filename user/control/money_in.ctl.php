<?php
class Money_inControl extends Control {
	
	
	public function pageMoney_inByUsername()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 12;
		$count = 0;
		$list = daocall('money_in','pageMoney_inByUsername',array($username,$page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('money_in/pagelist.html');
	}
	public function addFrom()
	{
		$this->_tpl->display('money_in/rechargeFrom.html');
	}
	public function add()
	{
		$add=daocall('moneyin','add',array(getRole('user'),$_REQUEST['money'],$_REQUEST['gw'],1));
	}
}
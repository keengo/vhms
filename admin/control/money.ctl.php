<?php
needRole('admin');
class MoneyControl extends Control {
	
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function pageMoneyout()
	{	
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$list = daocall('moneyout','pageMoneyout',array($page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('money/pagemoneyout.html');
		
	}
	public function pageMoneyin()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$list = daocall('moneyin','pageMoneyin',array($page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('money/pagemoneyin.html');
	}
	/**
	 * 用户充值成功，但没有到账，管理员手动给用户确认到账
	 * Enter description here ...
	 */
	public function manPayReturn()
	{
		if(apicall('money','payReturn',array($_REQUEST['id']))){
			$this->_tpl->assign('msg','充值成功');
			$log = array('operate_object'=>'id='.$_REQUEST['id'],'admin'=>getRole('admin'),'operate'=>$_REQUEST['a']);
			apicall('operatelog','operatelogAdd',array($log));
		} else {
			$this->_tpl->assign('msg','充值失败');
		}
		return $this->display('msg.html');
	}
	
}
?>
<?php
needRole('user');
class MoneyControl extends Control {	
	public function moneyin()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$list = daocall('moneyin','pageByUser',array(getRole('user'),$page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('money/moneyin.html');
		
	}
	public function moneyout()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$list = daocall('moneyout','pageByUser',array(getRole('user'),$page,$page_count,&$count));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('money/moneyout.html');		
	}
	public function addFrom()
	{
		$this->_tpl->display('money/rechargeFrom.html');
	}
	public function add()
	{
		$money=$_REQUEST['money']*100;
		$add=daocall('moneyin','add',array(getRole('user'),$money,$_REQUEST['gw']));
		if($add){
			$user=daocall('moneyin','get',array(getRole('user')));//get $user['id']
			return $user;//传递数组给支付宝接口
		}
		
	}
	public function add_return($id)
	{
		if($id)
		{
			$add=apicall('money_in','add_return',array($id));
		}
	}
}
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
	public function add()
	{
		$money=intval($_REQUEST['money'])*100;
		if($money<=0){
			die("金额填写不正确.");
		}
		$gw = intval($_REQUEST['gw']);
		if($gw!=1 && $gw!=2){
			die("支付网关不正确");
		}
		$user = getRole('user');
		$id = daocall('moneyin','add',array($user,$money,$gw));
		if (!$id) {
			die("数据库操作出错.请联系管理员");
		}
		
		return apicall('paygw'.$gw,'pay',array($id,$user,$money));	
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
		$this->_tpl->display('money/add.html');
	}
	
}
<?php
needRole('user');
class MoneyControl extends Control {
	public function moneyin()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 15;
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
		return $this->_tpl->fetch('money/moneyin.html');

	}
	public function left()
	{
		if($GLOBALS['frame']==1){
			$this->_tpl->assign('target','main');
		}else{
			$this->_tpl->assign('target','_self');
		}
		return $this->_tpl->fetch('user/left.html');
	}
	public function add()
	{
		$money=intval($_REQUEST['money']*100);
		if($money<=0){
			die("金额填写不正确.");
		}
		$gw = intval($_REQUEST['gw']);
		if($gw!=1 && $gw!=2){
			die("支付网关不正确");
		}
		load_conf('pub:setting');
		if($gw==1 && !is_array($GLOBALS['setting_cfg']['ALIPAY_PARTNER'])){
			die("没有设置支付参数,请联系管理员");
		}
		$user = getRole('user');
		$id = daocall('moneyin','add',array($user,$money,$gw));
		if (!$id) {
			die("数据库操作出错.请联系管理员");
		}
		switch($gw){
			case 1:
				require_once(SYS_ROOT.'/../plugin/alipay/pay.php');
				break;
			case 2:
				require_once(SYS_ROOT.'/../plugin/chinabank/Send.php');
				break;
			default:
				die("暂时不支持该支付网关");
		}
	}
	public function moneyout()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 15;
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
		return $this->_tpl->fetch('money/moneyout.html');
	}
	public function addFrom()
	{
		return $this->_tpl->fetch('money/add.html');
	}

}
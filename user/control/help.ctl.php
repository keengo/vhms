<?php
//首页文件
class HelpControl extends Control
{
	public function left()
	{
		return $this->_tpl->fetch('help/left.html');
	}
	public function index()
	{
		//$id = intval($_REQUEST['id']);
		//$faqgroup = daocall('faqgroup','getfaqgroup',array($id));
		//$faq = daocall('faq','getFaqGroupid',array($id));
		//$this->_tpl->assign('faqgroup',$faqgroup);
		//$this->_tpl->assign('faq',$faq);
		return $this->_tpl->fetch('help/index.html');
	}
	
	
}
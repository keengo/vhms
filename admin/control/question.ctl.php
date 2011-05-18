<?php
needRole('admin');
class QuestionControl extends Control {
	
	public function pageQuestion()
	{
		
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 10;
		$count = 0;
		$list = daocall('question','pageQuestion',array($page,$page_count,&$count,$_REQUEST['sortname']));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		print_r($_REQUEST['sortname']);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('question/pagelist.html');	
	}
	
	public function get()
	{
		$log=daocall('question','get',array($_REQUEST['id']));
		$this->assign('log',$log);
		return $this->fetch('question/list.html');	
	}
	public function addReply()
	{
		$reply=apicall('utils','klencode',array($_REQUEST['reply']));
		$log=daocall('question','updateReply',array($_REQUEST['id'],$reply,getRole('admin')));
		return $this->pageQuestion();
	}
}
?>
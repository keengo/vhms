<?php
needRole('user');
class QuestionControl extends Control {

	public function addFrom()
	{
		return $this->fetch('question/add.html');
	}
	public function add()
	{
		$body = apicall('utils','klencode',array($_REQUEST['body']));
		$title = apicall('utils','klencode',array($_REQUEST['title']));
		$add=daocall('question','add',array(getRole('user'),$title,$body));
		if($add) {
			$this->assign('msg','提交成功');

		}else{
			$this->assign('msg','提交失败');
		}
		return $this->fetch('msg.html');
	}
	public function left()
	{
		if($GLOBALS['frame']==1){
			$this->_tpl->assign('target','main');
		}else{
			$this->_tpl->assign('target','_self');
		}
		return dispatch('user', 'left');
		//return $this->_tpl->fetch('user/left.html');
	}
	public function getQuestion()
	{
		$log=daocall('question','getQuestion',array($_REQUEST['id']));
		$this->assign('log',$log);
		return $this->fetch('question/list.html');
	}
	public function pageByuser()
	{
		$sortname=$_REQUEST['sortname'];
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 30;
		$count = 0;
		$list = daocall('question','pageByuser',array(getRole('user'),$page,$page_count,&$count,$sortname));
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('sortname',$sortname);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('question/pagelist.html');
	}

}


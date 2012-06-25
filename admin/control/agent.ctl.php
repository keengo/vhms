<?php
needRole('admin');
class AgentControl extends Control
{
	public function addAgentFrom()
	{
		if($_REQUEST['id']){
			$agent = daocall('agent','get',array($_REQUEST['id']));
			$this->_tpl->assign('agent',$agent);
			$this->_tpl->assign('edit',1);
		}
		return $this->_tpl->display('agent/addFrom.html');
	}
	public function addAgent()
	{
		$arr['name'] = $_REQUEST['name'];
		if ($_REQUEST['id']) {
			$arr['id'] = $_REQUEST['id'];
		}
		if (!daocall('agent','add',array($arr))) {
			$this->_tpl->assign('msg',"增加失败");
			return $this->_tpl->fetch('msg.html');
		}
		$log = array('operate_object'=>'name='.$_REQUEST['name'], 'admin'=>getRole('admin'),'operate'=>$_REQUEST['a']);
		apicall('operatelog','operatelogAdd',array($log));
		return $this->listAgent();
	}
	public function delAgent()
	{
		if(!daocall('agent','del',array($_REQUEST['id']))){
			$this->_tpl->assign('msg',"删除失败");
			return $this->_tpl->fetch('msg.html');
		}
		$log = array('operate_object'=>'id='.$_REQUEST['id'], 'admin'=>getRole('admin'),'operate'=>$_REQUEST['a']);
		apicall('operatelog','operatelogAdd',array($log));
		daocall('user','updateUserAgent_idByAent_id',array($_REQUEST['id']));
		daocall('agentprice','delAgentpriceByAgent_id',array($_REQUEST['id']));
		return $this->listAgent();
	}
	public function listAgent()
	{
		$agents = daocall('agent','selectList',array());
		$this->_tpl->assign('agents',$agents);
		return $this->_tpl->fetch('agent/listagent.html');
	}
}
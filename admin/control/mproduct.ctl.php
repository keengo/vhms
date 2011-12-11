<?php
needRole('admin');
class MproductControl extends Control
{
	public function addMproductFrom()
	{
		$agent_ids = daocall('agent','selectList',array());
		if($_REQUEST['id']) {
			$mproduct = daocall('mproduct','getMproductById',array(intval($_REQUEST['id'])));
			//传入代理价格
			for($i=0;$i<count($agent_ids);$i++){
				$attr['agent_id'] = $agent_ids[$i]['id'];
				$attr['product_type'] = 1;
				$attr['product_id'] = $_REQUEST['id'];
				$agentprice = daocall('agentprice','getAgentprice',array($attr));
				$agent_ids[$i]['price'] = $agentprice[0]['price'];
			}
			$this->_tpl->assign('edit','1');
			$this->_tpl->assign('mproduct',$mproduct);
		}
		//传入代理,页面显示价格设置
		$this->_tpl->assign('agent_ids',$agent_ids);
		$this->_tpl->assign("action","addProduct");
		
		$mproductgroup = daocall('mproductgroup','getMproductgroup',array());
		$this->_tpl->assign('mproductgroup',$mproductgroup);
		return $this->_tpl->display('mproduct/addfrom.html');
	}
	public function addMproduct()
	{
		$result_id = daocall('mproduct','add',array($_REQUEST));
		if (!$result_id) {
			$this->_tpl->assign('msg','增加失败');
			return $this->_tpl->fetch('msg.html');
		}
		//代理价格
		$agent_id = daocall('agent','selectList',array());
		foreach ($agent_id as $agent)
		{
			if($_REQUEST['agentprice_'.$agent['id']])
			{
				$arr['agent_id'] = $agent['id'];
				$arr['product_type'] = 1;//虚拟主机为0,非自动化为1
				$arr['product_id'] = $result_id;
				$arr['price'] = ($_REQUEST['agentprice_'.$agent['id']])*100;
				daocall('agentprice','addAgentprice',array($arr));
			}
		}
		
		return $this->pageListMproduct();
	}
	public function delMproduct()
	{
		$id = intval($_REQUEST['id']);
		$result = daocall('mproduct','del',array($id));
		if (!$result) {
			$this->_tpl->assign('msg','增加失败');
			return $this->_tpl->fetch('msg.html');
		}
		return $this->pageListMproduct();
	}
	public function editMproductFrom()
	{
		$id = intval($_REQUEST['id']);
		$mproduct = daocall('mproduct','getMproductById',array($id));
		$this->_tpl->assign('action','editMproduct');
		$this->_tpl->assign('mproduct',$mproduct);
		return $this->_tpl->display('mproduct/addfrom.html');
	}
	public function pageListMproduct()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 20;
		$count = 0;
		$order = $_REQUEST['order'] or 'id';//排序字段
		$list = daocall('mproduct','pageList',array($page,$page_count,&$count,$order));
		$mproduct_group = daocall('mproductgroup','getMproductgroup',array());
		if(is_array($list)) {
			for($i=0;$i<count($list);$i++) {
				foreach($mproduct_group as $mproduct) {
					if($list[$i]['group_id'] == $mproduct['id']) {
						$list[$i]['group_name'] = $mproduct['name'];
					}
				}
			}
		}
			
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('order',$order);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('mproduct/pagelistmproduct.html');
	}

}
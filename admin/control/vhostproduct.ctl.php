<?php
needRole('admin');
class VhostproductControl extends Control {

	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function refreshAllTemplete()
	{
		$list = daocall('nodes','getData',null);

	}
	public function refreshTemplete()
	{
		apicall('whm','refreshTemplete',array($_REQUEST['name']));
		$this->showTemplete();
	}
	public function ajaxUpdateProductView()
	{
		if(daocall('vhostproduct','updateProductView',array(intval($_REQUEST['id']),intval($_REQUEST['view']))))
		{
			$ret='0';
		}else{
			$ret="1";
		}
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str.="<result ret='".$ret."'>";
		$str.="</result>";
		return $str;
	}
	public function ajaxListSubTemplete()
	{
		$templete = apicall('nodes','listSubTemplete',array($_REQUEST['node'],$_REQUEST['templete']));
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str .="<result node='".$_REQUEST['node']."'>";
		for($i=0;$i<count($templete);$i++){
			$str.="<subtemplete>".$templete[$i]."</subtemplete>";
		}
		$str.="</result>";
		return $str;
	}
	public function ajaxListTemplete()
	{
		$templete = apicall('nodes','listTemplete',array($_REQUEST['node']));
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$str .="<result node='".$_REQUEST['node']."'>";
		for($i=0;$i<count($templete);$i++){
			$str.="<templete>".$templete[$i]."</templete>";
		}
		$str.="</result>";
		return $str;
	}
	public function ajaxChangeNode()
	{
		header("Content-Type: text/xml; charset=utf-8");
		$str = "<?xml version=\"1.0\" encoding=\"utf-8\"?>";
		$id = $_REQUEST['id'];
		$node = $_REQUEST['node'];
		$templete = $_REQUEST['templete'];
		$templetes = apicall('nodes','listTemplete',array($node));
		$finded = false;
		for($i=0;$i<count($templetes);$i++){
			if($templetes[$i] == $templete){
				$finded = true;
				break;
			}
		}
		if(!$finded){
			$str .="<result code='2'/>";
			return $str;
		}
		$result = daocall('vhostproduct','updateNode',array($id,$node));
		if($result){
			$str.="<result code='1'/>";
			apicall('product','flushVhostProduct');
		}else{
			$str.="<result code='0'/>";
		}
		daocall('product','flushVhostProduct');
		return $str;


	}
	public function showTemplete()
	{
		$list = daocall('vhosttemplete','getData',array());
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		return $this->_tpl->display('vhostproduct/showTemplete.html');
	}
	public function showProduct()
	{
		$product_flag = $_REQUEST['product_flag'];
		$list = daocall('vhostproduct','getProducts',array($product_flag));
		$this->_tpl->assign('sum',count($list));
		$this->_tpl->assign('list',$list);
		$this->_tpl->assign('product_flag',$product_flag);
		@load_conf('pub:node');
		if(is_array($GLOBALS['node_cfg'])){
			//$this->_tpl->assign('nodes',array_keys($GLOBALS['node_cfg']));
			$this->_tpl->assign('nodes',$GLOBALS['node_cfg']);
		}
		return $this->_tpl->fetch('vhostproduct/showProduct.html');
	}

	protected function assignHosts()
	{
		$nodes = daocall('nodes','getAllNodes',null);
		if(!$nodes || count($nodes)<=0){
			trigger_error("没有可用的主机，请先增加主机");
			return false;
		}
		$this->_tpl->assign("nodes",$nodes);
		return true;
	}
	public function editProductForm()
	{
		$agent_ids = daocall('agent','selectList',array());
		
		for($i=0;$i<count($agent_ids);$i++){
			$attr['agent_id'] 		= $agent_ids[$i]['id'];
			$attr['product_type'] 	= 0;
			$attr['product_id'] 	= $_REQUEST['id'];
			$agentprice = daocall('agentprice','getAgentprice',array($attr));
			$agent_ids[$i]['price'] = $agentprice[0]['price'];
		}
		$vhostproduct = daocall('vhostproduct','getProduct',array($_REQUEST['id']));
		if(!$vhostproduct){
			return trigger_error('不能找到该产品');
		}
		if(!$this->assignHosts()){
			return false;
		}
		$this->_tpl->assign('agent_ids',$agent_ids);
		$this->_tpl->assign('vhostproduct',$vhostproduct);
		$this->_tpl->assign('action','editProduct');

		return $this->_tpl->display('vhostproduct/addProduct.html');
	}
	public function addProductForm()
	{
		$agent_ids = daocall('agent','selectList',array());
		$this->_tpl->assign('agent_ids',$agent_ids);
		$this->_tpl->assign("action","addProduct");
		if(!$this->assignHosts()){
			die("请先增加主机");
		}
		return $this->_tpl->display('vhostproduct/addProduct.html');
	}
	public function addProduct()
	{
		$_REQUEST['price'] 			*= 100;
		$_REQUEST['speed_limit'] 	*= 1024;
		$_REQUEST['db_type'] 		= $_REQUEST['db_type'] ? $_REQUEST['db_type'] : 'mysql';
		if ($_REQUEST['cdn'] == '1') {
			$_REQUEST['subdir_flag'] 	= 1;
			$_REQUEST['templete']		='html';
		}
		$product_id = daocall('vhostproduct', 'addProduct', array($_REQUEST));

		$agent_id = daocall('agent','selectList',array());
		foreach ($agent_id as $agent) {
			if ($_REQUEST['agentprice_'.$agent['id']]) {
				$arr['agent_id'] 	= $agent['id'];
				$arr['product_type']= 0;//虚拟主机为0
				$arr['product_id'] 	= $product_id;
				$arr['price'] 		= ($_REQUEST['agentprice_'.$agent['id']])*100;
				daocall('agentprice','addAgentprice',array($arr));
			}
		}
		$log = array('admin'=>getRole('admin'),'operate'=>$_REQUEST['a'],'operate_object'=>'name='.$_REQUEST['name']);
		apicall('operatelog','operatelogAdd',array($log));
		apicall('product','flushVhostProduct');
		return $this->showProduct();
	}
	public function editProduct()
	{
		$_REQUEST['price'] 			*= 100;
		$_REQUEST['speed_limit'] 	*= 1024;
		if ($_REQUEST['cdn'] == '1') {
			$_REQUEST['subdir_flag']= 1;
			$_REQUEST['templete']	= 'html';
		}
		daocall('vhostproduct', 'updateProduct', array($_REQUEST));
		
		$agent_id = daocall('agent','selectList',array());
		foreach ($agent_id as $agent)
		{
			if($_REQUEST['agentprice_'.$agent['id']])
			{
				$arr['agent_id'] = $agent['id'];
				$arr['product_type'] = 0;//虚拟主机为0,域名为1
				$arr['product_id'] = $_REQUEST['id'];
				$arr['price'] = ($_REQUEST['agentprice_'.$agent['id']])*100;
				daocall('agentprice','addAgentprice',array($arr));
			}
		}
		$log = array('admin'=>getRole('admin'),'operate'=>$_REQUEST['a'],'operate_object'=>'id='.$_REQUEST['id']);
		apicall('operatelog','operatelogAdd',array($log));
		
		apicall('product','flushVhostProduct');
		return $this->showProduct();
	}
	public function del()
	{
		daocall('vhostproduct','delProduct',array($_REQUEST["id"]));		
		$arr['product_id'] 		= $_REQUEST['id'];
		$arr['product_type'] 	= 0;
		daocall('agentprice','delAgentprice',array($arr));
		//日志记录
		$log = array('admin'=>getRole('admin'),'operate'=>$_REQUEST['c']."&a=".$_REQUEST['a'],'operate_object'=>'id='.$_REQUEST['id']);
		apicall('operatelog','operatelogAdd',array($log));
		apicall('product','flushVhostProduct');
		return $this->showProduct();
	}
	public function flush()
	{
		apicall('product','flushVhostProduct');
		return $this->showProduct();
	}
}
?>
<?php
needRole('user');
class VhostproductControl extends Control {
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}

	public function getVhostByname()
	{
		$name=$_REQUEST['name'];
		$host=daocall('vhost','getVhostByname',array($name));
		if($host['username']!=getRole('user'))
		{
			return false;
		}
	}

	public function pageVhostByuser()
	{
		$name = $_REQUEST['name'];
		$search_key = $name;
		/*if(strchr($name,'.')){
			$domain = daocall('vhostinfo','findDomain',array($name));
			if($domain){
				$search_key = $domain['user'];
			}
		}*/
		if($GLOBALS['frame']==1){
			$this->_tpl->assign('target','_self');
		}else{
			$this->_tpl->assign('target','_blank');
		}
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 30;
		$count = 0;
		$list = daocall('vhost','pageVhostByuser',array(getRole('user'),$search_key,$page,$page_count,&$count));
		@load_conf('pub:vhostproduct');
		for($i=0;$i<count($list);$i++){
			$list[$i]['product_name'] = $GLOBALS['vhostproduct_cfg'][$list[$i]['product_id']]['name'];
		}
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('username',getRole('user'));
		$this->_tpl->assign('name',$name);
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('vhostproduct/listVhost.html');
	}
	public function show()
	{
		$list = daocall('vhost','listMyVhost',array(getRole('user')));
		$this->_tpl->assign('sum',count($list));
		load_conf('pub:vhostproduct');
		for($i=0;$i<count($list);$i++){
			$list[$i]['product_name'] = $GLOBALS['vhostproduct_cfg'][$list[$i]['product_id']]['name'];
		}
		$this->_tpl->assign('list',$list);
		//$this->_tpl->assign('product',$GLOBALS['vhostproduct_cfg']);
		return $this->_tpl->fetch('vhostproduct/list.html');
	}
	public function impLogin2()
	{
		$vhost = $_REQUEST['name'];
		$vhostinfo=daocall('vhost','getMyVhost',array(getRole('user'),$vhost));
		if (!$vhostinfo) {
			die("error! cann't find such vhost");
		}
		$node=$vhostinfo['node'];
		load_conf('pub:node');
		$skey=$GLOBALS['node_cfg'][$node]['passwd'];
		$host=$GLOBALS['node_cfg'][$node]['host'];
		$port=$GLOBALS['node_cfg'][$node]['port'];
		$r = rand();
		$s=md5($r.$vhost.$_REQUEST['r'].$skey);
		$url="http://".$host.":".$port."/vhost/?c=sso&a=login&name=".$vhost."&action=login&s=".$s."&r=".$r;
		header("Cache-Control: no-cache,no-store");
		header("Location: ".$url);
		die();
	}
	public function impLogin()
	{
		$vhost = $_REQUEST['name'];
		$vhostinfo=daocall('vhost','getVhost',array($vhost));
		if (!$vhostinfo) {
			die("error! cann't find such vhost");
		}
		$node=$vhostinfo['node'];
		load_conf('pub:node');
		$skey=$GLOBALS['node_cfg'][$node]['passwd'];
		$host=$GLOBALS['node_cfg'][$node]['host'];
		$port=$GLOBALS['node_cfg'][$node]['port'];
		$path = $_SERVER["REQUEST_URI"];
		$path_point = strpos($_SERVER["REQUEST_URI"],'?');
		if($path_point>0){
			$path = substr($path,0,$path_point);
		}
		$url="http://".$_SERVER['HTTP_HOST'].$path."?c=vhostproduct&a=impLogin2&name=".$vhost;
		$hellourl="http://".$host.":".$port."/vhost/?c=sso&a=hello&name=".$vhost."&url=".urlencode($url);
		header("Location: ".$hellourl);
		die();
	}
	public function left()
	{
		return dispatch('user','left');
	}
	public function upgradeForm()
	{
		$vhost = $_REQUEST['name'];
		$vhost_info = daocall('vhost','getVhost',array($vhost,array('username','product_id','try_is')));
		if(!$vhost_info || $vhost_info['username'] != getRole('user')){
			trigger_error('没有找到该虚拟主机');
			return false;
		}
		if ($vhost_info['try_is'] != 0) {
			$this->_tpl->assign('msg', '试用产品不能升级');
			return $this->_tpl->fetch('vhostproduct/msg.html');
		}
		$this->_tpl->assign("name",$vhost);
		//$product = apicall('product','newProduct',array('vhost'));
		//$product_info = $product->getInfo($vhost_info['product_id']);
		//if(!$product_info || $product_info['upid']==0){
		//	return "没有其它产品可供升级了";
		//}
		$product_id = $vhost_info['product_id'];
		@load_conf('pub:vhostproduct');
		$upproduct = array();
		
		//取得用户信息，代理ID
		$userinfo = daocall('user','getUser',array(getRole('user')));
		if ($GLOBALS['vhostproduct_cfg'][$product_id]['upid']>0) {
			foreach($GLOBALS['vhostproduct_cfg'] AS $product){
				if ($product_id == $product['id']) {
					//相同
					continue;
				}
				if ($GLOBALS['vhostproduct_cfg'][$product_id]['upid']!=$product['upid']) {
					//uid不相同
					continue;
				}
				if ($GLOBALS['vhostproduct_cfg'][$product_id]['price'] > $product['price']) {
					//价格只能向上升级
					continue;
				}			
				if($userinfo['agent_id'] >0 ) {
					$arr['agent_id'] = $userinfo['agent_id'];
					$arr['product_type'] = 0;
					$arr['product_id'] = $product['id'];
					$agentinfo = daocall('agentprice','getAgentprice',array($arr));
					if ($agentinfo && $agentinfo[0]['price'] >0) {
						$product['price'] = $agentinfo[0]['price'];
					}
				}
				$upproduct[] = $product;
			}
		}
		if (count($upproduct)<=0) {
			//return "没有其它产品可供升级了";
			$this->_tpl->assign('msg','没有其它产品可供升级了');
			return $this->_tpl->fetch('vhostproduct/msg.html');
		}

		$this->_tpl->assign('products',$upproduct);
		return $this->_tpl->fetch('vhostproduct/upgrade.html');
	}
	public function renewForm()
	{
		$vhost = $_REQUEST['name'];
		$vhost_info = daocall('vhost','getVhost',array($vhost,array('username','product_id')));
		if(!$vhost_info || $vhost_info['username'] != getRole('user')){
			trigger_error('没有找到该虚拟主机');
			return false;
		}
		$this->_tpl->assign("name",$vhost);
		$product = apicall('product','newProduct',array('vhost'));
		$product_info = $product->getInfo($vhost_info['product_id']);
		if($product_info){
			$userinfo = daocall('user','getUser',array(getRole('user')));
			if($userinfo['agent_id'] >0 ) {
				$arr['agent_id'] = $userinfo['agent_id'];
				$arr['product_type'] = 0;
				$arr['product_id'] = $vhost_info['product_id'];
				$agentinfo = daocall('agentprice','getAgentprice',array($arr));
				if ($agentinfo && $agentinfo[0]['price'] >0) {
					$product_info['price'] = $agentinfo[0]['price'];
				}
			}
			$this->_tpl->assign("product",$product_info);
		}

		return $this->_tpl->fetch('vhostproduct/renew.html');
	}
}
?>
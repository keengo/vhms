<?php
needRole('admin');
class VhostControl extends Control {
	/*
	public function showVhostold()
	{
		$user = $_REQUEST['user'];
		$skip_search = false;
		if($user==""){
			$user = $_REQUEST['name'];
			$skip_search = true;
		}
		$this->_tpl->assign('user',$user);
		if($user){
			if($user[0]=='#'){
				$user = substr($user,1);
				$call = 'listVhostByUid';
			}else{
				$call = 'listVhostByName';
			}
			$result = $this->getUser($user,$call);
			if(!$result && !$skip_search){
				$result = daocall('vhostinfo','findDomain',array($user));
				if($result){
					$user = $result['user'];
					$result = $this->getUser($user,'listVhostByName');
				}
			}
			if(!$result){
				$this->_tpl->assign("msg","没有找到该虚拟主机");
			}
		}
		$this->_tpl->display('vhostproduct/listVhost.html');
	}
	*/
	public function showVhost()
	{
		$user=$_REQUEST['user'];
		if(strpos($user,'.')){
			$return=daocall('vhostinfo','getInfoByDomin',array($user));
			if(!$return){
				$this->assign('msg','没有此域名');
				return $this->fetch('msg.html');
			}
			$list=daocall('vhost','listVhostByName',array($return['vhost']));
			$this->assign('list',$list);
			return $this->_tpl->display('vhostproduct/listVhost.html');
		}
		if($user[0]=='#'){
			$user=substr($user,1);
			$call='listVhostByUid';
		}else{
			$call='listVhostByName';
		}
		$list=daocall('vhost',$call,array($user));
		$this->assign('list',$list);
		return $this->_tpl->display('vhostproduct/listVhost.html');
	}
	public function adminLogin2()
	{
		$vhost = $_REQUEST['name'];
		$vhostinfo=daocall('vhost','getVhost',array($vhost));
		if (!$vhostinfo) {
			die("error! cann't find such vhost");
		}
		$node=$vhostinfo['node'];
		load_conf('pub:node');
		$skey=$GLOBALS['node_cfg'][$node]['passwd'];
		$r = rand();
		$s=md5($r.$vhost.$_REQUEST['r'].$skey);
		$url="http://".$node.":".$GLOBALS['node_cfg'][$node][port]."/admin/?c=sso&a=login&name=".$vhost."&action=login&s=".$s."&r=".$r;
		header("Location: ".$url);
		die();
	}
	public function adminLogin()
	{
		$vhost = $_REQUEST['user'];
		$vhostinfo=daocall('vhost','getVhost',array($vhost));
		if (!$vhostinfo) {
			die("error! cann't find such vhost");
		}
		$node=$vhostinfo['node'];
		load_conf('pub:node');
		$skey=$GLOBALS['node_cfg'][$node]['passwd'];
		$url="http://".$_SERVER['HTTP_HOST'].$_SERVER["REQUEST_URI"]."?c=vhostproduct&a=adminLogin2&name=".$vhost;
		$hellourl="http://".$node.":".$GLOBALS['node_cfg'][$node][port]."/admin/?c=sso&a=hello&name=".$vhost."&url=".urlencode($url);
		header("Location: ".$hellourl);
		die();
	}
	private function getUser($user,$call)
	{
		$list = daocall('vhost',$call,array($user,'row'));
		if($list){
			$product_info = apicall('product','getVhostProduct',array($list['product_id']));
			$list['product_name'] = $product_info['name'];
			$this->_tpl->assign('row',$list);
			$list = daocall('vhostinfo','getDomain',array($list['name']));
			$this->_tpl->assign('list',$list);
				print_r($list);
		die();
			return true;
		
		}
		return false;
	}
	public function pageVhost()
	{
		$page = intval($_REQUEST['page']);
		if($page<=0){
			$page = 1;
		}
		$page_count = 25;
		$count = 0;
		$list = daocall('vhost','pageVhost',array($page,$page_count,&$count));
		foreach($list AS $row){

		}
		$total_page = ceil($count/$page_count);
		if($page>=$total_page){
			$page = $total_page;
		}
		$this->_tpl->assign('count',$count);
		$this->_tpl->assign('total_page',$total_page);
		$this->_tpl->assign('page',$page);
		$this->_tpl->assign('page_count',$page_count);
		$this->_tpl->assign('list',$list);
		$this->_tpl->display('vhostproduct/listVhost.html');

	}
	public function del()
	{
		$name=$_REQUEST['name'];
		if(!$name)
		{
			return false;
		}
		$nameinfo=daocall('vhost','getVhost',array($name));
		if(!apicall('vhost','del',array($nameinfo['node'],$name))){
			$this->assign('msg','删除失败');
			return $this->fetch('msg.html');
		}
		$this->assign('msg','删除成功');
		return $this->fetch('msg.html');

		//		$vhost = $_REQUEST['name'];
		//		$node = daocall('vhost','getNode',array($vhost));
		//		apicall('vhost','del',array($node,$vhost));
		//		return $this->showVhost();
	}
	public function setStatus()
	{
		//$arr['status'] = $_REQUEST['status'];
		$vhost = $_REQUEST['name'];
		//daocall('vhost','updateVhost',array($vhost,$arr));
		$node = daocall('vhost','getNode',array($vhost));
		apicall('vhost','changeStatus',array($node,$vhost,$_REQUEST['status']));
		//apicall('vhost','noticeChange',array($node,$vhost));
		return $this->pageVhost();
	}
	public function resync()
	{
		$vhost = $_REQUEST['name'];
		$attr = daocall('vhost','getVhost',array($vhost,array(
			'node',
			'product_id',
			'name',
			'doc_root',
			'uid',
			'status'
			)));
			if(apicall('vhost','sync',array($attr))){
				$this->_tpl->assign('msg','重建空间成功');
			}else{
				$this->_tpl->assign('msg','重建空间失败');
			}
			return $this->fetch('msg.html');
	}
	public function randPassword()
	{
		$vhost = $_REQUEST['name'];
		$passwd = getRandPasswd();
		$node = daocall('vhost','getVhost',array($vhost,array('node')));
		if(apicall('vhost','changePassword',array($node['node'],$vhost,$passwd))){
			$msg = "新密码是: ".$passwd;
		}else{
			$msg = "重设密码出错";
		}
		$this->_tpl->assign('msg',$msg);
		return $this->showVhost();
	}
	public function randDbPassword()
	{
		$vhost = $_REQUEST['name'];
		$node = daocall('vhost','getVhost',array($vhost,array('node','product_id','uid')));
		$product = daocall('vhostproduct','getProduct',array($node['product_id'],array('db_quota')));
		if(!$product && $product['db_quota'] == 0){
			$msg = "重设数据库密码出错，该产品没有数据库。";
		}else{
			$passwd = getRandPasswd();
			$db = apicall('nodes','makeDbProduct',array($node['node']));
			if($db && $db->password($node['uid'],$passwd)){
				$msg = "新数据库密码是: ".$passwd;
			}else{
				$msg = "重设数据库密码出错，请联系管理员。";
			}
		}
		$this->_tpl->assign('msg',$msg);
		return $this->showVhost();
	}
	public function impLogin()
	{
		registerRole('vhost',$_REQUEST['name']);
		header("Location: /vhost/");
	}
}
?>

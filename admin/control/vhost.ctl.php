<?php
needRole('admin');
class VhostControl extends Control {
	public function showVhost()
	{
		$user = $_REQUEST['user'];
		$skip_search = false;
		if($user==""){
			$user = $_REQUEST['name'];
			$skip_search = true;
		}
		$this->_tpl->assign('user',$user);
		if($user){
			if(!$skip_search){
				$result = daocall('vhostinfo','findDomain',array($user));
				if($result){
					$user = $result['user'];
				}
			}
			if($user[0]=='#'){
				$user = substr($user,1);
				$call = 'listVhostByUid';
			}else{
				$call = 'listVhostByName';
			}
			$list = daocall('vhost',$call,array($user,'row'));

			if($list){
				$product_info = apicall('product','getVhostProduct',array($list['product_id']));
				$list['product_name'] = $product_info['name'];
				$this->_tpl->assign('row',$list);
				$list = daocall('vhostinfo','getDomain',array($list['name']));
				$this->_tpl->assign('sum',count($list));
				$this->_tpl->assign('list',$list);
			}else{
				$this->_tpl->assign("msg","没有找到该虚拟主机");
			}
		}
		$this->_tpl->display('vhostproduct/showVhost.html');
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
	public function setStatus()
	{
		//$arr['status'] = $_REQUEST['status'];
		$vhost = $_REQUEST['name'];
		//daocall('vhost','updateVhost',array($vhost,$arr));
		$node = daocall('vhost','getNode',array($vhost));
		apicall('vhost','changeStatus',array($node,$vhost,$_REQUEST['status']));
		//apicall('vhost','noticeChange',array($node,$vhost));
		return $this->showVhost();
	}
	public function resync()
	{
		$vhost = $_REQUEST['name'];
		$attr = daocall('vhost','getVhost',array($vhost,array(
			'node',
			'product_id',
			'name',
			'passwd',
			'doc_root',
			'uid',
			'gid',
			'templete',
			'subtemplete',
			'status'
			)));
		if(apicall('vhost','sync',array($attr))){
			$this->_tpl->assign('msg','重建空间成功');
		}else{
			$this->_tpl->assign('msg','重建空间失败');
		}
		return $this->showVhost();
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

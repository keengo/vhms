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
					$user = $result['name'];
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
	public function setStatus()
	{
		$arr['status'] = $_REQUEST['status'];
		$vhost = $_REQUEST['name'];
		daocall('vhost','updateVhost',array($vhost,$arr));
		$node = daocall('vhost','getNode',array($vhost));
		apicall('vhost','noticeChange',array($node,$vhost));
		return $this->showVhost();
	}
	public function resync()
	{
		$vhost = $_REQUEST['name'];
		$node = daocall('vhost','getVhost',array($vhost,array('node','product_id')));
		$product = daocall('vhostproduct','getProduct',array($node['product_id'],array('web_quota')));
		$whm = apicall('nodes','makeWhm',array($node['node']));
		$whmCall = new WhmCall('core.whm','reload_vh');
		$whmCall->addParam('name',$vhost);
		if($product){
			$whmCall->addParam('quota_limit',$product['web_quota']);
		}
		$whmCall->addParam('init','1');
		if($whm->call($whmCall)){
			
		}
		return $this->showVhost();
	}
	public function randPassword()
	{
		$passwd = getRandPasswd();
		if(daocall('vhost','updatePassword',array($_REQUEST['name'],$passwd))){
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

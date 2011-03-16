<?php
needRole('admin');
class VhostControl extends Control {
	public function showVhost()
	{
		$user = $_REQUEST['user'];
		$this->_tpl->assign('user',$user);
		if($user){
			$result = daocall('domain','findDomain',array($user));
			if($result){
				$user = $result['name'];
			}
			if($user[0]=='#'){
				$user = substr($user,1);
				$call = 'listVhostByUid';
			}else{
				$call = 'listVhostByName';
			}
			$list = daocall('vhost',$call,array($user,'row'));
			$this->_tpl->assign('row',$list);
			if($list){
				$list = daocall('domain','getDomain',array($list['name']));
				$this->_tpl->assign('sum',count($list));
				$this->_tpl->assign('list',$list);
			}
		}
		$this->_tpl->display('vhostproduct/showVhost.html');
	}
	public function setStatus()
	{
		$arr['status'] = $_REQUEST['status'];
		$vhost = $_REQUEST['user'];
		daocall('vhost','updateVhost',array($vhost,$arr));
		$node = daocall('vhost','getNode',array($vhost));
		apicall('vhost','noticeChange',array($node,$vhost));
		return $this->showVhost();
	}
	public function resync()
	{
		$vhost = $_REQUEST['user'];
		$node = daocall('vhost','getVhost',array($vhost,array('node','product_id')));
		$product = daocall('vhostproduct','getProduct',array($node['product_id'],array('web_quota')));
		$whm = apicall('nodes','makeWhm',array($node['node']));
		$whmCall = new WhmCall('core.whm','reload_vh');
		$whmCall->addParam('name',$vhost);
		if($product){
			$whmCall->addParam('quota',$product['web_quota']);
		}
		$whmCall->addParam('init','1');
		if($whm->call($whmCall)){
			
		}
		return $this->showVhost();
	}
	public function changePassword()
	{
		
	}
	
}
?>

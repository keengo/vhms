<?php
class VhostAPI extends API
{
	function __construct()
	{
		//load_lib('pub:whm');
	}
	public function noticeChange($node,$name)
	{
		$whm = apicall('nodes','makeWhm',array($node));
		$whmCall = new WhmCall('core.whm','reload_vh');
		$whmCall->addParam('name', $name);
		if(!$whm->call($whmCall)){
			return false;
		}
		return true;
	}
	public function getQuota($name,$uid,$node,$product_id)
	{
		$whm = apicall('nodes','makeWhm',array($node));
		$whmCall = new WhmCall('vhost.whm','get_quota',5);
		$whmCall->addParam('vh', $name);
		$result = $whm->call($whmCall,5);
		if(!$result){
			return false;
		}
		$ret['web_limit'] = $result->get('quota_limit');
		$ret['web_used'] = $result->get('quota_used');
		$product = daocall('vhostproduct','getProduct',array($product_id,array('db_quota')));
		if($product && $product['db_quota']>0){
			$db = apicall('nodes','makeDbProduct',array($node));
			if(is_object($db)){
				$used = $db->used($uid);
				$ret['db_limit'] = $product['db_quota'];
				$ret['db_used'] = $used;
			}
		}	
		return $ret; 
	}
	public function getProduct($name)
	{
		return $_SESSION['product_id'][$name];
	}
	public function getNode($name)
	{
		$node = $_SESSION['node'][$name];
		if($node=="" || empty($node)){
			$node_info = daocall('vhost','getVhost',array($name,array('node','product_id')));
			$_SESSION['node'][$name] = $node_info['node'];
			$node = $_SESSION['node'][$name];
			$_SESSION['product_id'][$name] = $node_info['product_id'];			
		}
		return $node;
	}
	public function getPrefix()
	{
		return '/home/ftp/';
	}
	public function changeSubtemplete($node,$name,$subtemplete)
	{
		if($node==null){
			$node = $this->getNode($name);
		}
		$attr = array('subtemplete'=>$subtemplete,'init'=>1);
		if($GLOBALS['node_db']=='sqlite'){
			if(!$this->sqliteUpdateVirtualHost($node,$name, $attr)){
				return false;
			}
		}
		$arr2 = array('subtemplete'=>$subtemplete);
		if(daocall('vhost','updateVhost',array($name,$arr2))){		
			if($GLOBALS['node_db']!='sqlite'){
				$this->noticeChange($node,$name);
			}
			return true;
		}
		return false;		
	}
	public function changeStatus($node,$name,$status)
	{
		$attr = array('status'=>$status);
		if($GLOBALS['node_db']=='sqlite'){
			if(!$this->sqliteUpdateVirtualHost($node,$name, $attr)){
				return false;
			}
		}
		if(daocall('vhost','updateVhost',array($name,$attr))){		
			if($GLOBALS['node_db']!='sqlite'){
				$this->noticeChange($node,$name);
			}
			return true;
		}
		return false;
	}
	/**
	 * 
	 * 更改虚拟主机的ftp密码，
	 * @param  $node 节点，可为null
	 * @param  $user ftp名
	 * @param  $passwd 密码
	 */
	public function changePassword($node,$name,$passwd)
	{
		if($node==null){
			$node = $this->getNode($name);
		}
		if($GLOBALS['node_db']=='sqlite'){
			if(!$this->sqliteUpdateVirtualHost($node,$name, array('passwd'=>md5($passwd)))){
				return false;
			}
		}
		return daocall('vhost','updatePassword',array($name,$passwd));
	}
	public function delInfo($user,$name,$type,$value)
	{
		$node = $this->getNode($user);
		if($GLOBALS['node_db']=='sqlite'){
			$whm = apicall('nodes','makeWhm',array($node));
			$whmCall = new WhmCall('core.whm','del_vh_info');
			$whmCall->addParam('vhost',$user);
			$whmCall->addParam('name',$name);
			$whmCall->addParam('type',$type);
			if($value!=null){
				$whmCall->addParam('value',$value);
			}
			if(!$whm->call($whmCall)){
				return false;
			}
		}		
		if(daocall('vhostinfo','delInfo',array($user,$name,$type,$value))){
			if($GLOBALS['node_db']!='sqlite'){
				return $this->noticeChange($node,$user);
			}
			return true;
		}
		return false;
	}
	public function addInfo($user,$name,$type,$value,$multi = true)
	{
		$node = $this->getNode($user);
		if($GLOBALS['node_db']=='sqlite'){
			$whm = apicall('nodes','makeWhm',array($node));
			$whmCall = new WhmCall('core.whm','add_vh_info');
			$whmCall->addParam('vhost',$user);
			$whmCall->addParam('name',$name);
			$whmCall->addParam('type',$type);
			$whmCall->addParam('value',$value);
			$whmCall->addParam('multi',$multi);
			if(!$whm->call($whmCall)){
				return false;
			}
		}		
		if(daocall('vhostinfo','addInfo',array($user,$name,$type,$value,$multi))){
			if($GLOBALS['node_db']!='sqlite'){
				return $this->noticeChange($node,$user);
			}
			return true;
		}
		return false;
	}
	private function sqliteUpdateVirtualHost($node,$name,$attr)
	{
		$whm = apicall('nodes','makeWhm',array($node));
		$whmCall = new WhmCall('core.whm','update_vh');
		$whmCall->addParam('name',$name);
		$key = array_keys($attr);
		for($i=0;$i<count($key);$i++){
			$whmCall->addParam($key[$i],$attr[$key[$i]]);
			//echo "addParam name=".$key[$i]." value=".$attr[$key[$i]]."<br>";
		}
		//echo $whmCall->buildUrl().$whmCall->buildPostData();
		return $whm->call($whmCall);
	}
	public function sync($attr)
	{
		$attr['resync'] = '1';
		$attr['init'] = '1';
		$attr['md5passwd'] = $attr['passwd'];
		$product_info = daocall('vhostproduct','getProduct',array($attr['product_id'],array('web_quota','db_quota')));
		$product = apicall('product','newProduct',array('vhost'));
		if (!$product->sync($attr['name'],$attr,$product_info)){
			return false;
		}
		return $product->syncExtraInfo($attr['name'],$attr['node']);
	}
	public function del($node,$name)
	{
		$whm = apicall('nodes','makeWhm',array($node));
		$whmCall = new WhmCall('core.whm','del_vh');
		$whmCall->addParam('destroy',1);
		$whmCall->addParam('name',$name);
		if($whm->call($whmCall)){
			daocall('vhostinfo','delAllInfo',array($name));
			return daocall('vhost','delVhost',array($name,null));
		}
		return false;
	}
}
?>

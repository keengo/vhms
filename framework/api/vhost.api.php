<?php
class VhostAPI extends API
{
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
			$used = $db->used($uid);
			$ret['db_limit'] = $product['db_quota'];
			$ret['db_used'] = $used;
		}	
		return $ret; 
	}
	public function getNode($name)
	{
		$node = $_SESSION['node'][$name];
		if(empty($node)){
			$node = daocall('vhost','getNode',array($name));
			$_SESSION['node'][$name] = $node;			
		}
		return $node;
	}
}
?>

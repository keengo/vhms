<?php
class VhostProduct extends Product
{

	public function __construct()
	{

	}
	public function __destruct()
	{

	}
	/**
	 * 得到产品信息
	 * @param $product_id 产品ID
	 * @return array(产品价格,是否支持月付<true|false>,是否支持试用<true|false>)
	 */
	public function getInfo($product_id,$susername=null)
	{
		return daocall('vhostproduct', 'getProduct', array($product_id));
	}
	/**
	 * 给付产品,这一步只插入数据库
	 * @param  $user
	 * @param  $month
	 * @param  $param
	 * @param  $params
	 * @param  $product_info
	 */
	protected function create($susername,&$params=array(),$product_info=array())
	{
		$params['doc_root'] = $this->getDocRoot($params['name']);
		$params['gid'] = $this->getNodeGroup($product_info['node']);
		$params['node'] = $product_info['node'];
		$params['init'] = '1';
		$params['templete'] = $product_info['templete'];
		$uid = daocall('vhost', 'insertVhost',
			array($susername,
			$params['name'],
			$params['passwd'],
			$params['doc_root'],
			$params['gid'],
			$product_info['templete'],
			$product_info['subtemplete'],
			0,
			$params['node'],
			$product_info['id'],
			$params['month']
			)
		);
		if($uid && $uid < 1000){
			daocall('vhost','updateMinUid',array(&$uid));	
			if($uid<1000){
				trigger_error('uid小于1000,请手工运行SQL: ALTER TABLE `vhost` AUTO_INCREMENT =1000');
				return false;
			}			
		}
		if($uid >= 1000){
			$params['uid'] = $uid;
			return true;	
		}
		return false;
	}
	/**
	 * 同步额外信息，比如域名绑定
	 * @param unknown_type $suser
	 */
	public function syncExtraInfo($suser,$node)
	{
		if($GLOBALS['node_db']!='sqlite'){
			return true;
		}
		$info = daocall('vhostinfo','getInfo',array($suser));
		$whm = apicall('nodes','makeWhm',array($node));
		for($i=0;$i<count($info);$i++){
			$whmCall = new WhmCall('core.whm','add_vh_info');
			$whmCall->addParam('vhost',$suser);
			$whmCall->addParam('name',$info[$i]['name']);
			$whmCall->addParam('type',$info[$i]['type']);
			$whmCall->addParam('value',$info[$i]['value']);	
			$whm->call($whmCall);		
		}
		return true;
	}
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	public function sync($user,$params,$product_info)
	{	
		
		echo "<br>";
		echo "<br>";
		print_r($product_info);
		echo "<br>";
		echo "<br>";
		print_r($params);
		
		$param = $params['name'];
		$whm = apicall('nodes','makeWhm',array($params['node']));
		if($GLOBALS['node_db']=='sqlite'){
			if($params['resync'] == '1'){
				$whmCall = new WhmCall('del_vh');
				$whmCall->addParam('name',$param);
				$whm->call($whmCall,10);
			}
			$whmCall = new WhmCall('add_vh');
			$whmCall->addParam('doc_root',$params['doc_root']);
			if($GLOBALS['node_cfg'][$params['node']]['win']==1){
				$whmCall->addParam('user','a'.$params['uid']);
			}else{
				$whmCall->addParam('user',$params['uid']);
			}
			if($product_info['db_quota']>0){
				$whmCall->addParam('db_quota', $product_info['db_quota']);
			}
			$whmCall->addParam('group', $params['gid']);
			$whmCall->addParam('templete',$params['templete']);
			$whmCall->addParam('product_id', $params['product_id']);
			$whmCall->addParam('uid', $product_info['uid']);
			$whmCall->addParam('subtemplete',$product_info['subtemplete']);
			$whmCall->addParam('domain', $product_info['domain']);
			$whmCall->addParam('subdir', $product_info['subdir']);
			$whmCall->addParam('subdir_flag', $product_info['subdir_flag']);
			$whmCall->addParam('htaccess', $product_info['htaccess']);
			$whmCall->addParam('ftp', $product_info['ftp']);
			$whmCall->addParam('log_file', $product_info['log_file']);
			$whmCall->addParam('access', $product_info['access']);
			//$whmCall->addParam('db_name', $product_info['db_name']);
			$whmCall->addParam('max_connect', $product_info['max_connect']);
			$whmCall->addParam('speed_limit', $product_info['speed_limit']);
			if($params['md5passwd']){
				$whmCall->addParam('passwd',$params['md5passwd']);
			}else{
				$whmCall->addParam('passwd',md5($params['passwd']));
			}
			if($params['status']){
				$whmCall->addParam('status',$params['status']);
			}
		}else{
			$whmCall = new WhmCall('add_vh');
		}
		$whmCall->addParam('name',$param);
		$whmCall->addParam('init',$params['init']);
		$whmCall->addParam('web_quota',$product_info['web_quota']);
		return $whm->call($whmCall,10);
	}
	public function checkParam($username,$suser)
	{
		if(!preg_match('/^[a-z0-9][a-z0-9_]{2,11}$/', $suser['name'])){
			trigger_error("用户名不符合标准");
			return false;
		}
		return true;
	}
	private function getDocRoot($name)
	{
		$prefix = apicall('vhost','getPrefix');
		return $prefix.$name[0].'/'.$name;
	}
	private function getNodeGroup($node)
	{
		if(apicall('nodes', 'isWindows',array($node))){
			return getRandPasswd(12);
		}
		return "1100";
	}
	protected function addMonth($susername, $month)
	{
		//echo $susername." 续费: ".$month;
		return daocall('vhost','addMonth',array($susername,$month));
	}
	protected function changeProduct($susername, $product)
	{
		return daocall('vhost','changeProduct',array($susername,$product['id'],$product['templete']));
	}
	protected function resync($username,$suser,$oproduct,$nproduct=null)
	{
		if($nproduct==null){
			//续费
			return true;
		}		
		$suser['resync'] = '1';
		$suser['init'] = '1';
		$suser['md5passwd'] = $suser['passwd'];
		$suser['templete'] = $nproduct['templete'];
		$suser['product_id'] = $nproduct['id'];
		return $this->sync($username,$suser,$nproduct);
	}
	public function getSuser($susername)
	{
		return daocall('vhost','getVhost',array($susername));
	}
}
?>

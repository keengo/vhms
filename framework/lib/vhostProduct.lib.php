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
		$uid = daocall('vhost', 'insertVhost',array($susername,
												$params['name'],
												$params['passwd'],
												$params['doc_root'],
												$params['gid'],
												$product_info['templete'],
												$product_info['subtemplete'],
												0,
												$params['node'],
												$product_info['id'],
												$params['month'],
												$params['db_type'],
												$params['max_subdir'],
												$params['max_worker'],
												$params['max_queue'],
												$params['log_handle']
		));
		if($uid && $uid < 2000){
			daocall('vhost','updateMinUid',array(&$uid));
			if($uid<2000){
				trigger_error('uid小于2000,请手工运行SQL: ALTER TABLE `vhost` AUTO_INCREMENT = 2000');
				return false;
			}
		}
		if($uid >= 2000){
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
		$param = $params['name'];
		$whm = apicall('nodes','makeWhm',array($params['node']));
		if($GLOBALS['node_db']=='sqlite'){
				
			//			if($params['resync'] == '1'){
			//				$whmCall = new WhmCall('del_vh');
			//				$whmCall->addParam('name',$param);
			//				$whm->call($whmCall,10);
			//			}
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
			//$whmCall->addParam('group', $params['gid']);
			$whmCall->addParam('templete',$product_info['templete']);
			//$whmCall->addParam('product_id', $params['product_id']);
			$whmCall->addParam('uid', $params['uid']);
			if($params['create_time']){
				$whmCall->addParam('create_time', $params['create_time']);
			}
			if($params['expire_time']){
				$whmCall->addParam('expire_time', $params['expire_time']);
			}
			if($params['month'])
			{
				$whmCall->addParam('expire_time', $params['month']*2592000+time());
			}
			$whmCall->addParam('subtemplete',$product_info['subtemplete']);
			$whmCall->addParam('domain', $product_info['domain']);
			$whmCall->addParam('subdir', $product_info['subdir']);
			$whmCall->addParam('subdir_flag', $product_info['subdir_flag']);
			$whmCall->addParam('htaccess', $product_info['htaccess']);
			$whmCall->addParam('ftp', $product_info['ftp']);
			$whmCall->addParam('log_file', $product_info['log_file']);
			$whmCall->addParam('access', $product_info['access']);
			$whmCall->addParam('max_connect', $product_info['max_connect']);
			$whmCall->addParam('speed_limit', $product_info['speed_limit']);
			$whmCall->addParam('cs', $product_info['cs']);
			$whmCall->addParam('envs', $product_info['envs']);
			$whmCall->addParam('cdn',$product_info['cdn']);
			$whmCall->addParam('db_type', $product_info['db_type']);
			$whmCall->addParam('max_subdir', $product_info['max_subdir']);
			$whmCall->addParam('max_worker', $product_info['max_worker']);
			$whmCall->addParam('max_queue', $product_info['max_queue']);
			$whmCall->addParam('log_handle', $product_info['log_handle']);
			
			if($params['passwd']){
				$whmCall->addParam('passwd', $params['passwd']);
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
		//续费,
		if($nproduct==null){
			/*如果开了续费开通空间，操作，则执行*/
			$set_renew = daocall('setting','get',array('set_renew'));
			if ($set_renew == 1) {
				$node = daocall('vhost','getNode',array($username));
				apicall('vhost','changeStatus',array($node,$username,0));
			}
			return true;
		}
		/*重建或创建空间*/
		$suser['resync'] = '1';
		$suser['init'] = '1';
		//$suser['md5passwd'] = $suser['passwd'];
		//$suser['templete'] = $nproduct['templete'];
		$suser['product_id'] = $nproduct['id'];
		return $this->sync($username,$suser,$nproduct);
	}
	public function getSuser($susername)
	{
		return daocall('vhost','getVhost',array($susername));
	}
}
?>

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
		$uid = daocall('vhost', 'insertVhost', 
		array($susername,
			$params['name'],
			$params['passwd'],
			$this->getDocRoot($params['name']),
			$this->getNodeGroup($product_info['node']),
			$product_info['templete'],
			0,
			$product_info['node'],
			$product_info['id'],
			$params['month']
			)
		);
		if($uid && $uid<1000){
			trigger_error('uid小于1000,请手工运行SQL: ALTER TABLE `vhost` AUTO_INCREMENT =1000');
			return false;
		}
		if($uid >= 1000){
			$params['uid'] = $uid;
			return true;
		}
		return false;
	}
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	protected function sync($user,$params,$product_info)
	{
		//print_r($product_info);
		//die();
		//echo "uid in sync=".$uid;
		$param = $params['name'];
		if($product_info['db_quota']>0){
			$db = apicall('nodes','makeDbProduct',array($product_info['node']));
			if(is_object($db)){
				$db->add($params['uid'],$params['passwd']);
			}
		}
		$whm = apicall('nodes','makeWhm',array($product_info['node']));
		$whmCall = new WhmCall('core.whm','reload_vh');
		$whmCall->addParam('name',$param);
		$whmCall->addParam('init','1');
		$whmCall->addParam('quota_limit',$product_info['web_quota']);
		return $whm->call($whmCall);
		//return false;
	}
	public function checkParam($params=array())
	{
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
	protected function changeProduct($susername, $product_id)
	{
		return daocall('vhost','changeProduct',array($susername,$product_id));
	}
	protected function resync($username,$suser,$oproduct,$nproduct=null)
	{
		if($nproduct==null){
			//续费
			return true;
		}
		//TODO:重新设置quota操作
		return false;
		//$whm = apicall('nodes','')
	}
	public function getSuser($susername)
	{
		return daocall('vhost','getVhost',array($susername));
	}
}
?>
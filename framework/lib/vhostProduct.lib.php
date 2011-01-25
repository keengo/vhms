<?php 
class VhostProduct extends Product
{
	
	const VHOST_PRODUCT_ACTIVE=0;
	const VHOST_PRODUCT_CLOSE=1;
	const VHOST_PRODUCT_PAUSE=2;
	
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
	protected function getInfo($product_id)
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
	protected function give($user="",$month=12,$param="",$params=array(),$product_info=array())
	{
		return daocall('vhost', 'insertVhost', 
		array($user,
			$param,
			$params['passwd'],
			$this->getDocRoot($param),
			$this->getNodeGroup($product_info['node']),
			$product_info['templete'],
			self::VHOST_PRODUCT_ACTIVE,
			$product_info['node'],
			$product_info['id'],
			$month
			)
		);
	}
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	protected function sync($user,$param,$params,$product_info)
	{
		//print_r($product_info);
		//die();
		$whm = apicall('nodes','makeWhm',array($product_info['node']));
		$whmCall = new WhmCall('core.whm','reload_vh');
		$whmCall->addParam('name',$param);
		$whmCall->addParam('init','1');
		return $whm->call($whmCall);
		//return false;
	}
	public function checkParam($params=array())
	{
		return true;
	}
	private function getDocRoot($name)
	{
		return '/home/ftp/'.$name[0].'/'.$name;
	}
	private function getNodeGroup($node)
	{
		if(strncasecmp($node,'win_',4)==0){
			return parent::getRandPasswd(8);
		}
		return "1100";
	}
}
?>
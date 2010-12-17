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
	protected function getInfo($product_id)
	{
		return daocall('vhostproduct', 'getProduct', $product_id);
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
		
		return true;
	}
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	protected function sync($user,$param)
	{
		return false;
	}
	public function checkParam($params=array())
	{
		return true;
	}
}
?>
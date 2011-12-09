<?php
class MProduct extends Product
{

	public function __construct()
	{

	}
	public function __destruct()
	{

	}
	
	/**
	 * 得到产品信息
	 * 条件 product_id
	 * @param unknown_type $product_id
	 */
	public function getInfo($product_id)
	{
		return daocall('mproduct','getMproductById',array($product_id));
	}
	
	
	public function sync($username,$product_id,$arr)
	{
		$arr['username'] = $username;
		$return = daocall('mproductorder','add',array($arr));
		if ($return) {
			
		}
	}
	
	
	/**
	 * 插入订单数据库
	 * 1.username
	 * 2.product_id
	 * 3.arr 用户的输入信息
	 * Enter description here ...
	 * @param $username
	 */
	public  function create($susername,&$params=array(),$product_info=array())
	{
		$arr['username'] = $susername;
		$arr['product_id'] = $params['product_id'];
		$arr['client_msg'] = $params['client_msg'];
		//一个月的价格
		$month_price = $product_info['price']/12/100;
		
		if($params['admin_msg']) {
			$arr['admin_msg'] = $params['admin_msg'];
		}
		if($params['admin_mem']) {
			$arr['admin_mem'] = $params['admin_mem'];
		}
		if($params['status']) {
			$arr['status'] = $params['status'];
		}
		if($params['last_month']) {
			$arr['last_month'] = $params['last_month'];
			$arr['last_price'] = $params['month']*$month_price;
		}
		return daocall('mproductorder','add',array($arr));
	}
	/**
	 * 执行一些后续操作。
	 * 写购买记录
	 * @see framework/lib/Product::sync()
	 */
	public function sync($user,$params,$product_info)
	{
		
	}





}
?>
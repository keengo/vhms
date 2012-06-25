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
	public function getInfo($product_id,$susername=null)
	{
		$mproduct=daocall('mproduct','getMproductById',array($product_id));
		$mproduct['product_type'] = 1;
		return $mproduct;
	}
	
	
	public function sync($username,$product_id,$arr)
	{
		return true;
	}
	protected function resync($username,$suser,$oproduct,$nproduct=null)
	{
		return true;
	}
	/**
	 * 增加时间
	 * where $id
	 * $month
	 * @see framework/lib/Product::addMonth()
	 */
	protected function addMonth($id, $month)
	{
		
		return daocall('mproductorder','addMonth',array($id,$month));
	}
	protected function changeProduct($susername, $product)
	{
		//非自动化业务
		return true;
	}
	public function getSuser($id)
	{
		return daocall('mproductorder','getMproductorder',array($id));
	}
	
	public function checkParam($username,$suser)
	{
		//非自动化业务，没有用户名
		return true;
	}
	/**
	 * 插入订单数据库
	 * 1.username
	 * 2.product_id
	 * 3.arr 用户的输入信息
	 * Enter description here ...
	 * @param $username
	 */
	protected  function create($susername,&$params=array(),$product_info=array())
	{
		$arr['username'] = $susername;
		$arr['product_id'] = $params['product_id'];
		$arr['client_msg'] = $params['client_msg'];
		//一个月的价格
		$month_price = $product_info['price']/12/100;
		if($params['group_id']) {
			$arr['group_id'] = $params['group_id'];
		}
		if($params['admin_msg']) {
			$arr['admin_msg'] = $params['admin_msg'];
		}
		if($params['admin_mem']) {
			$arr['admin_mem'] = $params['admin_mem'];
		}
		if($params['status']) {
			$arr['status'] = $params['status'];
		}
		if($params['month']) {
			$arr['month'] = $params['month'];
			$arr['price'] = $params['month']*$month_price;
		}
		return daocall('mproductorder','add',array($arr));
	}


}
?>
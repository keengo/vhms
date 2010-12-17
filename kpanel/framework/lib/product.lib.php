<?php 
abstract class Product
{
	const PRODUCT_ACTIVE=1;
	const PRODUCT_TRY=2;
	const PRODUCT_MONTH=4;
	/**
	 * 计算金额
	 * @param $price 每年的价格
	 * @param $month 月份
	 */
	public function caculatePrice($price,$month)
	{
		if($this->isYears($month)){
			return $price*$month/12;
		}
		$price=$price/12;
		$price*$month;
		if($month==1){
			$price*=0.5;
		}
		return $price;
	}
	/*
	 * 看月份是否为整年
	 */
	public function isYears($month)
	{
		return $month/12*12==$month;
	}
	/**
	 * 购买产品
	 * @param $user 用户名	 
	 * @param $product_id 产品ID
	 * @param $month 购买时间(月份)
	 * @param $param 产品主键 
	 * @param $params 产品其它参数
	 */
	public function sell($user="",$product_id=0,$month=12,$param="",$params=array())
	{
		global $default_db;
		$info = $this->getInfo($product_id);
		if(!$info){
			trigger_error('产品错误');
			return false;
		}
		if(!($info['state'] & Product::PRODUCT_ACTIVE)){
			trigger_error('该产品不能购买');
			return false;
		}
		if(!($info['state'] & Product::PRODUCT_MONTH) && !isYears($month)){
			trigger_error('该产品不支持月付');
			return false;
		}
		if($month<=0){
			trigger_error('月份错误');
			return false;
		}
		$price = $this->caculatePrice($info['price'],$month);		
		if($price<0){
			trigger_error('价格错误');
			return false;
		}
		if($default_db==null){
			return false;
		}
		/*
		 * 开始事务
		 */
		if(!$default_db->beginTransaction()){
			return false;
		}
		if($price>0 && !apicall('money','decMoney', array($user,$price))){
			$default_db->rollBack();
			trigger_error('余额不足');
			return false;
		}
		if(!$this->give($user,$product_id,$month,$param,$params)){
			$default_db->rollBack();
			trigger_error('开通产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->sync($user,$param);
			return true;
		}
		return false;
	}
	/**
	 * 得到产品信息
	 * @param $product_id 产品ID
	 */
	abstract protected function getInfo($product_id);
	/**
	 * 给付产品,这一步只插入数据库
	 * @param  $user
	 * @param  $product_id
	 * @param  $month
	 * @param  $param
	 * @param  $params
	 */
	abstract protected function give($user="",$month=12,$param="",$params=array(),$product_info=array());
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	abstract protected function sync($user,$param);
	abstract public function checkParam($params=array());
}
?>
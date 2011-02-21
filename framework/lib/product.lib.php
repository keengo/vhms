<?php 
/**
 * 
 * 产品抽象类
 * 一种产品类型
 * @author Administrator
 *
 */
abstract class Product
{
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
	 * 
	 * 续费操作
	 * @param $username
	 * @param $susername
	 * @param $month
	 */
	public function renew($username,$susername,$month)
	{
		global $default_db;
		$suser = $this->getSuser($susername);
		if(!$suser || $suser['username']!=$username){
			trigger_error('不是你的产品哦');
			return false;
		}
		$info = $this->getInfo($suser['product_id']);
		if(!$info){
			trigger_error('产品错误');
			return false;
		}
		if($info['month_flag']!=0 && !$this->isYears($month)){
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
		daocall('product','open_db');
		if($default_db==null){
			trigger_error('没有连接数据库');
			return false;
		}
		/*
		 * 开始事务
		 */
		if(!$default_db->beginTransaction()){
			trigger_error('开始事务失败');
			return false;
		}
		//echo "haha";
		if($price>0 && !apicall('money','decMoney', array($username,$price))){
			$default_db->rollBack();
			trigger_error('余额不足,所需金额:'.($price/100));
			return false;
		}
		if(!$this->addMonth($susername,$month)){
			$default_db->rollBack();
			trigger_error('续费产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->resync($username,$suser,$info);
			return true;
		}
		return false;
	}
	public function upgrade($username,$suser,$new_product_id)
	{
		//产品升级操作
		return false;
	}
	/**
	 * 购买产品
	 * @param $user 用户名	 
	 * @param $product_id 产品ID
	 * @param $month 购买时间(月份)
	 * @param $param 产品主键 
	 * @param $params 产品其它参数
	 */
	public function sell($username,$product_id,$suser)
	{
		global $default_db;
		$month = $suser['month'];
		$info = $this->getInfo($product_id);
		if(!$info){
			trigger_error('产品错误');
			return false;
		}
		if($info['pause_flag']!=0){
			trigger_error('该产品不能购买');
			return false;
		}
		if($info['month_flag']!=0 && !$this->isYears($month)){
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
		if($price>0 && !apicall('money','decMoney', array($username,$price))){
			$default_db->rollBack();
			trigger_error('余额不足,所需金额:'.($price/100));
			return false;
		}
		if(!$this->create($username,$suser,$info)){
			$default_db->rollBack();
			trigger_error('开通产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->sync($username,$suser,$info);
			return true;
		}
		return false;
	}
	/**
	 * 得到产品信息
	 * @param $product_id 产品ID
	 */
	abstract public function getInfo($product_id,$susername = null);
	/**
	 * 给付产品,这一步只插入数据库
	 * @param  $user
	 * @param  $product_id
	 * @param  $month
	 * @param  $param
	 * @param  $params
	 */
	abstract protected function create($username,&$suser=array(),$product_info=array());
	/**
	 * 
	 * 更新用户数据
	 * @param $susername  用户名
	 * @param $month      月份
	 * @param $product_id 新产品ID,如果是0，则不更新
	 */
	abstract protected function addMonth($susername,$month);
	/**
	 * 
	 * 更改产品类型
	 * @param $susername
	 * @param $product_id
	 */
	abstract protected function changeProduct($susername,$product_id);
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	abstract protected function sync($username,$suser,$product_info);
	abstract protected function resync($username,$suser,$oproduct,$nproduct=null);
	abstract public function getSuser($susername);
}
?>
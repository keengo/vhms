<?php 
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
	public function renew($username,$param,$month)
	{
		$user = $this->loadUser($param);
		if($user['username'] != $username){
			return false;
		}
		$info = $this->getInfo($user['product_id']);
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
			trigger_error('余额不足,所需金额:'.($price/100));
			return false;
		}
		if(!$this->update($param,$month,0)){
			$default_db->rollBack();
			trigger_error('续费产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->sync($user,$param,$params,$info);
			return true;
		}
	}
	public function upgrade($username="",$param,$new_product_id)
	{
		
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
		if($price>0 && !apicall('money','decMoney', array($user,$price))){
			$default_db->rollBack();
			trigger_error('余额不足,所需金额:'.($price/100));
			return false;
		}
		if(!$this->give($user,$month,$param,$params,$info)){
			$default_db->rollBack();
			trigger_error('开通产品出错');
			return false;
		}
		if($default_db->commit()){
			$this->sync($user,$param,$params,$info);
			return true;
		}
		return false;
	}
	static protected function getRandPasswd($len=8)
	{
        $base_passwd='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_-0123456789';
        srand((double)microtime()*1000000);
        $base_len=strlen($base_passwd);
        if($len<8){
            $len=8;
        }
        for($i=0;$i<$len;$i++){
            $passwd.=$base_passwd[rand()%$base_len];
        }
        return $passwd;
	}
	
	/**
	 * 得到产品信息
	 * @param $product_id 产品ID
	 */
	abstract public function getInfo($product_id);
	/**
	 * 给付产品,这一步只插入数据库
	 * @param  $user
	 * @param  $product_id
	 * @param  $month
	 * @param  $param
	 * @param  $params
	 */
	abstract protected function give($user="",$month=12,$param="",&$params=array(),$product_info=array());
	/**
	 * 同步产品到磁盘或者远程
	 * @param  $user
	 * @param  $param
	 */
	abstract protected function sync($user,$param,&$params,$product_info);
	abstract public function checkParam($params=array());
	abstract public function loadUser($param);
	/**
	 * 
	 * 更新用户数据
	 * @param $username   用户名
	 * @param $month      月份
	 * @param $product_id 新产品ID,如果是0，则不更新
	 */
	abstract public function update($username,$month,$product_id);
}
?>
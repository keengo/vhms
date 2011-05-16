<?php
class MoneyAPI extends API
{
	public function decMoney($user,$money,$mem=null)
	{
		$money = intval($money);
		if($money<=0){
			return false;
		}
		daocall('moneyout','add',array($user,$money,$mem));
		return daocall('user', 'decMoney', array($user,$money));
	}
	public function addMoney($user,$money)
	{
		$money = intval($money);
		if($money<=0){
			return false;
		}
		return daocall('user', 'addMoney', array($user,$money));
	}
	public function payReturn($id)
	{
		global $default_db;
		$moneyin=daocall('moneyin','get',array($id));
		$user=daocall('user','getUser',array($moneyin['username']));
		if(!$default_db->beginTransaction()){
			trigger_error('开始事务失败');
			return false;
		}
		$result=daocall('moneyin','updateStatus',array($id));
		if (!$result) {
			$default_db->rollBack();
			//trigger_error('充值失败');			//回滚
			return false;
		}
		$result = $this->addMoney($moneyin['username'], $moneyin['money']);
		if(!$result){
			$default_db->rollBack();
			//trigger_error('充值失败');			//回滚
			return false;			
		}
		return $default_db->commit();			//提交
	}
}
?>
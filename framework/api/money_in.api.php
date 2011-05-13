<?php

class MoneyinAPI extends API
{
	public function add_return($id)
	{
		global $default_db;
		$moneyin=daocall('moneyin','get',array($id));
		$user=daocall('user','getUser',array($moneyin['username']));
		if(!$default_db->beginTransaction()){
			trigger_error('开始事务失败');
			return false;
		}
		$result1=daocall('moneyin','updateStatus',array($id));
		$money=$user['money']+$moneyin['money'];
		$result2=daocall('user','updateMoney',array($moneyin['username'],$money));
		if($moneyin['money']<0){
			$default_db->rollBack();
			trigger_error('充值失败');			//回滚
			return false;
		}
		if($moneyin['status']!=0){
			$default_db->rollBack();
			trigger_error('充值失败');			//回滚
			return false;
		}
		if(!$result1){
			$default_db->rollBack();
			trigger_error('充值失败');			//回滚
			return false;
		}
		if(!$result2){
			$default_db->rollBack();
			trigger_error('充值失败');			//回滚
			return false;
			
		}else{
			$default_db->commit();			//提交
			return true;
		}
			
	}
}

?>
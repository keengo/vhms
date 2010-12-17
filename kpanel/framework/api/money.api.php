<?php
class MoneyAPI extends API
{
	public function decMoney($user,$money)
	{
		$money = intval($money);
		if($money<=0){
			return false;
		}
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
}
?>
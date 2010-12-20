<?php
/**
 * 接口的基类
 *
 * @package core
 */
class API
{
	protected $old_info;
	protected $new_info;
	//定义业务错误码
	protected  $RET_SVR_BUSY = false;	//系统繁忙
	protected  $RET_PARAM_ER = false;	//参数出错
	protected  $RET_VALUE_MINUS = -301;	//为负数
	public $_kangleUrl;
	function __construct()
	{
		//$this->_kangleUrl = "http://kpanel.jx116.net:83";
	}

	function __destruct()
	{
		//TODO
	}
	
	protected function mcResult($ret)
	{
		if($ret === -1) 
		{
			//出错
			return false;
		} elseif ($ret === -2)
		{
			//连不上服务器
			return $this->RET_SVR_BUSY;
		}
		return $ret;
	}	

}
?>

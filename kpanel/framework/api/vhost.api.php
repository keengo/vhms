<?php
class VhostAPI extends API
{
	private $MAP_ARR;
	/**
	 * 构造函数
	 **/
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR 	= array(		//用户信息信息字段对照表
			"name" => 'name',
			"username" => 'username',
			"ftpuser"=>'ftpuser',
			"ftppwd"=>'ftppwd',
		);
	}

	/**
	 * 析构函数 
	 **/
	public function __destruct()
	{
		parent::__destruct();
	}
	public function addVhost($arr = array())
	{
		$ret = daocall('Vhost','insertVhost',array($arr));
		return $ret;
	}
	public function getVhost($Vhostname)
	{
		$ret = daocall('Vhost','getVhost',array($Vhostname));
		return $ret;
	}
	public function setVhost($Vhostname,$updateArr)
	{
		$ret = daocall('Vhost','updateVhost',array($Vhostname,$updateArr));
		return $ret;
	}
	public function delVhost($Vhostname)
	{
		$ret = daocall('Vhost','deleteVhost',array($Vhostname));
		return $ret;
	}
}
?>

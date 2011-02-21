<?php
class CFG
{
	public $config = array();
	private static $instance;
	private  function __construct()
	{
		
	}
	public static function getInstance()
	{
		if(self::$instance === null)
		{
			self::$instance = new CFG();
		}
		return self::$instance;
	}
	public function load_config($file)
	{
		if(empty($this->config[$file]))
		{
			load_conf($file);
			global $config;
			$this->config[$file] = $config;
		}
	}
}
?>
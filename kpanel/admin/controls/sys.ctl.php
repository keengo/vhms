<?php
class SysControl extends Control{
	public function __construct()
	{
		parent::__construct();
	}
	public function __destruct()
	{
		parent::__destruct();
	}
	public function info(){
		echo phpinfo();
	}
	public function stat(){
		echo phpinfo();
	}
}
<?php
needRole('admin');
class IndexControl extends Control
{
	public function __construct()
	{
		parent::__construct();
	}

	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		
		return $this->_tpl->fetch('index.html');
	}	
	public function registerForm()
	{
		echo "name=".$_REQUEST['name'];
		return $this->_tpl->fetch('register.html');
	}
}
?>
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
		$this->display('kpanel.html');
	}
	public function top()
	{
		$this->display('top.html');
	}
	public function controltop()
	{
		$this->display('controltop.html');
	}
	public function left()
	{
		$this->display('left.html');
	}
	public function controlleft()
	{
		$this->display('controlleft.html');
	}
	public function main()
	{
		$this->display('main.html');
	}
}
?>
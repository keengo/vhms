<?php
needRole('user');
class FrameControl extends Control
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
		return $this->_tpl->fetch('frame/index.html');
	}
	public function top()
	{
		return $this->_tpl->fetch('frame/top.html');
	}
	public function left()
	{
		return $this->_tpl->fetch('frame/left.html');
	}
	public function main()
	{
		return $this->_tpl->fetch('frame/main.html');
	}
}
?>

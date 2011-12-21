<?php
//首页文件
class HelpControl extends Control
{
	public function left()
	{
		return $this->_tpl->fetch('help/left.html');
	}
	public function index()
	{

		return $this->_tpl->fetch('help/index.html');
	}
	
	
}
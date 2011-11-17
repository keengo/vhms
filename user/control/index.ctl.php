<?php
//首页文件
class IndexControl extends Control
{
	public function left()
	{
		return $this->_tpl->fetch('index/left.html');
	}
	public function help()
	{
		return $this->_tpl->fetch('index/help.html');
	}
	
	
}
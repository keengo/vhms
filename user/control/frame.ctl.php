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
	public function login()
	{
		return $this->display('user/index.html');
	}
	public function index(){
		$request = '';
		foreach($_REQUEST as $k=>$v){
			if($k=='a' || $k=='c' || $k=='fa' || $k=='fc'){
				continue;
			}
			$request = '&'.$k.'='.urlencode($v);
		}
		$this->assign('request',$request);
		return $this->display('frame/index.html');
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
	public function controltop()
	{
		return $this->_tpl->fetch('frame/controltop.html');
	}
	public function controlleft()
	{
		return $this->_tpl->fetch('frame/controlleft.html');
	}
}
?>

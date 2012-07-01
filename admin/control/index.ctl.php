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
		$nodes = daocall('nodes','getAllNodes',array());
		if (count($nodes) < 0 || $nodes == null) {
			$js_str = '<script language="javascript">jQuery(document).ready(function(){';
			$js_str .= 'jQuery("#p44").append("'."&nbsp;<b class='one'><--第一步</b>".'");';
			$js_str .= 'jQuery("#p66").append("'."&nbsp;<b class='one'><--第二步</b>".'");});</script>';
		}else{
			$products = daocall('vhostproduct','selectProduct',array());
			if (count($products) < 0 || $products == null) {
				$js_str = '<script language="javascript">jQuery(document).ready(function(){';
				$js_str .= 'jQuery("#p66").append("'."&nbsp;<b class='one'><--下一步</b>".'");});</script>';
			}
		}
		if ($js_str) {
			$this->assign('js_str',$js_str);
		}
		return $this->display('left.html');
	}
	public function controlleft()
	{
		$this->display('controlleft.html');
	}
	public function main()
	{
		$role['admin'] = getRole('admin');
		$this->assign('role',$role);
		$this->display('main.html');
	}
}
?>
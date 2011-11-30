<?php
needRole('admin');
class MproductControl extends Control
{
	public function addMproductFrom()
	{
		return $this->_tpl->display('mproduct/addfrom.html');
	}
	public function addMproduct()
	{
		$result = daocall('mproduct','add',array($_REQUEST));
		if (!$result) {
			
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}
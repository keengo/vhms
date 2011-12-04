<?php
class MproductorderControl extends Control
{
	public function addMproductorderFrom()
	{
		if($_REQUEST['id']) {
			
			$mproductorder = daocall('mproductorder','getMproductorder',array(intval($_REQUEST['id'])));
			$this->_tpl->assign('mproductorder',$mproductorder);
			$this->_tpl->assign('edit',1);
		}
		$mproductgroup = daocall('mproductgroup','getMproductgroup',array());
		$this->_tpl->assign('mproductgroup',$mproductgroup);
		return $this->_tpl->fetch('mproductorder/addfrom.html');
	}

	



}
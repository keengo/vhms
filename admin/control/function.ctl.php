<?php
needRole('admin');
class FunctionControl extends Control
{
	private $setting;
	public function __construct()
	{
		parent::__construct();
		$setting = daocall('setting','getAll2',array());
		$this->setting = $setting;
	}
	public function set()
	{
		daocall('setting','add',array('view_dir',$_REQUEST['view_dir']));
		daocall('setting','add',array('reg_user_price',$_REQUEST['reg_user_price'] * 100));
		daocall('setting','add',array('reg_off',$_REQUEST['reg_off']));
		daocall('setting','add',array('findpasswd_off',$_REQUEST['findpasswd_off']));
		daocall('setting','add',array('try_day',$_REQUEST['try_day']));
		if ($_REQUEST['view_dir'] != $this->setting['view_dir']) {
			$log = array('operate_object'=>'view_dir='.$_REQUEST['view_dir'], 'admin'=>getRole('admin'),'operate'=>$_REQUEST['c']."&a=".$_REQUEST['a']);
			apicall('operatelog','operatelogAdd',array($log));
		}
		if (($_REQUEST['reg_user_price'] * 100) != $this->setting['reg_user_price']) {
			$log = array('operate_object'=>'reg_user_price='.$_REQUEST['reg_user_price'], 'admin'=>getRole('admin'),'operate'=>$_REQUEST['c']."&a=".$_REQUEST['a']);
			apicall('operatelog','operatelogAdd',array($log));
		}
		if ($_REQUEST['reg_off'] != $this->setting['reg_off']) {
			$log = array('operate_object'=>'reg_off='.$_REQUEST['reg_off'], 'admin'=>getRole('admin'),'operate'=>$_REQUEST['c']."&a=".$_REQUEST['a']);
			apicall('operatelog','operatelogAdd',array($log));
		}
		if ($_REQUEST['findpasswd_off'] != $this->setting['findpasswd_off']) {
			$log = array('operate_object'=>'findpasswd_off='.$_REQUEST['findpasswd_off'], 'admin'=>getRole('admin'),'operate'=>$_REQUEST['c']."&a=".$_REQUEST['a']);
			apicall('operatelog','operatelogAdd',array($log));
		}
		return header('Location: ?c=function&a=setFrom');

	}
	public function setFrom()
	{
		$viewdir = dirname(__FILE__).'/../view/';
		$op = opendir($viewdir);
		while (($dir = readdir($op)) !== false) {
			if ($dir == '.' || $dir =='..') {
				continue;
			}
			if (is_dir($viewdir.$dir) && file_exists(dirname(__FILE__).'/../../user/view/'.$dir)) {
				$view_dir[] = $dir;
			}
		}
		$view_dir_count = count($view_dir);
		if ($view_dir_count < 0 ) {
			$view_dir[] = 'default';
		}
		$setting = $this->setting;
		$this->assign('view_dir_count',$view_dir_count);
		$this->assign('view_dir',$view_dir);
		$this->assign('setting',$setting);
		return $this->fetch('function/setfrom.html');
	}
}
?>

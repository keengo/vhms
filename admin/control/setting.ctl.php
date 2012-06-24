<?php
needRole('admin');
class SettingControl extends Control
{
	public function setFrom()
	{
		return $this->fetch('setting/setFrom.html');
	}
	public function setOtherFrom()
	{
		$cron_str = "<font color='red'>请在计划任务中配置,每日运行一次,本计划任务自动执行:停止过期空间，提前7天发送过期空间通知邮件<br>";
		$cron_str .= 'php';
		if (strncasecmp(PHP_OS, 'WIN',3)==0) {
			$cron_str .='.exe';
		}
		$cron_str .=' -f "';
		$cron_str .= dirname(dirname(dirname(__FILE__)))."/framework/shell.php\" cron";
		$cron_str .="</font>";
		
		$setting = daocall('setting','getAll2',array());
		
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
		$this->_tpl->assign('view_dir_count',$view_dir_count);
		$this->_tpl->assign('view_dir',$view_dir);
		
		$this->assign('cron_str',$cron_str);
		$this->assign('setting',$setting);
		return $this->fetch('setting/setother.html');
	}
	/**
	 * 其他设置
	 * Enter description here ...
	 */
	public function setOther()
	{
		daocall('setting','add',array('set_renew',$_REQUEST['set_renew']));
		daocall('setting','add',array('view_dir',$_REQUEST['view_dir']));
		daocall('setting','add',array('reg_user_price',$_REQUEST['reg_user_price'] * 100));
		daocall('setting','add',array('expire_save_day',$_REQUEST['expire_save_day']));
		apicall('utils','delTempleteFile',array());
		return $this->setOtherFrom();
	}
	public function index()
	{
		@load_conf('pub:settingrule');
		@load_conf('pub:setting');
		$sub = $_REQUEST['sub'];
		$info = $GLOBALS['settingrule'][$sub];
		$this->assign('env',$info);
		$this->assign('val',$GLOBALS['setting_cfg']);
		$this->assign('sub',$sub);
		return $this->fetch('setting/show.html');
	}
	public function setupMain()
	{	
		@load_conf('pub:setting');
		$this->assign('setting',$GLOBALS['setting_cfg']);
		return $this->fetch('setting/setup.html');
	}
	public function set()
	{
		@load_conf('pub:settingrule');
		$names = $_REQUEST['name'];
		$sub = $_REQUEST['sub'];
		foreach($names AS $name){
			if($GLOBALS['settingrule'][$sub][$name]['password']){
				if($_REQUEST[$name]==""){
					continue;
				}
			}
			$ret = apicall('tplenv','checkEnv',array($name,$_REQUEST[$name],$GLOBALS['settingrule'][$sub]));
			if($ret!=ENV_CHECK_SUCCESS){
				$this->_tpl->assign('msg','设置:'.$GLOBALS['lang']['zh_CN'][$name].' 失败');
				$list = daocall('setting','getAll');
				apicall('utils','writeConfig',array($list,'name','setting'));
				return $this->index();
			}
			daocall('setting','add',array($name,$_REQUEST[$name]));
		}
		$list = daocall('setting','getAll');
		apicall('utils','writeConfig',array($list,'name','setting'));
		return $this->index();
	}
	public function webSetup()
	{
		daocall('setting','add',array('web_name',$_REQUEST['web_name']));
		daocall('setting','add',array('logo',$_REQUEST['logo']));
		daocall('setting','add',array('contact',$_REQUEST['contact']));
		daocall('setting','add',array('footer',$_REQUEST['footer']));
		daocall('setting','add',array('stat_code',$_REQUEST['stat_code']));
		daocall('setting','add',array('banner',$_REQUEST['banner']));
		daocall('setting','add',array('links',$_REQUEST['links']));
		daocall('setting','add',array('vhost_name',$_REQUEST['vhost_name']));
		$list = daocall('setting','getAll');
		apicall('utils','writeConfig',array($list,'name','setting'));
		return $this->setupMain();
	}
}
?>
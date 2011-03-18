<?php
needRole('vhost');
define(VHOST_INFO_ENV_TYPE,100);
class TplenvControl extends Control
{
	public function index()
	{
		$vhost = getRole('vhost');
		$user = $_SESSION['user'][$vhost];
		$this->_tpl->assign('env',apicall('tplenv','getEnv',array($user['templete'],$user['subtemplete'])));
		$info = daocall('vhostinfo','getInfo',array($vhost,VHOST_INFO_ENV_TYPE));
		for($i=0;$i<count($info);$i++){
			$val[$info[$i]['name']] = $info[$i]['value'];
		}
		//print_r($val);
		$this->_tpl->assign('val',$val);
		return $this->_tpl->fetch('tplenv.html');
	}
	public function setEnv()
	{
		$vhost = getRole('vhost');
		$user = $_SESSION['user'][$vhost];
		$ret = apicall('tplenv','setEnv',array($vhost,$user['templete'],$user['subtemplete'],$_REQUEST['name'],$_REQUEST[$_REQUEST['name']]));
		if($ret){
			$this->_tpl->assign('msg','设置成功');
		}else{
			$this->_tpl->assign('msg','设置失败');
		}
		return $this->index();
	}
}
?>

<?php
needRole('vhost');
class WebappControl extends Control
{
	public function index()
	{
		$list = daocall('vhostwebapp','getAll',array(getRole('vhost')));
		$sum = count($list);
		$this->_tpl->assign('sum',$sum);
		$this->_tpl->assign('list',$list);
		return $this->_tpl->fetch('webapp/show.html');
	}
	public function browse()
	{
		$result = apicall('webapp','getDomainInfo',array(getRole('vhost')));
		if(!$result){
			die("不能连接节点，请联系管理员");
		}
		$file_exts = $result->getAll('file_ext');
		return $this->install();
	}
	public function install()
	{
		$step = intval($_REQUEST['step']);	
		if ($step==0) {
			$this->_tpl->assign('appid','KKK1.zip');
			$this->_tpl->assign('appname','phpwind');
			$this->_tpl->assign('appver','8.5');
			$result = apicall('webapp','getDomainInfo',array(getRole('vhost')));
			if(!$result){
				die("不能连接节点，请联系管理员");
			}
			$this->_tpl->assign('domain',$result->getAll('domain'));
			return $this->_tpl->fetch('webapp/step0.html');
		}
		if ($step==1) {
			$appid = $_REQUEST['appid'];
			$appname = $_REQUEST['appname'];
			$appver = $_REQUEST['appver'];
			$domain = $_REQUEST['domain'];
			$dir = $_REQUEST['dir'];
			if(strstr($dir,"..")!=""){
				die("安装目录不合法");
			}
			$phy_dir = apicall('webapp','getPhyDir',array(getRole('vhost'),$domain,$dir));
			if(!$phy_dir){
				die("不能得到物理路径");
			}
			daocall('vhostwebapp','add',array(getRole('vhost'),$appid,$appname,$appver,$domain,$dir,$phy_dir));
			//echo "phy_dir=".$phy_dir;
		}
	}
	public function uninstall()
	{
		$id = $_REQUEST['id'];
		$app = daocall('vhostwebapp','getapp',array($id,getRole('vhost')));
		if(!$app){
			die("没有该程序");
		}
		//TODO:uninstall the app
		daocall('vhostwebapp','remove',array($id,getRole('vhost')));
		return $this->index();
	}
	
}
?>
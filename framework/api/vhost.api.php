<?php
class VhostAPI extends API
{
	public function noticeChange($node,$name)
	{
		$whm = apicall('nodes','makeWhm',array($node));
		$whmCall = new WhmCall('core.whm','reload_vh');
		$whmCall->addParam('name', $vhost);
		if(!$whm->call($whmCall)){
			return false;
		}
		return true;
	}

}
?>
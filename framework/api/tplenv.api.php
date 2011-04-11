<?php
define(ENV_CHECK_FAILED,0);
define(ENV_CHECK_SUCCESS,1);
define(ENV_CHECK_NOT_FOUND,2);
class TplenvAPI extends API
{
	public function __construct()
	{
		parent::__construct();
		@load_conf('pub:tplenv');
	}
	public function hasEnv($templete,$subtemplete)
	{
		if (count($GLOBALS['tplenv'][$templete])>0) {
			return true;
		}
		if (count($GLOBALS['tplenv'][$templete.':'.$subtemplete])>0) {
			return true;
		}
		return false;
	}
	public function getEnv($templete,$subtemplete)
	{
		$env = @array_merge((array)$GLOBALS['tplenv'][$templete],(array)$GLOBALS['tplenv'][$templete.':'.$subtemplete]);
		return $env;
	}
	public function setEnv($vhost,$templete,$subtemplete,$name,$value)
	{
		$ret = $this->checkEnv($name,$value,(array)$GLOBALS['tplenv'][$templete.':'.$subtemplete]);
		if($ret == ENV_CHECK_NOT_FOUND){
			$ret = $this->checkEnv($name,$value,(array)$GLOBALS['tplenv'][$templete]);
		}
		//echo "name=".$name." ret=".$ret;
		if($ret!=ENV_CHECK_SUCCESS){
			trigger_error('参数值:'.$value.'不合法');
			return false;
		}
		return apicall('vhost','addInfo',array($vhost,$name,100,$value,false));
	}	
	private function checkEnv($name,$value,$arr)
	{
		for($i=0;$i<count($arr);$i++){
			//echo $arr[$i]['name'];
			if($arr[$i]['name'] == $name){
				switch($arr[$i]['value'][0]){
					case 'TEXT':
						//echo 'patten='.$arr[$i]['value'][1]." value=".$value;
						if(preg_match($arr[$i]['value'][1], $value)){
							return ENV_CHECK_SUCCESS;
						}
						return ENV_CHECK_FAILED;
					case 'RADIO':
						for($n=0;$n<count($arr[$i]['value'][1]);$n++){
							if($value==$arr[$i]['value'][1][$n][1]){
								return ENV_CHECK_SUCCESS;
							}
						}
						return ENV_CHECK_FAILED;
					default:
						return ENV_CHECK_FAILED;
				}
			}
		}
		return ENV_CHECK_NOT_FOUND;
	}
}
?>
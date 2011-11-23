<?php
//define(WHM_CALL_METHOD, 'GET');
define(WHM_CALL_METHOD, 'POST');
class WhmCall
{
	public function __construct($callName)
	{
		$this->callName = $callName;
	}
	public function addParam($name,$value)
	{
		if($this->url!=""){
			$this->url.='&';
		}
		$this->url.=$name."=".urlencode($value);
	}
	public function getCallName()
	{
		return $this->callName;
	}
	public function buildUrl($skey)
	{
		$r = rand();
		$src = $this->callName.$skey.$r;
		$s = md5($src);
		return  "api/?c=whm&a=".$this->callName."&r=".$r."&s=".$s;
	}
	public function buildPostData()
	{
		return $this->url;
	}
	private $callName = '';
	private $url = '';
}
class WhmResult
{
	public function add($name,$value)
	{
		$this->result[$name][] = $value;
	}
	public function get($name,$index=0)
	{
		$value = $this->result[$name];
		return $value[$index];
	}
	public function getAll($name)
	{
		return $this->result[$name];
	}
	public function getCode()
	{
		return intval($this->status);
	}
	public $status = '';
	private $result = array();
}
class WhmClient
{
	public function setSecurityKey($skey)
	{
		$this->skey = $skey;
	}
	public function setAuth($user,$password)
	{
		//$this->auth = "Basic ".base64_encode($user.":".$password);
	}
	public function setUrl($url)
	{
		$this->whm_url = $url;
	}
	/*
	failed return false.otherwise return WhmResult
	*/
	public function call(WhmCall $call,$tmo=0)
	{	
		$this->result = array();
		//echo "whm call=".$call->getCallName().",tmo=".$tmo."<br>";
		$opts = array(
		'http'=>array(
			'method'=>WHM_CALL_METHOD
			//'header'=>"Authorization: ".$this->auth."\r\n"
			)
		);
		if (WHM_CALL_METHOD=='POST') {
			$opts['http']['content'] = $call->buildPostData();
		}
		if ($tmo>0) {
			$opts['http']['timeout'] = $tmo;
		}
		$url = $this->whm_url.$call->buildUrl($this->skey);
		if (WHM_CALL_METHOD!='POST') {
			$url.='&'.$call->buildPostData();
		}
		$msg = @file_get_contents($url, false, stream_context_create($opts)); 
		if($msg === FALSE){
			$this->err_msg = "cann't connect to host";
			return false;
		}
		try{
			$xml = new SimpleXMLElement($msg);
			//print_r($xml);
			$result = new WhmResult;
			foreach($xml->children() as $child){
				if($child->getName()=='result'){				
					$result->status = $child['status'];
					foreach($child->children() as $node)
					{
						$result->add($node->getName(), $node[0]);
					}
					break;
				}
			}		
			return $result;
		} catch (Exception $e) {
			echo "msg=".$msg."<br>***********\n";
			return null;
		}
	}
	public function get($name,$index=0)
	{
		$value = $this->result[$name];
		if(!$value){
			return false;
		}
		if($index>=count($value)){
			return false;
		}
		return $value[$index];
	}
	public function setParam($name,$value)
	{
	}
	public function getLastError()
	{
		return $this->err_msg;
	}
	public $skey = '';
	//public $auth='';
	public $whm_url='';
	public $err_msg='';
	private $result;
}
?>

<?php
class WhmCall
{
	public function WhmCall($package,$callName)
	{
		$this->package = $package;
		$this->callName = $callName;
	}
	public function addParam($name,$value)
	{
		$this->params[$name] = $value;
	}
	public function getCallName()
	{
		return $this->callName;
	}
	public function buildUrl()
	{
		//print_r($this->params);
		$url = $this->package."?whm_call=".$this->callName;
		if($this->params){
			reset($this->params);
			while (list($name, $val) = each($this->params)) {
				$url.="&".$name."=".urlencode($val);
			}
		}
		return $url;
	}
	private $callName = '';
	private $package = '';
	private $params = array();
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
	private $status = '';
	private $result = array();
}
class WhmClient
{
	public function setAuth($user,$password)
	{
		$this->auth = "Basic ".base64_encode($user.":".$password);
	}
	public function setUrl($url)
	{
		$this->whm_url = $url;
	}
	/*
	failed return false.otherwise return WhmResult
	*/
	public function call(WhmCall $call)
	{	
		$this->result = array();
		$opts = array(
		'http'=>array(
			'header'=>"Authorization: ".$this->auth."\r\n")
		);
		$url = $this->whm_url.$call->buildUrl();
		//echo $url;
		$msg = @file_get_contents($url, false, stream_context_create($opts));   
		if($msg === FALSE){
			$this->err_msg = "cann't connect to host";
			return false;
		}
		$whm = new DOMDocument();
		//echo "<br>".$msg."<br>***********\n";
		if(!$whm->loadXML($msg)){
			$this->err_msg = "cann't parse whm xml";
			return false;
		}
		$result_node = $whm->getElementsByTagName("result")->item(0);
		$status = $result_node->attributes->getNamedItem("status")->nodeValue;//->childNodes;
		//echo "status=".$status;
		if(intval($status)!=200){
			$this->err_msg = $status;
			return false;
		}
		$nodes = $result_node->childNodes;
		$result = new WhmResult;
		for($i=0;;$i++){
			$node = $nodes->item($i);
			if(!$node){
				break;
			}
			if($node->nodeType!=1){
				continue;
			}
			$result->add($node->nodeName, $node->nodeValue);
		}
		return $result;
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
	public $auth='';
	public $whm_url='';
	public $err_msg='';
	private $result;
}
?>

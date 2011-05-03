<?php
class WebappAPI extends API
{
	public function getinfo($appid)
	{
		$url = "http://webapp.kanglesoft.com/info.php?appid=".$appid;
		$opts = array(
		'http'=>array(
			'method'=>"GET",
			'timeout'=>10
		));
		$msg = @file_get_contents($url, false, stream_context_create($opts));   
		if($msg === FALSE){
			$this->err_msg = "cann't connect to host";
			return false;
		}
		$whm = new DOMDocument();
		echo "<br>".$msg."<br>***********\n";
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
		$result = array();
		for($i=0;;$i++){
			$node = $nodes->item($i);
			if(!$node){
				break;
			}
			if($node->nodeType!=1){
				continue;
			}
			$result[$node->nodeName] = $node->nodeValue;
			//$result->add($node->nodeName, $node->nodeValue);
		}
		print_r($result);
		return $result;
	}
}
?>
<?php
class HttpAPI extends API{
	/**
	 * 构造函数
	 **/
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * 析构函数 **/
	public function __destruct()
	{
		parent::__destruct();
	}
	public function get_url_content($url) {
		if(!function_exists('file_get_contents')) {
			$file_contents = file_get_contents($url);
		}else{
			$ch = curl_init();
			$timeout = 5; 
			curl_setopt ($ch, CURLOPT_URL, $url);
			curl_setopt ($ch, CURLOPT_POST, 1);//启用POST提交
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
			curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
			$file_contents = curl_exec($ch);
			curl_close($ch);
		}
		return $file_contents;
	}
	public function httpRequest($url, $post_string, $method="post", $connectTimeout=1, $readTimeout=4, &$arrError=null)
	{
		$method = strtolower($method);
		if($method == "get") {
			$url = $url."?".$post_string;
		}
		$result = "";
		if (function_exists('curl_init')) {
			$timeout = $connectTimeout + $readTimeout;
			// Use CURL if installed...
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connectTimeout);
			curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
			curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_0);
			if($method == "post") {
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
			}
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'API PHP5 Client (curl) ' . phpversion());
			$result = curl_exec($ch);
			curl_close($ch);
		} else {
			// Non-CURL based version...
			$result = $this->socketPost($url, $post_string, $method, $connectTimeout, $readTimeout);
		}
		return $result;
	}
	/**
	 * http post
	 */
	public function socketPost($url, $post_string, $method="post", $connectTimeout=1, $readTimeout=2){
		$urlInfo = parse_url($url);
		$urlInfo["path"] = ($urlInfo["path"] == "" ? "/" : $urlInfo["path"]);
		$urlInfo["port"] = ($urlInfo["port"] == "" ? 80 : $urlInfo["port"]);
		$hostIp = gethostbyname($urlInfo["host"]);

		$urlInfo["request"] =  $urlInfo["path"]	. 
			(empty($urlInfo["query"]) ? "" : "?" . $urlInfo["query"]) . 
			(empty($urlInfo["fragment"]) ? "" : "#" . $urlInfo["fragment"]);

		$fsock = fsockopen($hostIp, $urlInfo["port"], $errno, $errstr, $connectTimeout);
		if (false == $fsock) {
			return false;
		}
		if($method == "get") {
			$post_string = "";
		}
		/* begin send data */
		$in = "POST " . $urlInfo["request"] . " HTTP/1.0\r\n";
		$in .= "Accept: */*\r\n";
		$in .= "User-Agent: API PHP5 Client (non-curl)\r\n";
		$in .= "Host: " . $urlInfo["host"] . "\r\n";
		$in .= "Content-type: application/x-www-form-urlencoded\r\n";
		$in .= "Content-Length: " . strlen($post_string) . "\r\n";
		$in .= "Connection: Close\r\n\r\n";
		$in .= $post_string . "\r\n\r\n";

		stream_set_timeout($fsock, $readTimeout);
		if (!fwrite($fsock, $in, strlen($in))) {
			fclose($fsock);
			return false;
		}
		unset($in);

		//process response
		$out = "";
		stream_set_timeout($fsock, $readTimeout);
		while ($buff = fgets($fsock, 4096)) {
			$out .= $buff;
		}
		//finish socket
		fclose($fsock);
		$pos = strpos($out, "\r\n\r\n");
		$head = substr($out, 0, $pos);		//http head
		$status = substr($head, 0, strpos($head, "\r\n"));		//http status line
		$body = substr($out, $pos + 4, strlen($out) - ($pos + 4));		//page body
		if (preg_match("/^HTTP\/\d\.\d\s([\d]+)\s.*$/", $status, $matches)) {
			if (intval($matches[1]) / 100 == 2) {//return http get body
				return $body;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}
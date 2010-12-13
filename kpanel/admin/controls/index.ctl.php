<?php
class IndexControl extends Control
{
	public function __construct()
	{
		parent::__construct();
		/*
		$user = '1';
		$pwd = '1';
		if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW']) ||
		           $_SERVER['PHP_AUTH_USER'] != $user ||$_SERVER['PHP_AUTH_PW'] != $pwd) {
				Header("WWW-Authenticate: Basic realm=\"kpanel Admin Login\"");
				Header("HTTP/1.0 401 Unauthorized");
				echo '<html><body>
					<h1>Rejected!</h1>
					<big>Wrong Username or Password!</big>
					</body></html>';
				exit;
		}
		*/
	}

	public function __destruct()
	{
		parent::__destruct();
	}
	public function index()
	{
		$this->_tpl->display('kpanel.html');
	}
	public function top()
	{
		$this->_tpl->display('top.html');
	}
	public function controltop()
	{
		$this->_tpl->display('controltop.html');
	}
	public function left()
	{
		$this->_tpl->display('left.html');
	}
	public function controlleft()
	{
		$this->_tpl->display('controlleft.html');
	}
	public function main()
	{
		$this->_tpl->display('kfinfo.html');
	}
}
?>
<?php
class UserAPI extends API
{
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

	public function &getUser($uid = 0)
	{
	
	}
	public function insertUser($arr = array())
	{
		$ret = daocall('user','insertUser',array($arr));
		return $ret;
	}
	public function findPasswd($username,$email)
	{
		$user_info = daocall('user','getUser',array($username));
		if (!$user_info) {
			return '2';
		}
		if ($user_info['email'] == ""){
			return '3';
		}
		if (md5($user_info['email']) != md5($email)) {
			return '4';
		}
		$passwd = getRandPasswd(8);
		$file = '../file/findpasswd.html'; 
		if (file_exists($file)) {
			$body = file_get_contents($file);
		}else{
			$body = "您的新密码为:{{passwd}}<br>";
			$body .= "欢迎使用本网产品，<a href='http://www.kanglesoft.com/' target=_blank>http://www.kanglesoft.com/</a>";
		}
		$body = str_replace('{{passwd}}', $passwd, $body);
		$subject = $username."密码找回";
		$address[] = $user_info['email'];
		$mail_result = apicall('mail','sendMail',array($address,$subject,$body));
		if ($mail_result !== false) {
			daocall('user','updatePassword',array($username,$passwd));
			return '0';
		}
		return '1';
	}
}
?>

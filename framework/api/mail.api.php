<?php 
include dirname(__FILE__).'/../../plugin/phpmailer/class.phpmailer.php';
class MailAPI extends API
{
	public function sendAdMail()
	{
		$mail = $this->getMail();
		if ($mail === false) {
			return false;
		}
		$mails = daocall('user','getAllMail',array());
		foreach ($mails as $a ) {
			$address[]=trim($a['email'],',');
		}
		$setting = daocall('setting','getAll2',array());
		$subject = $setting['mail_ad_subject'];
		$body = $setting['mail_ad_body'];
		if($this->sendMail($address, $subject, $body))
		{
			echo "sendmail is success\r\n";
		}else{
			echo "sendmail is failed\r\n";
		}
	}
	/**
	 * 
	 * Enter description here ...
	 * @param  array  $address  一唯数组
	 * @param  string $subject 
	 * @param  string $body 
	 * @param  bool   $smtpauth 
	 */
	public function sendMail($address,$subject,$body,$smtpauth=true)
	{
		$mail = $this->getMail();
		if ($mail === false) {
			return false;
		}
		foreach ($address as $a) {
			$mail->AddAddress($a);
		}
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->SMTPAuth = $smtpauth;
		return $mail->Send();
	}
	private function getMail()
	{
		if(!class_exists('PDO')){
			die("can't find PDO extend\r\n");
		}
		$setting = daocall('setting','getAll2',array());
		$mail_smtp = $setting['mail_smtp'];
		$from = $setting['mail_from'];
		$fromname = $setting['mail_fromname'];
		$mail = new PHPMailer();
		if (!$mail) {
			return false;
		}
		$mail->CharSet = "utf-8";
		$mail->From = $from;
		$mail->FromName= $fromname;
		$mail->ContentType = 'text/html';
		if ($mail_smtp == 1) {
			$host = $setting['mail_host'];
			$username = $setting['mail_username'];
			$passwd = $setting['mail_passwd'];
			
			$port = $setting['mail_port'] ? $setting['mail_port'] : '25';
			$secure = $setting['secure'] ? $setting['secure'] : 'ssl';
			
			if (!$host || !$username || !$passwd) {
				echo "mail host or username or passwd net set\r\n";
				return false;
			}
			$mail->IsSMTP();
			$mail->SMTPSecure = $secure;
			$mail->SMTPDebug = 1;
			$mail->Host = $host;
			$mail->Username = $username;
			$mail->Password = $passwd;
			$mail->Port = $port;
		}
		return $mail;
		
	}
	public function sendExMail()
	{
		$day = '-7';
		//get expire vhosts
		$exvhs = daocall('vhost','selectListByExpire_time',array($day));
		if (count($exvhs) < 0) {
			echo "nothing vh need sendMail\r\n";
			return false;
		}
		echo count($exvhs)." vh need send\r\n<br>";
		$setting = daocall('setting','getAll2',array());
		$subject = $setting['mail_subject'];
		$body = $setting['mail_body'];
		if (!$subject || !$body) {
			exit("mail subject or body not set\r\n");
		}
//		$where = 'username IN ( SELECT `name` FROM vhost WHERE';
//		$where .= ' expire_time < ADDDATE( curdate( ) , INTERVAL 7 DAY ) AND `status` =0)';
//		$email = daocall('user','getAllMail',array($where));
		foreach ($exvhs as $vh) {
			$mail = $this->getMail();
			if ($mail === false) {
				return false;
			}
			$subject2 = $this->MyReplace($subject, $vh['username'], $vh['name']);
			$body2 = $this->MyReplace($body, $vh['username'], $vh['name']);
			$userinfo = daocall('user','getUser',array($vh['username']));
			if ($userinfo['email'] == "") {
				echo $vh['username']." email is empty\r\n<br>";
				continue;
			}
			$mail->AddAddress($userinfo['email']);
			$mail->Subject = $subject2;
			$mail->Body = $body2;
			$mail->SMTPAuth = true;
			if (!$mail->Send()) {
				echo $userinfo['email']." sendmail failed<br>\r\n";
				continue;
			}
			echo $userinfo['email']." sendmail success<br>\r\n";
		}
		
	}
	private function MyReplace($str,$user,$vhost)
	{
		$find_user = "{{user}}";
		$find_vhost = "{{vhost}}";
		$str = str_ireplace($find_user,$user,$str);
		$str = str_ireplace($find_vhost,$vhost , $str);
		return $str;
	}
	
}





<?php 
include dirname(__FILE__).'/../../plugin/phpmailer/class.phpmailer.php';
class MailAPI extends API
{
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
		$setting = daocall('setting','getAll2',array());
		$mail_smtp = $setting['mail_smtp'];
		$mail = new PHPMailer();
		if (!$mail) {
			return false;
		}
		$mail->CharSet = "utf-8";
		if ($mail_smtp == 1) {
			$host = $setting['mail_host'];
			$username = $setting['mail_username'];
			$passwd = $setting['mail_passwd'];
			$from = $setting['mail_from'];
			$fromname = $setting['mail_fromname'];
			$port = $setting['mail_port'] ? $setting['mail_port'] : '25';
			$secure = $setting['secure'] ? $setting['secure'] : 'ssl';
			
			if (!$host || !$username || !$passwd) {
				return false;
			}
			$mail->IsSMTP();
			$mail->SMTPSecure = $secure;
			$mail->SMTPDebug = 1;
			$mail->Host = $host;
			$mail->Username = $username;
			$mail->Password = $passwd;
			$mail->Port = $port;
			$mail->From = $from;
			$mail->FromName= $fromname;
		}
		return $mail;
		
	}
	public function sendExMail()
	{
		$mail = $this->getMail();
		if ($mail === false) {
			return false;
		}
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
			$subject2 = $this->MyReplace($subject, $vh['username'], $vh['name']);
			$body2 = $this->MyReplace($body, $vh['username'], $vh['name']);
			$userinfo = daocall('user','getUser',array($vh['username']));
			if($userinfo['email']=="") {
				echo $vh['username']." email is empty\r\n<br>";
				continue;
			}
			$mail->AddAddress($userinfo['email']);
			$mail->Subject = $subject2;
			$mail->Body = $body2;
			$mail->SMTPAuth = true;
			if (!$mail->Send()) {
				echo $userinfo['email']." 发送失败<br>\r\n";
				continue;
			}
			echo $userinfo['email']."发送成功<br>\r\n";
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





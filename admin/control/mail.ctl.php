<?php
needRole('admin');
class MailControl extends control
{
	public function send()
	{
		$subject = $_REQUEST['mail_subject'];
		$body = $_REQUEST['mail_body'];
		daocall('setting','add',array('mail_ad_subject',$subject));
		daocall('setting','add',array('mail_ad_body',$body));
		if (!$subject) {
			die("邮件标题未设置");
		}
		if ($_REQUEST['address']) {
			$address = explode(',', $_REQUEST['address']);
			
		}else{
			$mails = daocall('user','getAllMail',array());
			foreach ($mails as $a ) {
				$address[]=trim($a['email'],',');
			}
		}
		if (count($address) < 0 ) {
			die("nothing address need Send");
		}
		if (!apicall('mail','sendMail',array($address,$subject,$body))) {
			die("发送失败");
		}
		die("发送成功");
	}
	public function sendMailFrom()
	{
		return $this->_tpl->fetch('mail/send.html');
	}

	public function mailFrom()
	{
		$setting = daocall('setting','getAll2',array());
		if($setting['mail_body']){
			$mail_body = $setting['mail_body'];
			$mail_subject = $setting['mail_subject'];
		}else{
			$mail_body = "尊敬的{{user}}客户: 您在本网购买的{{vhost}}产品还有七天到期，为了不影响您的产品使用，请及时续费.";
			$mail_subject = "尊敬的{{user}}客户: 您在本网购买的{{vhost}}产品还有七天到期";
		}
		$this->_tpl->assign('mail_body',$mail_body);
		$this->_tpl->assign('mail_subject',$mail_subject);
		
		$this->_tpl->assign('setting',$setting);
		return $this->_tpl->fetch('mail/index.html');
	}
	public function setMail()
	{
		daocall('setting','add',array('set_mail',$_REQUEST['set_mail']));
		daocall('setting','add',array('mail_smtp',$_REQUEST['mail_smtp']));
		if ($_REQUEST['mail_username']) {
			daocall('setting','add',array('mail_username',$_REQUEST['mail_username']));
		}
		if ($_REQUEST['mail_host']) {
			daocall('setting','add',array('mail_host',$_REQUEST['mail_host']));
		}
		if ($_REQUEST['mail_port']) {
			daocall('setting','add',array('mail_port',$_REQUEST['mail_port']));
		}
		if ($_REQUEST['mail_secure']) {
			daocall('setting','add',array('mail_secure',$_REQUEST['mail_secure']));
		}
		if ($_REQUEST['mail_passwd']) {
			daocall('setting','add',array('mail_passwd',$_REQUEST['mail_passwd']));
		}
		if ($_REQUEST['mail_from']) {
			daocall('setting','add',array('mail_from',$_REQUEST['mail_from']));
		}
		if ($_REQUEST['mail_fromname']) {
			daocall('setting','add',array('mail_fromname',$_REQUEST['mail_fromname']));
		}
		if ($_REQUEST['mail_subject']) {
			daocall('setting','add',array('mail_subject',$_REQUEST['mail_subject']));
			daocall('setting','add',array('mail_body',$_REQUEST['mail_body']));
		}
		return $this->mailFrom();
	}
}
?>
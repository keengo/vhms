<?php
needRole('admin');
class MailControl extends control
{
	public function send()
	{
		$subject = $_REQUEST['subject'];
		$body = $_REQUEST['body'];
		$address = $_REQUEST['address'];
		$smtpauth = false;
		if (!apicall('mail','sendMail',array($address,$subject,$body,$smtpauth))) {
			echo "发送失败";
			exit;
		}
		echo "发送成功";
	}
	public function mailFrom()
	{
		$setting = daocall('setting','getAll2',array());
		$this->_tpl->assign('setting',$setting);
		return $this->_tpl->fetch('mail/index.html');
	}
	public function setMail()
	{
		if ($_REQUEST['mail_username']) {
			daocall('setting','add',array('mail_username',$_REQUEST['mail_username']));
		}
		if ($_REQUEST['mail_host']) {
			daocall('setting','add',array('mail_host',$_REQUEST['mail_host']));
		}
		if ($_REQUEST['mail_passwd']) {
			daocall('setting','add',array('mail_passwd',$_REQUEST['mail_passwd']));
		}
		if ($_REQUEST['mail_from']) {
			daocall('setting','add',array('mail_from',$_REQUEST['mail_from']));
		}
		if($_REQUEST['mail_fromname']) {
			daocall('setting','add',array('mail_fromname',$_REQUEST['mail_fromname']));
		}
		if($_REQUEST['mail_smtp']) {
			daocall('setting','add',array('mail_smtp',$_REQUEST['mail_smtp']));
		}
		if ($_REQUEST['templete']) {
			$subjcet = $_REQUEST['templete'].'_subject';
			$body = $_REQUEST['templete'].'_body';
			daocall('setting','add',array($subjcet,$_REQUEST['subject']));
			daocall('setting','add',array($body,$_REQUEST['body']));
		}
		return $this->mailFrom();
	}
	public function test()
	{
		apicall('mail','sendExMail',array());
	}
	
}
?>
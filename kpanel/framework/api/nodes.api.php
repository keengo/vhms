<?php
class NodeAPI extends API
{
	private $MAP_ARR;
	/**
	 * ���캯��
	 **/
	public function __construct()
	{
		load_lib("pub:whm");
		parent::__construct();
		$this->MAP_ARR 	= array(		//�û���Ϣ��Ϣ�ֶζ��ձ�
			"name" => 'name',
			"username" => 'username',
			"ftpuser"=>'ftpuser',
			"ftppwd"=>'ftppwd',
		);
	}
	/**
	 * �������� 
	 **/
	public function __destruct()
	{
		parent::__destruct();
	}
	public function checkNodes($arr = array())
	{
		
		return $ret;
	}
	public function edit($arr = array())
	{
		
	}
}
?>

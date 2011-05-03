<?php
class VhostwebappDAO extends DAO
{
	public function __construct()
	{
		parent::__construct();
		$this->MAP_ARR 	= array(
			"id" => 'id',
			"user" => 'user',
			"appid"=> 'appid',
			"domain"=>'domain',
			"dir"=>'dir',
			'phy_dir'=>'phy_dir',
			"step"=>'step',
			'install_time'=>'install_time'
		);
		$this->MAP_TYPE = array(
			'id'=>FIELD_TYPE_AUTO,
			'step'=>FIELD_TYPE_INT,
			'install_time'=>FIELD_TYPE_DATETIME
			);
		$this->_TABLE = DBPRE . 'vhost_webapp';
	}
	public function add()
	{
		
	}
	public function getAll($user)
	{
		return $this->select(null,$this->getFieldValue2('user', $user),'rows');
	}
}
?>
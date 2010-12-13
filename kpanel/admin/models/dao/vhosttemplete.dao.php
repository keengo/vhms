<?php
class VhosttempleteDAO extends DAO {

	public function __construct()
	{	
		parent::__construct();
		$this->MAP_ARR 	= array(		
			"node" => 'node',
			"templete"=> 'templete',
			"weight"=>'weight',
			"state"=>'state'
		);
		$this->MAP_TYPE = array(
			'weight'=>FIELD_TYPE_INT,
			'state'=>FIELD_TYPE_INT,
		);
		$this->_TABLE = DBPRE . 'vhost_templete';
	}

}
?>
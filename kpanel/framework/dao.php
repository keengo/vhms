<?php
/**
 * 接口的基类
 *
 * @package core
 */
define('FIELD_TYPE_STRING',0);
define('FIELD_TYPE_INT',1);
define('FIELD_TYPE_MD5',2);
define('FIELD_TYPE_AUTO',1<<28);
class DAO
{
	protected $MAP_ARR = null;
	protected $MAP_TYPE = null;
	protected $_TABLE = null;
	public $db = null;
	function __construct()
	{
		load_lib("pub:db");
	}
	function __destruct()
	{
		
	}
	protected function connect()
	{
		global $default_db;
		if($this->db==null){
			if($default_db==null){
				$default_db = db_connect('default');
			}
			$this->db = $default_db;
		}
		return $this->db!=null;
	}
 	protected function executex($sql,$type="result") {
 		global $db_db;
 		$this->connect();
	 	$row = db_query($this->db,$sql,$type);
		return $row;
	}
	/**
	 * 执行sql语句
	 * @param String host 	    主机
	 * @param String dbname 	数据库名称
	 * @param String sql		sql语句
	 * @param String type		执行类型。row:单条查询；rows:多条查询；result:执行动作
	 */
 	protected function execute($host='vip',$dbname='kpanel',$sql,$type="result") {
	 	$this->connect();
		$row = db_query($this->db,$sql,$type);
		return $row;
	}
	public function delData($where)
	{
		$sql = "DELETE FROM ".$this->_TABLE;
		if($where && $where!=""){
			$sql.=' WHERE '.$where;
		}
		$sql.=" LIMIT 1";
		return $this->executex($sql);
	}
	public function getData($where='',$type='rows')
	{
		$tbl = $this->_TABLE;
		$sql = "SELECT ".$this->AllQueryFields()." FROM {$tbl}";
		if($where!=''){
			$sql.=' WHERE '.$where;
		}
		return $this->executex($sql, $type);
	}
	public function getData2($fields,$where='',$type='rows')
	{
		$tbl = $this->_TABLE;
		$sql = "SELECT ".$this->queryFields($fields)." FROM {$tbl}";
		if($where!=''){
			$sql.=' WHERE '.$where;
		}
		return $this->executex($sql, $type);
	}
	public function insertData(&$arr)
	{
		$fields  = "";
		$values	 = "";
		foreach($arr as $key=>$value) {
			if(!array_key_exists($key,$this->MAP_ARR)){
				 continue;
			}
			if($this->MAP_TYPE!=null && ($this->MAP_TYPE[$key] & FIELD_TYPE_AUTO)){
				continue;
			}
			if($fields!=""){
				$fields.=",";
				$values.=",";
			}
			$fields .= $this->MAP_ARR[$key];
			$values .= $this->getFieldValue($key,$value);						
		}
		if(empty($fields) || empty($values)){
			return false;
		}
		$sql = "INSERT INTO ".$this->_TABLE." ({$fields}) VALUES ({$values})";
		return $this->executex($sql);
	}
	/**
	  * 插入数据库语句组装
	  * @param table 表名
	  * @param Array 插入数据
	  * @param Array 映射数组
	  */
	 protected function insertSql($table,&$infoAry,$mapArr) {
	 	$fields  = "";
		$values	 = "";
		foreach($infoAry as $key=>$value) {
			if(!array_key_exists($key,$mapArr) || $mapArr[$key][1] === 0)
				 continue;//映射不存在的数据，或禁止插入的数据屏蔽
			$fields .= $mapArr[$key].",";
			if($mapArr[$key] == 'ftppasswd'){
				$values	.= "password('$value'),";
			}else{
				$values	.= "'".$this->daddslashes($value)."',";
			}			
		}
		$fields  = trim($fields,',');
		$values  = trim($values,',');
		if(empty($fields) || empty($values))
			return false;
		$sql = "INSERT INTO {$table} ({$fields}) VALUES ({$values})";
		return $sql;
	 }
	protected function AllQueryFields() {
		$fieldstr = "";
		foreach($this->MAP_ARR as $field) {
			if($fieldstr!=""){
				$fieldstr.=',';
			}
			$fieldstr .= $this->MAP_ARR[$field]." AS ".$field;
		}
		return $fieldstr;
	}
	protected function queryFields(&$fields) {
		$fieldstr = "";
		foreach($fields as $field) {
			if($fieldstr!=""){
				$fieldstr.=',';
			}
			$fieldstr .= $this->MAP_ARR[$field]." AS ".$field;
		}
		return $fieldstr;
	}
	protected function getFields($fields,$array)
	{
		$fields_str = "";
		for($i=0;$i<count($fields);$i++){
			if($fields_str!=""){
				$fields_str.=",";
			}
			$fields_str.=$this->getFieldValue2($fields[$i],$array[$fields[$i]]);
		}
		return $fields_str;
	}
	/**
	  * 更新数据库字段组装
	  * @param Array updateAry	更新数组
	  * @param Array mapArr	映射数组
	  */
	 protected function updateFields(&$updateAry,&$mapArr) {
		$fields_str = "";
		foreach($updateAry as $field => $value) {
	 		if(!array_key_exists($field,$mapArr) || $mapArr[$field][2] === 0)
				 continue;//映射不存在的数据，不可更新的数据，pass
	 		$value		 = $this->daddslashes($value);
	 		$fields_str .= "{$mapArr[$field]} = ".$this->getFieldValue($field,$value).",";
	 	}
	 	$fields_str = trim($fields_str,",");
		return $fields_str;
	 }
	 protected function daddslashes($string, $force = 0) {
		!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
		if(!MAGIC_QUOTES_GPC || $force) {
			if(is_array($string)) {
				foreach($string as $key => $val) {
					$string[$key] = $this->daddslashes($val, $force);
				}
			} else {
				$string = addslashes($string);
			}
		}
		return $string;
	}
	protected function getFieldValue2($name,$value)
	{
		return $this->MAP_ARR[$name]."=".$this->getFieldValue($name,$value);
	}
	protected function getFieldValue($name,$value)
	{
		if($this->MAP_TYPE==null){
			return '\''.$value.'\'';
		}
		switch($this->MAP_TYPE[$name] & 0xFF){
			case FIELD_TYPE_INT:
				return intval($value);
			case FIELD_TYPE_MD5:
				return "'".md5($value)."'";
		}
		return '\''.$value.'\'';	
	}
}
?>

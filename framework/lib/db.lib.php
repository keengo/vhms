<?php
define("DB_DISCONNECT", 0);
define("DB_CONNECT", 1);
define("DB_ERROR", 2);
define("DBPRE","");


function db_connectx($driver,$host,$port,$dbname,$user,$passwd)
{
	$dsn = $driver.":host=".$host;
	if($port!=""){
		$dsn.=';port='.$port;
	}
	$dsn.=';dbname='.$dbname;
	//die("host=".$host." dsn=".$dsn);
	try{
		return new PDO($dsn,$user,$passwd,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	}catch(Exception $e){
		return false;
	}
}
function db_connect($host)
{
	global $db_cfg;
	$dlink = db_connectx(
	$db_cfg[$host]['driver'],
	$db_cfg[$host]['host'],
	$db_cfg[$host]['port'],
	$db_cfg[$host]['dbname'],
	$db_cfg[$host]['user'],
	$db_cfg[$host]['passwd']);
	if(!$dlink){
		die("无法连接数据库,请联系管理员!");
	}
	return $dlink;
}
/**
 * 数据库查询方法
 * sql		sql语句
 * ret_type	返回类型，result/row/rows/value
 **/
function db_query(PDO $db,$sql, $ret_type = 'result')
{
	
	/*$s = db_parsesql($sql);
	if(!$s){
		return false;
	}
	*/
	if($ret_type=='result'){
		$result = $db->exec($sql);
	}else{
		$result = $db->query($sql);
	}	
	if(!$result && $db->errorCode()>0)
	{
		//trigger_error('在MYSQL服务器端执行SQL语句失败.<br />SQL: ' . $sql . '<br />原因: '. $db->errorCode() . '<br />');
		return false;
	}
	switch($ret_type)
	{
		case "result":
			return $result;
			break;
		case "row":
			if($result){
				return $result->fetch();			
			} 
			return false;
		case "rows":
			if($result ){
				return $result->fetchAll(PDO::FETCH_ASSOC);			
			}
			return false;

		default:
			trigger_error(__FUNCTION__ . " unknowd query type");
			return false;
	}
}

/**
 * SQL分页查询助手，适用单表查询
 *
 * @param string SQL语句
 * @param int 页号
 * @param int 每页记录数
 * @param int 总记录数(如果提供该值，将不会重复统计)
 * @return array 含义如下：
 *		total: 总记录数
 *		pages: 总页数
 *		page: 当前页数
 *		rows: 数据库结果集数组
 */
function db_pages($sql, $page = 1, $page_size = 10, $total = null)
{
	$retval = array(
		"total" => 0,
		"pages" => 1, 
		"page" => $page, 
		"rows" => array()
	);
	$dbenv = &db_get_env();
	$db = &$dbenv['dbconf'][$dbenv['host']];

	//将SELECT查询转换为查询统计语法
	if(preg_match("/^([\s]*SELECT[\s]+)([\s\S]+)([\s]+FROM[\s]+[\s\S]+[\s]+WHERE[\s]+[\s\S]+[\s]*)$/i", $sql, $matches))
	{
		$parsesql = array();
		$parsesql['cmd'] = "SELECT";
		$parsesql['begin'] = $matches[1];
		$parsesql['body'] = $matches[3];
		$parsesql['end'] = '';
	}
	else
	{
		trigger_error('SQL语法解析失败<br/>SQL: ' . $sql . '<br/>');
		return false;
	}

	if(is_null($total) || !is_numeric($total))
	{
		//获得总记录数
		$tmp_body = preg_replace("/[\s]+ORDER[\s]+BY[\s\S]+$/i", '', $parsesql['body']);
		$sql2 = $parsesql['begin'] . "COUNT(*)" . $tmp_body . $parsesql['end'];
		$ret = db_query($sql2, "value");
		if($ret === false && is_numeric($ret))
		{
			trigger_error('记录总数统计失败<br/>SQL: ' . $sql . '<br/>');
			return false;
		}
		else
		{
			$retval['total'] = $ret;
		}
	}
	else
	{
		$retval['total'] = $total;
	}
	$retval['pages'] = ceil($retval['total'] / $page_size);

	if($retval['total'] > 0)
	{
		//获得结果集
		$sql2 = $sql . " LIMIT " . (($retval['page'] - 1) * $page_size) . ", " . $page_size;
		$retval['rows'] = db_query($sql2, "rows");
		unset($sql, $sql2);
	}

	return $retval;
}
//debug
function db_debug()
{

}

//mysql escape string
function db_escape($text)
{
	$text = str_replace("&", "&amp;", $text);
	$text = str_replace("<", "&lt;", $text);
	$text = str_replace(">", "&gt;", $text);
	$text = str_replace("'", "&apos;", $text);
	$text = str_replace("\"", "&quot;", $text);
}

function db_close($host = null)
{

}
//close all database;
function db_closeall()
{
	

}
function db_closeHostServer($host)
{

}
?>

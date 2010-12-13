<?php
define("DB_DISCONNECT", 0);
define("DB_CONNECT", 1);
define("DB_ERROR", 2);
define("DBPRE","");
function __db_config_comm()
{
	global $db_host,$db_user,$db_passwd,$db_db;
	$cfg = array('host'=>'vip','ip'=>$db_host, 'dbuser'=>$db_user, 'dbpass'=>$db_passwd, 'dbname'=>$db_db);
	return $cfg;
}
function __db_md5($hash_id)
{
	$hash = "db_".$hash_id;
	$md5val = md5($hash);
	$sub = substr($md5val, 0, 1);
	return $sub;
}

function __db_table_hash($hash_id)
{
	if(!$hash_id || $hash_id <= 0 ) {
		return false;
	}
	$md5_id = md5("db_".$hash_id);
	return hexdec(substr($md5_id, 1, 2)) % 32;
}
function db_connect()
{
	$dbenv = &db_get_env();
	//清空最后一次数据库操作的环境变量
	$dbenv['host'] = '';
	$dbenv['dbname'] = '';

	for($i = 0; $i < func_num_args(); $i++)
	{
		$dbenv['params'][$i] = func_get_arg($i);
	}
	$dbenv['host'] = $dbenv['params'][0];
	
	if($dbenv['host'] == 'mysql'){
		$db_config = __db_config_mysql();
	}else{
		$db_config = __db_config_comm();
	}
	
	if($dbenv['host'] == ''){
		$dbenv['host'] = $db_config['host'];
	}
	if($dbenv['dbname'] == ''){
		$dbenv['dbname'] = $db_config['dbname'];
	}
	db_connect_server($dbenv['host'], $db_config['ip'], $db_config['dbuser'],$db_config['dbpass']);

	$db = &$dbenv['dbconf'][$dbenv['host']];

	if($db['state'] === DB_CONNECT && is_resource($db['link']))
	{
		//复用当前服务器连接
		return $db['link'];

	}
	elseif($db['link'] = mysql_connect($db['ip'], $db['user'], $db['pwd']))
	{
		$db['state'] = DB_CONNECT;
		$dbenv['state']['CONNET_TIMES']++;
		return $db['link'];

	}
	else
	{
		//数据库打开失败
		trigger_error('无法打开数据库: <font color="blue"' . $db['user'] . '@' . $db['host']);
		return false;






	}
}

//添加服务器配置信息
function db_connect_server($host, $ip, $user, $pwd,$desc='')
{
	$dbenv = &db_get_env();
	if(isset($dbenv['dbconf'][$host]))
	{
		//exists
		return;
	}
	else
	{
		//add one
		$dbenv['dbconf'][$host]['host'] = $host;
		$dbenv['dbconf'][$host]['ip'] = $ip;
		$dbenv['dbconf'][$host]['user'] = $user;
		$dbenv['dbconf'][$host]['pwd'] = $pwd;
		$dbenv['dbconf'][$host]['link'] = null;
		$dbenv['dbconf'][$host]['state'] = DB_DISCONNECT;
		return;
	}
}

function &db_get_env()
{
	if(!isset($GLOBALS['DB_ENV']))
	{
		$GLOBALS['DB_ENV'] = array();
		$GLOBALS['DB_ENV']['state']['QUERY_TIMES'] = 0;
		$GLOBALS['DB_ENV']['state']['CONNET_TIMES'] = 0;
		$GLOBALS['DB_ENV']['state']['CLOSE_TIMES'] = 0;
	}
	return $GLOBALS['DB_ENV'];
}
// 选择指定数据库
function db_use($dbname)
{
	$dbenv = &db_get_env();
	if(!is_null($dbname))
	{
		if(empty($dbname))
		{
			trigger_error('无效的参数!');	
			return false;
		}
		else
		{
			$dbenv['dbname'] = $dbname;
		}
	}

	$db = &$dbenv['dbconf'][$dbenv['host']];
	if($db['state'] == DB_CONNECT)
	{
		//打开数据库
		$ret = mysql_select_db($dbenv['dbname'], $db['link']);
		if($ret)
		{
			mysql_query("set names utf8", $db['link']);
			return true;
		}
		else
		{
			trigger_error('切换数据库失败:' . $dbenv['host'] . ', ' . mysql_error());
			return false;
		}
	}
	else
	{
		trigger_error('与数据库服务器连接断开: ' . $dbenv['real_database']);
		return false;
	}
}

/**
 * 数据库查询方法
 * sql		sql语句
 * ret_type	返回类型，result/row/rows/value
 **/
function db_query($sql, $ret_type = 'result',$index_field = NULL)
{
	$dbenv = &db_get_env();
	$db = &$dbenv['dbconf'][$dbenv['host']];
	
	$dbenv['state']['QUERY_TIMES']++;

	$dbenv['sql'] = db_parsesql($sql);
	if(!$dbenv['sql']) return false;

	if(defined('DB_SHOW')) echo $dbenv['sql'];

	$result = mysql_query($dbenv['sql'], $db['link']);
	
	if(!$result)
	{
		trigger_error('在MYSQL服务器端执行SQL语句失败.<br />SQL: ' . $sql . '<br />原因: '. mysql_error($db['link']) . '<br />');
		return false;
	}

	if($dbenv['sql_cmd'] == "SELECT")
	{
		switch($ret_type)
		{
			case "result":
				return $result;
				break;

			case "row":
				if($result && mysql_num_rows($result) == 1)
				{
					return mysql_fetch_assoc($result);
				} else if($result && mysql_num_rows($result) != 1){
					return array();
				} else {
					return false;
				}
				break;

			case "rows":
				if($result && mysql_num_rows($result) >= 1)
				{
					$rows = array();
					while($row = mysql_fetch_assoc($result))
					{
						$rows[] = $row;
					}
					unset($row);
					return $rows;
					
				} elseif($result && mysql_num_rows($result) < 1) {
					
					return array();
				}
				else
				{
					return false;
				}
				break;

			case "value":
				if($result && mysql_num_rows($result) == 1)
				{
					$row = mysql_fetch_row($result);
					return $row[0];
				} elseif($result && mysql_num_rows($result) != 1) {
					return array();
				}
				else
				{
					return false;
				}
				break;

			default:
				trigger_error(__FUNCTION__ . " unknowd query type");
				return false;
		}
	} elseif ($dbenv['sql_cmd'] === "INSERT") {
		if($result) {
			return db_last_id();
		} else {
			return false;
		}
	} elseif ($dbenv['sql_cmd'] === "DELETE" || $dbenv['sql_cmd'] === "UPDATE"  ) {
		if($result) {
			if(mysql_affected_rows() >= 1){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	else
	{
		return $result;
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

function db_parsesql($sql)
{
	$dbenv = &db_get_env();

	if(empty($sql))
	{
		trigger_error('SQL语句不能为空');
		return false;	
	}

	if(preg_match("/^\s*([a-z]+)\s+/i", $sql, $matches))
	{
		$dbenv['sql_cmd'] = strtoupper($matches[1]);
	}
	else
	{
		trigger_error('无法解析出SQL命令<br/>SQL: ' . $sql . '<br/>');
		return false;	
	}
	//SQL语句安全检查
	if(in_array($dbenv['sql_cmd'], array('TRUNCATE', 'DROP', 'ALTER', 'LOAD', 'GRANT', 'RENAME', 'REVOKE', 'SET')))
	{
		trigger_error('危险的SQL命令<br>SQL: ' . $sql . '<br/>', E_USER_ERROR);	
		return false;
	}

	if(in_array($dbenv['sql_cmd'], array('UPDATE', 'DELETE')))
	{
		if(!preg_match("/(?:WHERE|LIMIT)[\s\S]+$/i", $sql))
		{
			trigger_error('没有给定SQL查询条件<br>SQL: ' . $sql . '<br/>', E_USER_ERROR);	
			return false;
		}
	}

	return $sql;
}

//mysql fetch
function db_fetch($result, $type = "assoc")
{
	switch($type)
	{
		case "assoc":
			return mysql_fetch_array($result, MYSQL_ASSOC);
			break;

		case "num":
			return mysql_fetch_array($result, MYSQL_NUM);
			break;

		default:
			trigger_error('未知的fetch操作类型');
			return false;
			break;
	}
}

//mysql fetch rows
function db_fetch_rows($result, $index_field = null)
{
	if($result && mysql_num_rows($result) >= 1)
	{
		$rows = array();
		while($row = mysql_fetch_assoc($result))
		{
			if($index_field === null) {
				$rows[] = $row;
			} else {
				$rows[$index_field] = $row;
			}
		}
		unset($row);
		return $rows;
		
	} elseif($result && mysql_num_rows($result) < 1) {
		
		return array();
	}
	else
	{
		return false;
	}
}

//debug
function db_debug()
{
	$dbenv = &db_get_env();
	return var_export($dbenv);
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

function db_last_id()
{
	$dbenv = &db_get_env();
	$db = &$dbenv['dbconf'][$dbenv['host']];

	return mysql_insert_id($db['link']);
}
function db_close($host = null)
{
	if(is_null($server))
	{
		db_closeall();
	}
	if(empty($host)){
		$dbenv = &db_get_env();
		db_closeHostServer($dbenv['host']);
	}else{
		db_closeHostServer($host);
	}
}
//close all database;
function db_closeall()
{
	$dbenv = &db_get_env();
	if(!isset($dbenv['dbconf'])) return;

	foreach($dbenv['dbconf'] as $host => $db)
	{
		if($db['state'] == DB_CONNECT)
		{
			mysql_close($dbenv['dbconf'][$host]['link']);
			$dbenv['dbconf'][$host]['link'] = null;
			$dbenv['dbconf'][$host]['state'] = DB_DISCONNECT;
			$dbenv['state']['CLOSE_TIMES']++;
		}
	}

}
function db_closeHostServer($host)
{
	$dbenv = &db_get_env();
	if(isset($dbenv['dbconf'][$host]))
	{
		if(is_resource($dbenv['dbconf'][$host]['link']))
		{
			mysql_close($dbenv['dbconf'][$host]['link']);
			$dbenv['dbconf'][$host]['link'] = null;
			$dbenv['dbconf'][$host]['state'] = DB_DISCONNECT;
			$dbenv['state']['CLOSE_TIMES']++;
		}
	}
	else
	{
		trigger_error('服务器不存在: ' . $host);	
	}
}
?>

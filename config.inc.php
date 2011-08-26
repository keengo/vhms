<?php

define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', 'root');
define('UC_DBPW', 'iamkyj99');
define('UC_DBNAME', 'uctest');
define('UC_DBCHARSET', 'gbk');
define('UC_DBTABLEPRE', '`uctest`.test_ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', 'fb90zZ6o+EIcGEtg/1Mwwxx4xmd30UVnE6+QQOc');
define('UC_API', 'http://127.0.0.99/uc_server');
define('UC_CHARSET', 'gbk');
define('UC_IP', '');
define('UC_APPID', '4');
define('UC_PPP', '20');


			// 当前应用的 ID

$dbhost = 'localhost';		// 数据库服务器
$dbuser = 'root';			// 数据库用户名
$dbpw = 'iamkyj99';			// 数据库密码
$dbname = 'uctest';			// 数据库名
$pconnect = 0;				// 数据库持久连接 0=关闭, 1=打开
$tablepre = 'test_ucenter_';   	// 表名前缀, 同一数据库安装多个论坛请修改此处
$dbcharset = 'gbk';			// MySQL 字符集, 可选 'gbk', 'big5', 'utf8', 'latin1', 留空为按照论坛字符集设定
							//同步登录 Cookie 设置
$cookiedomain = ''; 		// cookie 作用域
$cookiepath = '/';			// cookie 作用路径
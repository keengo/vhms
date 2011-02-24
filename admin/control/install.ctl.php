<?php
$GLOBALS['lock_file'] = dirname(__FILE__).'/install.lock';
if(file_exists($GLOBALS['lock_file'])){
	die("已经安装过了，如果要重新安装，请删除文件:".$GLOBALS['lock_file']);
}
class InstallControl extends Control
{
	public function step1()
	{
		//测试空间是否可写
		$test_file = dirname(__FILE__)."test_write.txt";
		$fp = @fopen($test_file,"wt");
		if(!$fp){
			die("空间不可写，请检查权限");
		}
		fclose($fp);
		if(!unlink($test_file)){
			die("空间不可写，请检查权限");
		}
		//测试结束
		$request['db_host'] = 'localhost';
		$request['db_name'] = 'kangle';
		$request['admin_user'] = 'admin';
		$this->_tpl->assign("request",$request);
		return $this->_tpl->fetch('install/step1.html');
	}
	public function step2()
	{
		$host = $_REQUEST['db_host'];
		$dbname = $_REQUEST['db_name'];
		$user = $_REQUEST['db_user'];
		$passwd = $_REQUEST['db_passwd'];
		
		$GLOBALS['default_db'] = $this->check_connect($host,"3306",$dbname,$user,$passwd);
		if(!$GLOBALS['default_db']){
			$this->_tpl->assign("msg","数据库连接出错");
			$this->_tpl->assign("request",$_REQUEST);
			return $this->_tpl->fetch('install/step1.html');
		}
		$this->create_sql($GLOBALS['default_db']);	
		$this->create_config($host, "3306", $dbname, $user, $passwd);
		daocall('admin_user', 'newUser', array($_REQUEST['admin_user'],$_REQUEST['admin_passwd']));
		$fp = @fopen($GLOBALS['lock_file'],'wt');
		if(!$fp){
			die('没能写文件:'.$GLOBALS['lock_file']);
		}
		//写入version
		fwrite($fp,VHMS_VERSION);
		fclose($fp);
		return $this->_tpl->fetch('install/step2.html');
	}
	public function check_connect($host,$port,$dbname,$user,$passwd)
	{
		load_lib('pub:db');
		return db_connectx('mysql',$host, $port, $dbname, $user, $passwd);
	}
	private function create_config($host,$port,$dbname,$user,$passwd)
	{
		$str = "<?php\r\n\$db_cfg['default']=array(\r\n'";
		$str.="driver'=>'mysql',\r\n";
		$str.="'host'=>'".$host."',\r\n";
		$str.="'port'=>'".$port."',\r\n";
		$str.="'user'=>'".$user."',\r\n";
		$str.="'passwd'=>'".$passwd."',\r\n";
		$str.="'dbname'=>'".$dbname."');\r\n";
		$str.='$GLOBALS[\'skey\'] = \''.getRandPasswd(16).'\';\r\n';
		$str.="?>";
		$config_file = dirname(dirname(dirname(__FILE__)))."/config.php";
		$fp = @fopen($config_file,"wt");
		if(!$fp){
			die("不能写入配置文件".$config_file."，请检查权限");
		}
		fwrite($fp,$str);
		fclose($fp);
		@chmod($config_file,0600);
		
		return true;		
	}
	private function create_sql($pdo)
	{
		$files = file(dirname(__FILE__).'/kangle.sql');
		if(!$files || count($files)<=0){
			trigger_error('无法打开kangle.sql文件');
			return false;
		}
		$sql = "";
		for($i=0;$i<count($files);$i++){
			if(strncmp($files[$i],'-- ',3)==0){
				//it is a comment
				continue;
			}
			$sql.= $files[$i];
			//rtrim($files[$i]);
			if(substr($files[$i],-2)==";\n" || substr($files[$i],-3)==";\r\n"){
				//echo "sql=".$sql;
				$pdo->exec($sql);
				$sql = "";
			}
		}
	}
}
?>
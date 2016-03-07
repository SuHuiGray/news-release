<?php
	class Mysqli{
		private $conn;
		private $host;
		private $dbname;
		private $user;
		private $psw;

		/*
		 *构造函数，初始化变量并返回数据库连接对象
		 *
		*/
		
		public function __construct(){
			
			//读取数据库连接配置
			$dbfile = dirname($_sSERVER['DOCUMENT_ROOT']."/mvc/dbconfig.xml");
			$simplexml = simplexml_load_file($dbfile);
			$dbConnects = $simplexml->dbContent;
			$dbContent = $dbConnects[0];
			$this->host = $dbContent->dbHost;
			$this->user = $dbConnect->dbUser;
			$this->psw = $dbConnect->dbPwd;
			$this->dbname = $dbConnect->dbName;
		}

		/*
		 *报错函数，提示错误信息
		 *
		 *@苏辉
		*/
		function err($error){
			die("sorry,your operate failed, reason:".$error);
		}

		/*
		 *连接数据库函数
		 *
		 *$config配置数组array($dbhost,$dbuser,$password,$dbname,$dbcharset)
		 *
		 *@苏辉
		*/
		/*function connect($config){
			extract($config);//本函数从数组中将变量导入到当前的符号表
			if(!($con = mysqli_connect($dbhost,$dbuser,$password,$dbname))){
				$this->err(mysqli_error());
			}
			mysqli_query($con,"set names ".$dbcharset);
		}*/

		function connect(){
			$this->conn = mysqli_connect($this->host, $this->user, $this->psw, $this->dbname) or die("Error to connect to mysql");

			mysqli_query($this->conn, "SET NAMES utf8;");

			mysqli_autocommit($this->conn, false);

			return $this->conn;
		}

		/*
		 *执行查询语句
		*/
		public function execute_dql($sql){
			$res = mysqli_query($this->conn,$sql);
			return $res;
		}

		/*
		 *执行增删改语句
		*/
		public function execute_dml($sql){
			$b = mysqli_query($this->conn,$sql);

			if(!$b){
				return 0;
			}
			else{
				if(mysqli_affetcte_rows($this->conn)>0){
					return 1;//操作成功
				}
				else{
					return 2;//没有影响
				}
			}
		}

		/*
		 *返回查询数组列表
		*/
		public function fetchAll($sql){
			$res = mysqli_query($this->conn,$sql);
			if($res){
				while($row = mysqli_fetch_array($res,MYSQL_ASSOC)){
					$arr[] = $row; 
				}
			}
			return isset($arr)?arr:"";
		}

		/*
		 *返回单条数据
		*/
		function fetchOne($sql){
			$res = mysqli_query($this->conn,$sql);
			$row = mysqli_fetch_array($res,MYSQL_ASSOC);
			return $row;
		}
		
		/*
		 *执行插入语句
		 *
		 *$table是表名，$arr 是关联数组，key是$table表中的字段，value是字段的值
		*/
		function insert($table,$arr){
			foreach($arr as $key=>$value){
				$keyArr[] = "`".$key."`";
				$valueArr[] = "`".$value."`";
			}

			$keys = implode(",",$keyArr);
			$values = implode(",",$valueArr);
			$sql = "insert into ".$table."(".$keys.") values(".$values.")";
			mysqli_query($this->conn,$sql);
			return mysql_insert_id();
		}

	}
?>
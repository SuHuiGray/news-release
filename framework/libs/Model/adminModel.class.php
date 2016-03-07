<?php
	class adminModel{//从数据库存取数据

		public $table = 'admin';

		//取用户信息，通过用户名
		function findOne_by_username($username){
			$sql = "select * from ".$this->table." where user_name='".$username."'";
			return DB::findOne($sql);
		}

		//用户名，密码核对放在auth模型中
	}
?>
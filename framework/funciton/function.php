<?php
	function C($name,$method){//控制器的方法在mvc模式下一般不允许带自己的参数
		require_once('framework/libs/Controller/'.$name.'Controller.class.php');
		eval('$obj = new '.$name.'Controller(); $obj->'.$method.'();');//将字符串转换成可执行的php语句
	}

	function M($name){
		require_once('framework/libs/Model/'.$name.'Model.class.php');
		eval('$obj = new '.$name.'Model();');
		return $obj;
	}

	function V($name){
		require_once('framework/libs/View/'.$name.'View.class.php');
		eval('$obj = new '.$name.'View();');
		return $obj;
	}

	function daddslashes($str){
		/*
		 *magic_quotes_gpc函数在php中的作用是判断解析用户提示的数据，如包括有*:post,get、cookie过来的数据增加转义字符“\”，以确保这些数据不会引起程序，特别*是数据库语句因为特殊字符引起的污染而出现致命的错误
		 *
		*/
		return (!get_magic_quotes_gpc())?addslashes($str):$str;
	}

	function ORG($path, $name, $params=array()){// path是路径，那么是第三方法类名 params是该类初始化的时候需要指定的赋值的属性，格式为array(属性名=>属性值，属性名2=>属性值2......)
		require_once('libs/ORG/'.$path.$name.'.class.php');
		//eval('$obj = new '.$name.'()');
		$obj = new $name();
		if(!empty($params)){
			foreach($params as $key=>$value){
				//eval('$obj->'.$key.' = \''.$value.'\';');
				$obj->$key = $value;
			}
		}
		return $obj;
	}
?>
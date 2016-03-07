<?php
	header("Content-type:text/html; charset=utf-8");
	session_start();
	//调用配置文件
	require_once("config.php");

	//调用微型框架
	require_once("framework/pc.php");
	PC::run($config);
?>
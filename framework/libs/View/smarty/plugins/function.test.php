<?php
	function smarty_function_test($params){
		//array("parameter"=>"value",...)
		$width = $params['width'];
		$height = $params['height'];
		$area = $width * $height;
		return $area;
	}
?>
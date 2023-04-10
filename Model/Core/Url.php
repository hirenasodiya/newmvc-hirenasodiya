<?php

require_once'Model/Core/Request.php';

class Model_Core_Url
{
	public function getUrl($action = null, $controller = null, $param = [], $reset = false)
	{

		// echo "<pre>";
		$result = new Model_Core_Request();

		$final = $result->getParam();
		
		if ($reset) {
			$final = [];
		}

		if ($controller) {
			$final['c'] = $controller;
		}

		else{
			$final['c'] = $result->getControllerName();
		}

		if ($action) {
			$final['a'] = $action;
		}
		
		else{
			$final['a'] = $result->getActionName();
		}

		if ($param) {
			$final = array_merge($final, $param);
		}

		$queryString = http_build_query($final);

		$requesturl = trim($_SERVER['REQUEST_URI'], $_SERVER['QUERY_STRING']);
		// echo"<br>";

		return $url = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$requesturl.$queryString;
		// echo"<br>";

		
	}
}

?>
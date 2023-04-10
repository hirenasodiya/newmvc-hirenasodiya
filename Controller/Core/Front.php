<?php

class Controller_Core_Front 
{
	public $request = null;
	public $adapter = null;

	protected function setRequest(Model_Core_Request $request)
	{
		$this->request = $request;
		return $this;
	}

	public function getRequest()
	{
		if($this->request){
			return $this->request;
		}

		$request = new Model_Core_Request();
		$this->setRequest($request);
		return $request;
	}

	public function init()
	{
		$request = $this->getRequest();
		$controllerName = $request->getControllerName();
		$controllerClassName = 'Controller_'.ucwords($controllerName,'_');
		$controllerPathName = str_replace('_', '/', $controllerClassName);
		
		require_once $controllerPathName.'.php';

		$controller = new $controllerClassName();
		$actionName = $request->getActionName().'Action';

		if (method_exists($controller, $actionName) == false) {
			$controller->errorAction($actionName);
		}else{
			$controller->$actionName();
		}
	}
}


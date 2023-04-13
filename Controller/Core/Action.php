<?php

class Controller_Core_Action 
{
	public $request = null;
	public $adapter = null;
	public $urlObj = null;
	public $message = null;
	public $view = null;
	public $layout = null;

	public function setLayout(Block_Core_Layout $layout)
	{
		$this->layout = $layout;
		return $this;
	}

	public function getLayout()
	{
		if(!$this->layout){
			$layout = new Block_Core_Layout();
			$this->setLayout($layout);
			return $layout;
		}
			return $this->layout;

	}

	public function setView(Model_Core_View $view)
	{
		$this->view = $view;
		return $this;
	}

	public function getView()
	{
		if($this->view){
			return $this->view;
		}

		$view = new Model_Core_View();
		$this->setView($view);
		return $view;
	}


	public function setUrlObj(Model_Core_Url $urlObj)
	{
		$this->urlObj = $urlObj;
		return $this;
	}

	public function getUrlObj()
	{
		if($this->urlObj){
			return $this->urlObj;
		}

		$urlObj = new Model_Core_Url();
		$this->setUrlObj($urlObj);
		return $urlObj;
	}

	
	public function setMessage(Model_Core_Message $message)
	{
		$this->message = $message;
		return $this;
	}

	public function getMessage()
	{
		if($this->message){
			return $this->message;
		}

		$message = new Model_Core_Message();
		$this->setMessage($message);
		return $message;
	}

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

	protected function setAdapter(Model_Core_Adapter $adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function getAdapter()
	{
		if ($this->adapter) {
			return $this;
		}

		$adapter = new Model_Core_Adapter();
		$this->setAdapter($adapter);
		return $adapter;
	}

	public function redirect($action = null, $controller = null, $param = [], $reset = false)
	{
		$url = $this->getUrlObj()->getUrl($action, $controller, $param, $reset);
		header("location:{$url}");
		exit();
	}

	public function errorAction($action)
	{
		throw new Exception("method: {$action} does not exits");
	}

	public function gettemplate($templatePath)
	{
		require"View".DS.$templatePath;
	}

	public function render()
	{
		Ccc::getModel('Core_View')->render();
	}
}



?>
<?php

/**
 * 
 */
class Model_Core_Response
{
	protected $controller = null;

	protected $_jsonData = [
		'status' => 'success',
		'message' => 'success',
		'messageBlockHtml' => null
	];

	public function setController($controller)
	{
		$this->controller = $controller;
		return $this;
	}

	private function getController()
	{
		return $this->controller;
	}


	public function setJsonData($_jsonData)
	{
		$this->_jsonData = array_merge($this->_jsonData, $_jsonData);
		return $this;
	}

	public function getJsonData()
	{
		return $this->_jsonData;
	}

	public function setBody($content)
	{
		echo $content;
		@header("Content-Type:text/html");
	}

	public function jsonResponse($data)
	{
		$this->setJsonData($data);
		$this->setmessageResponse();
		echo json_encode($this->getJsonData());
		@header("Content-Type:application/json");
	}

	protected function setmessageResponse()
	{
		$messageHtml = $this->getController()->getLayout()->createBlock('Html_Message')->toHtml();
		$this->setJsonData(['messageBlockHtml' => $messageHtml]);
	}	
}
<?php

/**
 * 
 */
class Block_Html_Head extends Block_Core_Template
{
	protected $title = null;
	protected $javascripts = [];
	protected $stylesheets = [];
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('html/head.phtml');

	}

	public function addJs($src)
	{
		$this->javascripts[] = $src;
		return $this;
	}

	public function getAllJs()
	{
		return $this->javascripts;
	}

	public function setTitle($title)
	{
		$this->title = $title;
		return $this;
	}

	public function getTitle()
	{
		return $this->title; 
	}

}

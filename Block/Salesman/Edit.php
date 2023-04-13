<?php

/**
 * 
 */
class Block_Salesman_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/edit.phtml');
	}

	public function getSalesman()
	{
		$salesman = $this->getData('salesman');
		$address = $this->getData('address');
		$final = [$salesman, $address];
		return $final;
	}
}
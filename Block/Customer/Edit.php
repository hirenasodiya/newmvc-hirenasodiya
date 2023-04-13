<?php

/**
 * 
 */
class Block_Customer_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('customer/edit.phtml');
	}

	public function getCustomer()
	{
		$customer = $this->getData('customer');
		$address = $this->getData('address');
		$final = [$customer, $address];
		return $final;
	}
}
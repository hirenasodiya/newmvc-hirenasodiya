<?php

/**
 * 
 */
class Block_Vendor_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/edit.phtml');
	}

	public function getVendor()
	{
		$vendor = $this->getData('vendor');
		$address = $this->getData('address');
		$final = [$vendor, $address];
		return $final;
	}
}
<?php

/**
 * 
 */
class Block_Paymentmethod_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('paymentmethod/edit.phtml');

	}
	public function getRow()
	{
		$paymentMethods = $this->getData('paymentmethod');
		return $paymentMethods;	

	}
	public function getAttributes()
	{
		$attribute = Ccc::getModel('paymentMethod')->getAttributes();
		return $attribute;
	}
}
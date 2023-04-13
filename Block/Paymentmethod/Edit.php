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
	public function getPaymentmethod()
	{
		$paymentMethods = $this->getData('paymentmethod');
		return $paymentMethods;	

	}
}
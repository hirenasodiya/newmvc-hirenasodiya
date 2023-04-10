<?php

class Block_Paymentmethod_Grid extends Block_Core_Template
{

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('paymentmethod/grid.phtml');
	}

	public function getPaymentmethods()
	{
		$query = "SELECT * FROM `payment_method`";
		$paymentMethods = Ccc::getModel('Paymentmethod')->fetchAll($query);
		return $paymentMethods;	
	}

}


?>
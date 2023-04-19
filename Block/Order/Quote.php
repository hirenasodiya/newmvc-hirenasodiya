<?php

/**
 * 
 */
class Block_Order_Quote extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('order/quote.phtml');

	}
	public function getCustomers()
	{
		$query = "SELECT * FROM `customer`";
		$customer = Ccc::getModel('Customer')->fetchAll($query);
		return $customer;
	}
}
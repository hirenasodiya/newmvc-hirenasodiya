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
		// echo "<pre>";
		// print_r($billing);
		// die();
		$final = [$customer, $address];
		return $final;
	}

	public function getBilling()
    {
        $address = Ccc::getModel('Customer_Address');
        $sql = "SELECT * FROM `{$address->getResourceName()}` WHERE `{$address->getPrimaryKey()}` = '{$this->billing_address_id}'";
        $billing = $address->fetchAll($sql);
        return $billing;
    }

    public function getShipping()
    {
        $address = Ccc::getModel('Customer_Address');
        $sql = "SELECT * FROM `{$address->getResourceName()}` WHERE `{$address->getPrimaryKey()}` = '{$this->shipping_address_id}'";
        $shipping = $address->fetchAll($sql);
        return $shipping;
    }

    public function getAddresses()
    {
        $address = Ccc::getModel('Customer_Address');
        $sql = "SELECT * FROM `{$address->getResourceName()}` WHERE `{$address->getPrimaryKey()}` = '{$this->customer_id}'";
        $billing = $address->fetchAll($sql);
        return $billing;
    }
}
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

		$billingAddress = $this->getData('billingAddress');
		$shippingAddress = $this->getData('shippingAddress');

		$final = [$customer, $billingAddress, $shippingAddress];
		return $final;
	}

	public function getBillingAddress()
    {
		$billingAddressId = $this->getData('customer')->billing_address_id;
        if (!$billingAddressId) {
			return Ccc::getModel('Customer_Address');
		}

		$address = Ccc::getModel('Customer_Address');
        $sql = "SELECT * FROM `{$address->getResourceName()}` WHERE `{$address->getPrimaryKey()}` = '{$billingAddressId}'";
        $billingAddress = $address->fetchRow($sql);
        return $billingAddress;
    }

    public function getShippingAddress()
    {
		$shippingAddressId = $this->getData('customer')->shipping_address_id;
		if (!$shippingAddressId) {
			return Ccc::getModel('Customer_Address');
		}
        $address = Ccc::getModel('Customer_Address');
        $sql = "SELECT * FROM `{$address->getResourceName()}` WHERE `{$address->getPrimaryKey()}` = '{$shippingAddressId}'";
        $shippingAddress = $address->fetchRow($sql);
        return $shippingAddress;
    }

    public function getAddresses()
    {
        $address = Ccc::getModel('Customer_Address');
        $sql = "SELECT * FROM `{$address->getResourceName()}` WHERE `{$address->getPrimaryKey()}` = '{$this->customer_id}'";
        $customerAddress = $address->fetchRow($sql);
        return $customerAddress;
    }
}
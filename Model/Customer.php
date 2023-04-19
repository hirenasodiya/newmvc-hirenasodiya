<?php

class Model_Customer extends Model_Core_Table
{
	protected $resourceClass = 'Model_Customer_Resource';
    protected $collectionClass = 'Model_Customer_Collection';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_ACTIVE_LBL = 'active';
    const STATUS_INACTIVE_LBL = 'inactive';
    const STATUS_DEFAULT = 2;

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return self::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[self::STATUS_DEFAULT];
    }

    public function getBillingAddress() 
    {
        $customerAddress = Ccc::getModel('Customer_Address');
        $query = "SELECT * FROM `{$customerAddress->getResourceName()}` WHERE `{$customerAddress->getPrimaryKey()}` = '{$this->billing_address_id}'";
        return $customerAddress->fetchRow($query);
    }

    public function getShippingAddress()
    {
        $customerAddress = Ccc::getModel('Customer_Address');
        $query = "SELECT * FROM `{$customerAddress->getResourceName()}` WHERE `{$customerAddress->getPrimaryKey()}` = '{$this->shipping_address_id}'";
        return $customerAddress->fetchRow($query);
    }

    public function getAddress()
    {
        $customerAddress = Ccc::getModel('Customer_Address');
        $query = "SELECT * FROM `{$customerAddress->getResourceName()}` WHERE `{$customerAddress->getPrimaryKey()}` = '{$this->customer_id}'";
        return $customerAddress->fetchRow($query);
    }

}

?>
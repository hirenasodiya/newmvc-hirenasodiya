<?php

class Model_Customer extends Model_Core_Table
{
	protected $resourceClass = 'Model_Customer_Resource';
    protected $collectionClass = 'Model_Customer_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return Model_Customer_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[Model_Customer_Resource::STATUS_DEFAULT];
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
        $sql = "SELECT * FROM `customer_address` WHERE `address_id` = 3 AND `customer_id` = 2";
        $shipping = $this->fetchRow($sql);
        return $shipping;   
    }

    public function getAddresses()
    {
        
    }

}

?>
<?php

class Model_Paymentmethod extends Model_Core_Table
{
	protected $resourceClass = 'Model_Paymentmethod_Resource';
    protected $collectionClass = 'Model_Paymentmethod_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return Model_Paymentmethod_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[Model_Paymentmethod_Resource::STATUS_DEFAULT];
    }
}

?>
<?php

class Model_Salesman_Price extends Model_Core_Table
{
	protected $resourceClass = 'Model_Salesman_Price_Resource';
    protected $collectionClass = 'Model_Salesman_Price_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return Model_Salesman_Price_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[Model_Salesman_Price_Resource::STATUS_DEFAULT];
    }
}


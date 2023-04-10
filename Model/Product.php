<?php

class Model_Product extends Model_Core_Table
{
	protected $resourceClass = 'Model_Product_Resource';
    protected $collectionClass = 'Model_Product_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return Model_Product_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[Model_Product_Resource::STATUS_DEFAULT];
    }
}

?>
<?php

class Model_Core_Eav_Attribute_Option extends Model_Core_Table
{
	protected $resourceClass = 'Model_Core_Eav_Attribute_Option_Resource';
    protected $collectionClass = 'Model_Core_Eav_Attribute_Option_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return Model_Core_Eav_Attribute_Option_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[Model_Core_Eav_Attribute_Option_Resource::STATUS_DEFAULT];
    }
}

?>
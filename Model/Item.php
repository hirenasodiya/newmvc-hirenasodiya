<?php

class Model_Item extends Model_Core_Table
{
	protected $resourceClass = 'Model_Item_Resource';
    protected $collectionClass = 'Model_Item_Collection';

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return Model_Item_Resource::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[Model_Item_Resource::STATUS_DEFAULT];
    }

    public function getAttributes()
    {
        $sql = "SELECT * FROM `eav_attribute` WHERE `entity_type_id` = 6 AND `status` = 1 ";
        $attributes = Ccc::getModel('Core_Eav_Attribute')->fetchAll($sql);
        return $attributes->getData();
    }
}

?>
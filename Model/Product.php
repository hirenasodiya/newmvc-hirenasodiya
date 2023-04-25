<?php

class Model_Product extends Model_Core_Table
{
	protected $resourceClass = 'Model_Product_Resource';
    protected $collectionClass = 'Model_Product_Collection';

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

    public function getAttributes()
    {
        $sql = "SELECT * FROM `eav_attribute` WHERE `entity_type_id` = 1 ";
        $attributes = Ccc::getModel('Core_Eav_Attribute')->fetchAll($sql);
        return $attributes->getData();
    }

    public function getAttributeValue($attribute)
    {
        if ($this->getId()) {
            $query = "SELECT `value` FROM `product_{$attribute->backend_type}` WHERE `entity_id` = '{$this->getId()}' AND `attribute_id` = '{$attribute->getId()}'";
            $row = $this->getResource()->getAdapter()->fetchOne($query);
            return $row;
        }
    }
}

?>
<?php
/**
 * 
 */
class Model_Item_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('item');
		$this->setPrimaryKey('entity_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Item::STATUS_ACTIVE => Model_Item::STATUS_ACTIVE_LBL,
			Model_Item::STATUS_INACTIVE => Model_Item::STATUS_INACTIVE_LBL
		];
	}
}
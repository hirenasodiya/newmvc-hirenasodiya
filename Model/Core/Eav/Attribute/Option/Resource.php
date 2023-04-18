<?php

/**
 * 
 */
class Model_Core_Eav_Attribute_Option_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('eav_attribute_option');
		$this->setPrimaryKey('option_id');
	}

	public function getStatusOptions()
	{
		return [
			self::STATUS_ACTIVE => self::STATUS_ACTIVE_LBL,
			self::STATUS_INACTIVE => self::STATUS_INACTIVE_LBL
		];
	}
}
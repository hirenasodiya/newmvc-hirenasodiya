<?php
/**
 * 
 */
class Model_Order_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('quote');
		$this->setPrimaryKey('quote_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Quote::STATUS_ACTIVE => Model_Quote::STATUS_ACTIVE_LBL,
			Model_Quote::STATUS_INACTIVE => Model_Quote::STATUS_INACTIVE_LBL
		];
	}
}
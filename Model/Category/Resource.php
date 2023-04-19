<?php
/**
 * 
 */
class Model_Category_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('category');
		$this->setPrimaryKey('category_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Category::STATUS_ACTIVE => Model_Category::STATUS_ACTIVE_LBL,
			Model_Category::STATUS_INACTIVE => Model_Category::STATUS_INACTIVE_LBL
		];
	}
}
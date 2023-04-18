<?php
/**
 * 
 */
class Model_Product_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('product');
		$this->setPrimaryKey('product_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Product::STATUS_ACTIVE => Model_Product::STATUS_ACTIVE_LBL,
			Model_Product::STATUS_INACTIVE => Model_Product::STATUS_INACTIVE_LBL
		];
	}
}
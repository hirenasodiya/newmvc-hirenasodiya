<?php
/**
 * 
 */
class Model_Shippingmethod_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('shipping_method');
		$this->setPrimaryKey('shipping_method_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Shippingmethod::STATUS_ACTIVE => Model_Shippingmethod::STATUS_ACTIVE_LBL,
			Model_Shippingmethod::STATUS_INACTIVE => Model_Shippingmethod::STATUS_INACTIVE_LBL
		];
	}
}
<?php

/**
 * 
 */
class Model_Paymentmethod_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('payment_method');
		$this->setPrimaryKey('payment_method_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Paymentmethod::STATUS_ACTIVE => Model_Paymentmethod::STATUS_ACTIVE_LBL,
			Model_Paymentmethod::STATUS_INACTIVE => Model_Paymentmethod::STATUS_INACTIVE_LBL
		];
	}
}
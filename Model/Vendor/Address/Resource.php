<?php
/**
 * 
 */
class Model_Vendor_Address_Resource extends Model_Core_Table_Resource
{
	function __construct()
	{
		$this->setResourceName('Vendor_address');
		$this->setPrimaryKey('address_id');
	}
	protected 

	const STATUS_ACTIVE = 1;
	const STATUS_INACTIVE = 2;
	const STATUS_ACTIVE_LBL = 'active';
	const STATUS_INACTIVE_LBL = 'inactive';
	const STATUS_DEFAULT = 2;

	public function getStatusOptions()
	{
		return [
			self::STATUS_ACTIVE => self::STATUS_ACTIVE_LBL,
			self::STATUS_INACTIVE => self::STATUS_INACTIVE_LBL
		];
	}
}
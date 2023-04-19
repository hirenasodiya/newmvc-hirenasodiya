<?php

/**
 * 
 */
class Model_Admin_Resource extends Model_Core_Table_Resource
{
	
	function __construct()
	{
		$this->setResourceName('admin');
		$this->setPrimaryKey('admin_id');
	}

	public function getStatusOptions()
	{
		return [
			Model_Admin::STATUS_ACTIVE => Model_Admin::STATUS_ACTIVE_LBL,
			Model_Admin::STATUS_INACTIVE => Model_Admin::STATUS_INACTIVE_LBL
		];
	}
}
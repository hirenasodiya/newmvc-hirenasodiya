<?php 

/**
 * 
 */
class Block_Vendor_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('vendor/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `Vendor`";
		$vendor = Ccc::getModel('Vendor')->fetchAll($sql);
		return $vendor;
	}
}
<?php 

/**
 * 
 */
class Block_Core_Eav_Attribute_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/eav/attribute/grid.phtml');
	}

	public function getAttributes()
	{
		$sql = "SELECT * FROM `eav_attribute` ";
		$attributes = Ccc::getModel('Core_Eav_Attribute')->fetchAll($sql);
		return $attributes;
	}
}
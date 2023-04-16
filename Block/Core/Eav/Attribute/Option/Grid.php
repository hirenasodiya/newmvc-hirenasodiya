<?php 

/**
 * 
 */
class Block_Core_Eav_Attribute_Option_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('eav/attribute/grid.phtml');
	}

	
}
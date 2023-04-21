<?php

/**
 * 
 */
class Block_Core_Eav_Attribute_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/eav/attribute/edit.phtml');

	}
	public function getAttribute()
	{
		$attribute = $this->getData('attribute');
		
		return $attribute;
	}

	public function getAttributeOption()
	{
		$attributeId = Ccc::getModel('Core_Request')->getParam('attribute_id');
		if (!$attributeId) {
			return Ccc::getModel('Core_Eav_Attribute_Option');
		}
		
		$sql = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = $attributeId";
		$attributeOption = Ccc::getModel('Core_Eav_Attribute_Option')->fetchAll($sql);
		return $attributeOption;
	}

	public function getEntityType()
	{
		$sql = "SELECT * FROM `entity_type`";
		$typeData = Ccc::getModel('Core_Eav_Attribute_Option')->fetchAll($sql);
		return $typeData;
	}
}
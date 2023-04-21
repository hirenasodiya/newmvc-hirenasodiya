<?php
				
/**
 * 
 */
class Block_Shippingmethod_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('shippingmethod/edit.phtml');
	}

	public function getRow()
	{
		$shippingMethod = $this->getData('shippingmethod');
		return $shippingMethod;
	}

	public function getAttributes()
	{
		$attribute = Ccc::getModel('shippingmethod')->getAttributes();
		return $attribute;
	}
}

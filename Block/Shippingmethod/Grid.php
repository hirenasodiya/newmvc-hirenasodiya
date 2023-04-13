<?php 
/**
 * 
 */
class Block_Shippingmethod_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('shippingmethod/grid.phtml');
	}

	public function getShippingMethods()
	{
		$sql = "SELECT * FROM `shipping_method`";
		$shippingMethod = Ccc::getModel('Shippingmethod')->fetchAll($sql);
		return $shippingMethod;
	}
}
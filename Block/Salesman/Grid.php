<?php 

/**
 * 
 */
class Block_Salesman_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/grid.phtml');
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `salesman`";
		$salesman = Ccc::getModel('Salesman')->fetchAll($sql);
		return $salesman;
	}
}
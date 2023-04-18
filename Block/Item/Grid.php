<?php

class Block_Item_Grid extends Block_Core_Template
{

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('item/grid.phtml');
	}

	public function getItems()
	{
		$query = "SELECT * FROM `item` WHERE 1";
		$items = Ccc::getModel('Item')->fetchAll($query);
		return $items;	
	}

}


?>
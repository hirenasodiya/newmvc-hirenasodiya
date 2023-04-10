<?php

class Block_Product_Media_Grid extends Block_Core_Template
{

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('product/media/grid.phtml');
	}

	public function getMedias()
	{
		$productId = Ccc::getModel('Core_Request')->getParam('product_id');
		$query = "SELECT * FROM `media` WHERE `product_id` = {$productId}";
		$medias = Ccc::getModel('Product_Media')->fetchAll($query);
		return $medias;	
	}

}


?>
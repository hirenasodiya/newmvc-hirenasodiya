<?php

class Block_Salesman_Salesmanprice_Grid extends Block_Core_Template
{

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('salesman/salesmanprices/grid.phtml');
	}

	public function getPrices()
	{
		// echo "<pre>";
		$salesmanId = Ccc::getModel('Core_Request')->getParam('salesman_id');
		// $sql = "SELECT * FROM `salesman` ORDER BY 'first_name' ASC";
		// $salesmen = Ccc::getModel('Salesman_Price')->fetchAll($sql);

		$query = "SELECT P.*, SP.salesman_price FROM `product` P LEFT JOIN `salesman_price` SP ON P.product_id = SP.product_id AND SP.salesman_id = {$salesmanId}";
		$prices = Ccc::getModel('Salesman_Price')->fetchAll($query);

		// $final = [$salesmen, $prices];
		return $prices;

	}

}


?>
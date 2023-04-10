<?php
		
class Controller_Salesman_Price extends Controller_Core_Action
{	
	public function gridAction()
	{
	try {
		// echo "<pre>";
		$salesmanId = Ccc::getModel('Core_Request')->getParam('salesman_id');

			if (!$salesmanId) {
				throw new Exception("Id not found", 1);
			}
			Ccc::register('salesman_id',$salesmanId);

			$layout = $this->getLayout();
			$grid = $layout->createBlock('Salesman_Salesmanprice_Grid');
			$prices = $grid->getPrices()->getData();
			// print_r($prices);
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();
			
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}	
	}

	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$salesmanId = $this->getRequest()->getParam('salesman_id');
			if (!$salesmanId) {
				throw new Exception("Id not found", 1);
			}

			$pricePost = Ccc::getModel('Core_Request')->getPost('sprice');
			if (!$pricePost) {
				throw new Exception("Id not found", 1);
			}

			foreach ($pricePost as $productId => $sprice) {
				$salesmanPrice = Ccc::getModel('Salesman_Price');
				$sql = "SELECT * FROM `salesman_price` WHERE `product_id` = $productId AND `salesman_id` = {$salesmanId};";
				$result = $salesmanPrice->fetchRow($sql);
				
				if ($result == null) {
					if ($sprice != '') {
						$salesP['salesman_id'] = $salesmanId;
						$salesP['product_id'] = $productId;
						$salesP['salesman_price'] = $sprice;

						$salesmanPrice->setData($salesP);
						$salesmanPrices = $salesmanPrice->save();
					}
				}else
				{
					$entityId = $result->entity_id;
					$salesmanPrices['salesman_price'] = $sprice;
					$salesmanPrices['entity_id'] = $entityId;
					$salesmanPrice->setData($salesmanPrices);
					$prices = $salesmanPrice->save();
				}
			}
			if ($prices) {
				$this->getMessage()->addMessages("Data save successfully.", Model_Core_Message::SUCCESS);
			}else
			{
				throw new Exception("Data not save", 1);
			}

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,['salesman_id' => $salesmanId],true);
	}

	public function deleteAction()
	{
		try {
			// echo "<pre>";
			Ccc::getModel('Core_Session')->start();
			$salesmanId = $this->getRequest()->getParam('salesman_id');
			if (!$salesmanId) {
				throw new Exception("Id not found", 1);
			}

			$productId = $this->getRequest()->getParam('product_id');
			if (!$productId) {
				throw new Exception("Id not found", 1);
			}

			$conditions['salesman_id'] = $salesmanId;
			$conditions['product_id'] = $productId;
			$result = Ccc::getModel('Salesman_Price_Resource')->delete($conditions);
			// print_r($result);
			if(!$result)
			{
				throw new Exception("Deletion failed", 1);
			}

			$this->getMessage()->addMessages("Data deleted successfully.", Model_Core_Message::SUCCESS);

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		$this->redirect('grid','salesman_price',['salesman_id' => $salesmanId],true);
	}
}



?>
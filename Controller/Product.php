<?php

class Controller_Product extends Controller_Core_Action
{
	public function indexAction()
	{
		try {
			$layout = $this->getLayout();
			$indexBlock = $layout->createBlock('Core_Template')->setTemplate('core/index.phtml');
			$layout->getChild('content')->addChild('index',$indexBlock);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Product_Grid')->toHtml();

			@header("Content-Type:application/json");
			echo json_encode(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$product = Ccc::getModel('Product');
			$addHtml = $layout->createBlock('Product_Edit')->setData(['product'=>$product])->toHtml();

			echo json_encode(['html' => $addHtml, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			$productId = (int) Ccc::getModel('Core_Request')->getParam('product_id');
			if (!$productId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$product = Ccc::getModel('Product')->load($productId);

			if (!$product) {
				throw new Exception("Invalid Request", 1);
			}

			$editHtml = $layout->createBlock('Product_Edit')->setData(['product'=>$product])->toHtml();

			$this->getResponse()->jsonResponse(['html' => $editHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {

			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request", 1);
			}

			$products = $this->getRequest()->getPost('product');
			if (!$products) {
				throw new Exception("Invalid data", 1);
			}


			$productId = Ccc::getModel('Core_Request')->getParam('product_id');
			if ($productId) {
				$product = Ccc::getModel('Product')->load($productId);
				if (!$product) {
					throw new Exception("Invalid product data", 1);
				}
				$product->updated_at = date('Y-m-d h-i-sA');
			}
			else
			{
				$product = Ccc::getModel('Product');
				$product->created_at = date('Y-m-d h-i-sA');
			}
			$result = $product->setData($products);
			$final = $result->save();
			if (!$final) {
				throw new Exception("Data not saved", 1);
			}
			else{
				$attributePost = Ccc::getModel('Core_Request')->getPost('attribute');

				foreach ($attributePost as $backendType => $value) {
					foreach ($value as $attributeId => $v) {
						if (is_array($v)) {
							$v = implode(",", $v);
						}

						$model = Ccc::getModel('Core_table');
						$resource = $model->getResource()->setResourceName("product_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `product_{$backendType}` (`entity_id`,`attribute_id`,`value`) VALUES('{$product->getId()}','{$attributeId}','{$v}') ON DUPLICATE KEY UPDATE `value` ='{$v}'";

						$model->getResource()->getAdapter()->query($query);
					}
				}
			}
			$this->getMessage()->addMessages("Data saved successfully.", Model_Core_Message::SUCCESS);

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Product_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);


		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
		
	}
	public function deleteAction()
	{
		try {
			$id =  Ccc::getModel('Core_Request')->getParam('product_id');
			if (!$id) {
				throw new Exception("Id not found", 1);
			}
			$product = Ccc::getModel('Product')->load($id);
			$result = $product->delete();
			if(!$result)
			{
				throw new Exception("Deletion failed", 1);
			}
			$this->getMessage()->addMessages('Data deleted successfully');


			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Product_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);


		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}


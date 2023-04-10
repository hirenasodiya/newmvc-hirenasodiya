<?php

class Controller_Product extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Product_Grid();
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);

		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$product = Ccc::getModel('Product');
			$edit = $layout->createBlock('Product_Edit')->setData(['product'=>$product]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
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

			$edit = $layout->createBlock('Product_Edit')->setData(['product'=>$product]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid','',[],true);
		}
	}

	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request", 1);
			}

			$products = Ccc::getModel('Core_Request')->getPost('product');
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
			$this->getMessage()->addMessages("Data save successfully.", Model_Core_Message::SUCCESS);
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
			$this->redirect('grid', null);
		
	}
	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
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
			$this->redirect('grid', null, null, true);

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		$this->redirect('grid',null,[],true);
	}
}


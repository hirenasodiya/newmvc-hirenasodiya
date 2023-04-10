<?php

class Controller_Customer extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Customer_Grid();
			$customers = $grid->getCollection();
			$layout->getChild('content')->addChild('grid', $grid);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$customer = Ccc::getModel('customer');
			$address = Ccc::getModel('customer_Address');
			$edit = $layout->createBlock('customer_Edit')->setData(['customer'=>$customer, 'address' => $address]);
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
			$customerId = (int) Ccc::getModel('Core_Request')->getParam('customer_id');
			if (!$customerId) {
				throw new Exception("Invalid ID", 1);
			}

			$layout = $this->getLayout();
			$customer = Ccc::getModel('customer')->load($customerId);
			if (!$customer) {
				throw new Exception("Data not found", 1);
			}
			$address = Ccc::getModel('customer_Address')->load($customerId);
			if (!$address) {
				throw new Exception("Data not found", 1);
			}
			$edit = $layout->createBlock('customer_Edit')->setData(['customer'=>$customer, 'address' => $address]);
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
			$postData = Ccc::getModel('Core_Request')->isPost();
			if (!$postData) {
				throw new Exception("Invalid request.", 1);
			}
			
			$customerPost = Ccc::getModel('Core_Request')->getPost('customer');
			if (!$customerPost) {
				throw new Exception("Data not found.", 1);
			}

			$customerId = (int) Ccc::getModel('Core_Request')->getParam('customer_id');
			if ($customerId) {
				$customer = Ccc::getModel('Customer')->load($customerId);
				if (!$customer) {
					throw new Exception("Data not found.", 1);
				}
				$customer->updated_at = date('Y-m-d h-i-sA');
			} else {
				$customer = Ccc::getModel('Customer');
				$customer->created_at = date('Y-m-d h-i-sA');
			}

			$customer->setData($customerPost);
			if (!$customer->save()) {
				throw new Exception("Data not saved.", 1);
			}
			
			$addressPost = Ccc::getModel('Core_Request')->getPost('address');
			if (!$addressPost) {
				throw new Exception("Data not found.", 1);
			}

			$customerId = (int) Ccc::getModel('Core_Request')->getParam('customer_id');
			if ($customerId) {
				$address = Ccc::getModel('Customer_Address')->load($customerId);
				if (!$address) {
					throw new Exception("Data not found.", 1);
				}
				$address->address_id = $customer->customer_id;
			} else {
				$address = Ccc::getModel('Customer_Address');
				$address->customer_id = $customer->customer_id;
			}

			$address->setData($addressPost);

			if (!$address->save()) {
				throw new Exception("Data not saved.", 1);
			}

			$this->getMessage()->addMessages('Data saved successfully.');
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
			$this->redirect('grid', null, [], true);
	}

	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$customerId = Ccc::getModel('Core_Request')->getParam('customer_id');
			if (!$customerId) {
				throw new Exception("Invalid id.", 1);
			}
			$customer = Ccc::getModel('Customer')->load($customerId);
			$result = $customer->delete();
			if (!$result) {
				throw new Exception("Data not deleted", 1);
			}

			$address = Ccc::getModel('Customer_Address')->load($customerId);
			$result = $address->delete();
			if (!$result) {
				throw new Exception("Address not deleted", 1);
			} else {
				$this->getMessage()->addMessages('Data deleted successfully.');
			}
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
		$this->redirect('grid', null, [], true);
	}
}

?>
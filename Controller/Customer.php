<?php

class Controller_Customer extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('customer_Grid');
			// $customer = $grid->getCollection();
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
			$customer = Ccc::getModel('customer');
			$billingAddress = Ccc::getModel('Customer_Address');
			$shippingAddress = Ccc::getModel('Customer_Address');

			$edit = $layout->createBlock('customer_Edit')->setData(['customer'=>$customer, 'billingAddress' => $billingAddress, 'shippingAddress' => $shippingAddress]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$customerId = (int) Ccc::getModel('Core_Request')->getParam('customer_id');
			if (!$customerId) {
				throw new Exception("Invalid ID", 1);
			}

			$layout = $this->getLayout();
			$customer = Ccc::getModel('customer')->load($customerId);
			if (!$customer) {
				throw new Exception("Data not found", 1);
			}

			$billingAddress = Ccc::getModel('Customer_Address')->load($customer->billing_address_id);
			if (!$billingAddress) {
				throw new Exception("Data not found", 1);
			}

			$shippingAddress = Ccc::getModel('Customer_Address')->load($customer->shipping_address_id);
			if (!$shippingAddress) {
				throw new Exception("Data not found", 1);
			}

			$edit = $layout->createBlock('customer_Edit')->setData(['customer'=>$customer, 'billingAddress' => $billingAddress, 'shippingAddress' => $shippingAddress]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request.", 1);
			}
			
			$customer = $this->_saveCustomer();
			$billingAddress = $this->_saveBillingAddress($customer);
			$shippingAddress = $this->_saveShippingAddress($customer);
			
			$customer->billing_address_id = $billingAddress->address_id;
			$customer->shipping_address_id = $shippingAddress->address_id;

			unset($customer->updated_at);
			$final = $customer->save(); 
			if (!$final) {
				throw new Exception("Data not found.", 1);
			}

			$this->getView()->getMessage()->addMessages('Customer data saved Successfully.');
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
		$this->redirect('grid', null, [], true);
	}

	public function _saveCustomer()
	{
		try {
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
				}else{
					return $customer;
				}

			} catch (Exception $e) {
				Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
			}		
	}

	public function _saveBillingAddress($customer)
	{
		try {
			$billingPost = Ccc::getModel('Core_Request')->getPost('billingAddress');
			if (!$billingPost) {
				throw new Exception("Biiling data not found.", 1);
			}


			$billingAddress = $customer->getBillingAddress();
			if (!$billingAddress) {
				$billingAddress = Ccc::getModel('Customer_Address');
				$billingAddress->customer_id = $customer->customer_id;
			}

			$billingAddress->setData($billingPost);
			if (!$billingAddress->save()) {
				throw new Exception("Billing Address not saved.", 1);
			} else {
				return $billingAddress;
			}
			
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}

			$this->redirect('grid', null, [], true);
	}

	public function _saveShippingAddress($customer)
	{
		try {
			$shippingPost = Ccc::getModel('Core_Request')->getPost('shippingAddress');
			// echo "<pre>";
			// print_r($shippingPost);
			if (!$shippingPost) {
				throw new Exception("Data not found.", 1);
			}

			$shippingAddress = $customer->getShippingAddress();
			if (!$shippingAddress) {
				$shippingAddress = Ccc::getModel('Customer_Address');
				$shippingAddress->customer_id = $customer->customer_id;
			}

			$shippingAddress->setData($shippingPost);
			if (!$shippingAddress->save()) {
				throw new Exception("Shipping Address Data not saved.", 1);
			} else {
				return $shippingAddress;
			}
			
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
			
		}
	}


	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$customerId = Ccc::getModel('Core_Request')->getParam('id');
			echo "<pre>";
			if (!$customerId) {
				throw new Exception("ID not found.", 1);
			}

			$customer = Ccc::getModel('Customer')->load($customerId);
			$result = $customer->delete();
			print_r($result);
			if (!$result) {
				throw new Exception("Customer data not deleted.", 1);
			}

			$address = Ccc::getModel('Customer_Address')->load($customerId);
			$result = $address->delete();
			print_r($result);
			die;
			if (!$result) {
				throw new Exception("Address data not deleted.", 1);
			} else {
				$this->getView()->getMessage()->addMessages('Customer data deleted Successfully.');
			}
			
		} catch (Exception $e) {
			$this->getView()->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		
		$this->redirect('grid', null, [], true);
	}
}

?>
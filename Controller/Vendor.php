<?php

class Controller_Vendor extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Vendor_Grid();
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
			$vendor = Ccc::getModel('Vendor');
			$address = Ccc::getModel('Vendor_Address');
			$edit = $layout->createBlock('Vendor_Edit')->setData(['vendor'=>$vendor, 'address' => $address]);
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
			$vendorId = (int) Ccc::getModel('Core_Request')->getParam('vendor_id');
			if (!$vendorId) {
				throw new Exception("Invalid ID", 1);
			}

			$layout = $this->getLayout();
			$vendor = Ccc::getModel('Vendor')->load($vendorId);
			if (!$vendor) {
				throw new Exception("Data not found", 1);
			}
			$address = Ccc::getModel('Vendor_Address')->load($vendorId);
			if (!$address) {
				throw new Exception("Data not found", 1);
			}
			$edit = $layout->createBlock('Vendor_Edit')->setData(['vendor'=>$vendor, 'address' => $address]);
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
				throw new Exception("Invalid request.", 1);
			}
			
			$vendorPost = Ccc::getModel('Core_Request')->getPost('vendor');
			if (!$vendorPost) {
				throw new Exception("Data not found.", 1);
			}

			$vendorId = (int) Ccc::getModel('Core_Request')->getParam('vendor_id');
			if ($vendorId) {
				$vendor = Ccc::getModel('Vendor')->load($vendorId);
				if (!$vendor) {
					throw new Exception("Data not found.", 1);
				}
				$vendor->updated_at = date('Y-m-d h-i-sA');
			} else {
				$vendor = Ccc::getModel('Vendor');
				$vendor->created_at = date('Y-m-d h-i-sA');
			}

			$vendor->setData($vendorPost);
			if (!$vendor->save()) {
				throw new Exception("Data not saved.", 1);
			}
			
			$addressPost = Ccc::getModel('Core_Request')->getPost('address');
			if (!$addressPost) {
				throw new Exception("Data not found.", 1);
			}

			$vendorId = (int) Ccc::getModel('Core_Request')->getParam('vendor_id');
			if ($vendorId) {
				$address = Ccc::getModel('Vendor_Address')->load($vendorId);
				if (!$address) {
					throw new Exception("Data not found.", 1);
				}
				$address->address_id = $vendor->vendor_id;
			} else {
				$address = Ccc::getModel('Vendor_Address');
				$address->vendor_id = $vendor->vendor_id;
			}

			$address->setData($addressPost);

			if (!$address->save()) {
				throw new Exception("Data not saved.", 1);
			}

			$this->getMessage()->addMessages('Data saved successfully.');
			$this->redirect('grid', null, [], true);
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
			$this->redirect('grid', null, [], true);
	}

	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$vendorId = Ccc::getModel('Core_Request')->getParam('vendor_id');
			if (!$vendorId) {
				throw new Exception("Invalid id.", 1);
			}
			$vendor = Ccc::getModel('Vendor')->load($vendorId);
			$result = $vendor->delete();
			

			$address = Ccc::getModel('Vendor_Address')->load($vendorId);
			$result = $address->delete();
			if (!$result) {
				throw new Exception("Address not deleted", 1);
			} else {
				$this->getMessage()->addMessages('Data deleted successfully.');
			}

		} catch (Exception $e) {
		}
		$this->redirect('grid', null, [], true);
	}
}
?>
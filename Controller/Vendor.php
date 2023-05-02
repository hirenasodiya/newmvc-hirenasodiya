<?php

class Controller_Vendor extends Controller_Core_Action
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
			$gridHtml = $layout->createBlock('Vendor_Grid');
			if ($this->getRequest()->isPost()) {
				if ($recordPerPage = (int) $this->getRequest()->getPost('selectrrp')) {
					$gridHtml->getPager()->setRecordPerPage($recordPerPage);
				}
			}

			$gridHtml = $gridHtml->tohtml();
			@header("Content-Type:application/json");
			echo json_encode(['html' => $gridHtml, 'element' => 'content-html']);

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
			$edit = $layout->createBlock('Vendor_Edit')->setData(['vendor'=>$vendor, 'address' => $address])->toHtml();

			echo json_encode(['html' => $edit, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
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
			$editHtml = $layout->createBlock('Vendor_Edit')->setData(['vendor'=>$vendor, 'address' => $address])->toHtml();
			$this->getResponse()->jsonResponse(['html' => $editHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
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

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Vendor_Grid')->toHtml();
			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
	}

	public function deleteAction()
	{
		try {
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
			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Vendor_Grid')->toHtml();
			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
	}
}
?>
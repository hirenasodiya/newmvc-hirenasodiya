<?php

class Controller_Shippingmethod extends Controller_Core_Action
{
	public function indexAction()
	{
		try {
			$layout = $this->getLayout();
			$indexBlock = $layout->createBlock('Core_Template')->setTemplate('core/index.phtml');
			$layout->getChild('content')->addChild('index',$indexBlock);
			$this->renderLayout();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);

		}
	}

	public function gridAction()
	{
		try {

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('shippingmethod_Grid');
			if ($this->getRequest()->isPost()) {
				if ($recordPerPage = (int) $this->getRequest()->getPost('selectrrp')) {
					$gridHtml->getPager()->setRecordPerPage($recordPerPage);
				}
			}

			$gridHtml = $gridHtml->tohtml();
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
			$shippingMethod = Ccc::getModel('shippingmethod');
			$addHtml = $layout->createBlock('shippingMethod_Edit')->setData(['shippingmethod'=>$shippingMethod])->toHtml();

			echo json_encode(['html' => $addHtml, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$shippingMethodId = (int) Ccc::getModel('Core_Request')->getParam('shipping_method_id');
			if (!$shippingMethodId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$shippingMethod = Ccc::getModel('shippingmethod')->load($shippingMethodId);

			if (!$shippingMethod) {
				throw new Exception("Invalid Request", 1);
			}

			$editHtml = $layout->createBlock('shippingMethod_Edit')->setData(['shippingmethod'=>$shippingMethod])->toHtml();

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

			$shippingMethods = Ccc::getModel('Core_Request')->getPost('shippingmethod');
			if (!$shippingMethods) {
				throw new Exception("Invalid data posted", 1);
			}

			$shippingMethodId =  Ccc::getModel('Core_Request')->getParam('shipping_method_id');
			if ($shippingMethodId) {
				$shippingMethod = Ccc::getModel('ShippingMethod')->load($shippingMethodId);
				if (!$shippingMethod) {
					throw new Exception("Invalid Id", 1);
				}
				$shippingMethod->updated_at = date("Y-m-d h:i:sA");
			}
			else
			{
				$shippingMethod = Ccc::getModel('ShippingMethod');
				$shippingMethod->created_at = date('Y-m-d h:i:sA');
			}

			$shippingMethod->setData($shippingMethods);
			if (!$shippingMethod->save()) {
				throw new Exception("Unable to save", 1);
			}
			else{
				$attributePost = Ccc::getModel('Core_Request')->getPost('attribute');

				foreach ($attributePost as $backendType => $value) {
					foreach ($value as $attributeId => $v) {
						if (is_array($v)) {
							$v = implode(",", $v);
						}

						$model = Ccc::getModel('Core_table');
						$resource = $model->getResource()->setResourceName("shipping_method_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `shipping_method_{$backendType}` (`entity_id`,`attribute_id`,`value`) VALUES('{$shippingMethod->getId()}','{$attributeId}','{$v}') ON DUPLICATE KEY UPDATE `value` ='{$v}'";

						$model->getResource()->getAdapter()->query($query);
					}
				}
			}
			
			$this->getMessage()->addMessages("Data save successfully.", Model_Core_Message::SUCCESS);

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('shippingmethod_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

			} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}


	public function deleteAction()
	{
		try {
			$id =  Ccc::getModel('Core_Request')->getParam('shipping_method_id');
			if (!$id) {
				throw new Exception("Id not found", 1);
			}
			$shippingMehtod = Ccc::getModel('ShippingMethod')->load($id);
			$result = $shippingMehtod->delete();
			if(!$result)
			{
				throw new Exception("Deletion failed", 1);
			}
			$this->getMessage()->addMessages('Data deleted successfully');
			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Shippingmethod_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}


?>
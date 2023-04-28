<?php

class Controller_Paymentmethod extends Controller_Core_Action
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
			$gridHtml = $layout->createBlock('Paymentmethod_Grid');
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
			$paymentMethod = Ccc::getModel('paymentmethod');
			$addHtml = $layout->createBlock('Paymentmethod_Edit')->setData(['paymentmethod'=>$paymentMethod])->toHtml();

			echo json_encode(['html' => $addHtml, 'element' => 'content-html']);
			@header("Content-Type:application/json");


		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$paymentMethodId = (int) Ccc::getModel('Core_Request')->getParam('payment_method_id');
			if (!$paymentMethodId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$paymentMethod = Ccc::getModel('Paymentmethod')->load($paymentMethodId);

			if (!$paymentMethod) {
				throw new Exception("Invalid Request", 1);
			}

			$editHtml = $layout->createBlock('Paymentmethod_Edit')->setData(['paymentmethod'=>$paymentMethod])->toHtml();

			$this->getResponse()->jsonResponse(['html' => $editHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request.", 1);
			}

			$paymentMethods = Ccc::getModel('Core_Request')->getPost('paymentmethod');
			if (!$paymentMethods) {
				throw new Exception("Invalid data posted", 1);
			}

			$paymentMethodId =  Ccc::getModel('Core_Request')->getParam('payment_method_id');
			if ($paymentMethodId) {
				$paymentMethod = Ccc::getModel('PaymentMethod')->load($paymentMethodId);
				if (!$paymentMethod) {
					throw new Exception("Invalid Id", 1);
				}
				$paymentMethod->updated_at = date("Y-m-d h:i:sA");
			}
			else
			{
				$paymentMethod = Ccc::getModel('PaymentMethod');
				$paymentMethod->created_at = date('Y-m-d h:i:sA');
			}

			$paymentMethod->setData($paymentMethods);
			if (!$paymentMethod->save()) {
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
						$resource = $model->getResource()->setResourceName("payment_method_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `payment_method_{$backendType}` (`entity_id`,`attribute_id`,`value`) VALUES('{$paymentMethod->getId()}','{$attributeId}','{$v}') ON DUPLICATE KEY UPDATE `value` ='{$v}'";

						$model->getResource()->getAdapter()->query($query);
					}
				}
			}
			
			$this->getMessage()->addMessages("Data save successfully.", Model_Core_Message::SUCCESS);

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('paymentMethod_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

			} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function deleteAction()
	{
		try {
			$id =  Ccc::getModel('Core_Request')->getParam('payment_method_id');
			if (!$id) {
				throw new Exception("Id not found", 1);
			}
			$paymentMethod = Ccc::getModel('PaymentMethod')->load($id);
			$result = $paymentMethod->delete();
			if(!$result)
			{
				throw new Exception("Deletion failed", 1);
			}
			$this->getMessage()->addMessages('Data deleted successfully');
			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('PaymentMethod_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
}

?>
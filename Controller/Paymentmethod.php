<?php

class Controller_Paymentmethod extends Controller_Core_Action
{

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Paymentmethod_Grid');
			// $paymentmethod = $grid->getCollection();
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
			$paymentMethod = Ccc::getModel('paymentmethod');
			$edit = $layout->createBlock('Paymentmethod_Edit')->setData(['paymentmethod'=>$paymentMethod]);
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
			$paymentMethodId = (int) Ccc::getModel('Core_Request')->getParam('payment_method_id');
			if (!$paymentMethodId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$paymentMethod = Ccc::getModel('Paymentmethod')->load($paymentMethodId);

			if (!$paymentMethod) {
				throw new Exception("Invalid Request", 1);
			}

			$edit = $layout->createBlock('Paymentmethod_Edit')->setData(['paymentmethod'=>$paymentMethod]);
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
			} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
			$this->redirect('grid', null);
	}

	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
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

		} catch (Exception $e) {
			echo $e->getMessage();
		}
		$this->redirect('grid',null,[],true);
	}
}

?>
<?php

class Controller_Shippingmethod extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('shippingMethod_Grid');
			// $product = $grid->getCollection();
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);

		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$shippingMethod = Ccc::getModel('shippingmethod');
			$edit = $layout->createBlock('shippingMethod_Edit')->setData(['shippingmethod'=>$shippingMethod]);
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
			$shippingMethodId = (int) Ccc::getModel('Core_Request')->getParam('shipping_method_id');
			if (!$shippingMethodId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$shippingMethod = Ccc::getModel('shippingmethod')->load($shippingMethodId);

			if (!$shippingMethod) {
				throw new Exception("Invalid Request", 1);
			}

			$edit = $layout->createBlock('ShippingMethod_Edit')->setData(['shippingmethod'=>$shippingMethod]);
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

			} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);

		}
			$this->redirect('grid', null);
	}


	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
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
			$this->redirect('grid', null, null, true);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);

		}
		$this->redirect('grid',null,[],true);
	}
}


?>
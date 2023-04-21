<?php

class Controller_Item extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('item_Grid');
			// $item = $grid->getCollection();
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$itemId = (int) Ccc::getModel('Core_Request')->getParam('entity_id');
			if (!$itemId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$item = Ccc::getModel('Item')->load($itemId);
			if (!$item) {
				throw new Exception("Invalid Request", 1);
			}
			$edit = $layout->createBlock('item_Edit')->setData(['item'=>$item]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);

		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$item = Ccc::getModel('item');
			$edit = $layout->createBlock('item_Edit')->setData(['item'=>$item]);
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
				throw new Exception("Invalid request", 1);
			}

			$itemPost = Ccc::getModel('Core_Request')->getPost('item');
			$itemId = Ccc::getModel('Core_Request')->getParam('entity_id');
			if ($itemId) {
				$item = Ccc::getModel('item')->load($itemId);
				if (!$item) {
					throw new Exception("Invalid item data", 1);
				}
				$item->updated_at = date('Y-m-d h-i-sA');
			}
			else
			{
				$item = Ccc::getModel('item');
				$item->created_at = date('Y-m-d h-i-sA');
			}
			$item->setData($itemPost);
			$final = $item->save();
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
						$resource = $model->getResource()->setResourceName("item_{$backendType}")->setPrimaryKey('value_id');
						$query = "INSERT INTO `item_{$backendType}` (`entity_id`,`attribute_id`,`value`) VALUES('{$item->getId()}','{$attributeId}','{$v}') ON DUPLICATE KEY UPDATE `value` ='{$v}'";

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
			$id =  Ccc::getModel('Core_Request')->getParam('entity_id');
			if (!$id) {
				throw new Exception("Id not found", 1);
			}
			$item = Ccc::getModel('item')->load($id);
			$result = $item->delete();
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

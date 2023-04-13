<?php

class Controller_Item extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Item_Grid();
			$items = $grid->getItems();
			$layout->getChild('content')->addChild('grid', $grid);
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
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request", 1);
			}

			$items = Ccc::getModel('Core_Request')->getPost('item');
			if (!$items) {
				throw new Exception("Invalid data", 1);
			}

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
			$result = $item->setData($items);
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

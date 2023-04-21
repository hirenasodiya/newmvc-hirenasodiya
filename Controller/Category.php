<?php


class Controller_Category extends Controller_Core_Action
{

	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Category_Grid');
			// $category = $grid->getCollection();
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
			$add = new Block_Category_Edit();
			$layout->getChild('content')->addChild('add', $add);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$this->getMessage()->getSession()->start();
			$layout = $this->getLayout();
			$edit = new Block_Category_Edit();
			$layout->getChild('content')->addChild('edit', $edit);
			$layout->render();
		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}

	}

	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request", 1);
			}

			$categorys = Ccc::getModel('Core_Request')->getPost('category');

			if (!$categorys) {
				throw new Exception("Invalid data posted", 1);
			}

			$categoryId =  Ccc::getModel('Core_Request')->getParam('category_id');
			if ($categoryId) {
				$category = Ccc::getModel('Category')->load($categoryId);
				if (!$category) {
					throw new Exception("Invalid data", 1);
				}
				$category->updated_at = date("Y-m-d h:i:sA");
			}
			else
			{
				$category = Ccc::getModel('Category');
				$category->created_at = date('Y-m-d h:i:sA');
			}

			$category->setData($categorys);
			if (!$category->save()) {
				throw new Exception("Unable to save", 1);
			}else{
				$category->updatePath();
				$this->getMessage()->addMessages("Data save successfully.", Model_Core_Message::SUCCESS);
			}

			} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
			$this->redirect('grid', null);
	}
	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$id =  Ccc::getModel('Core_Request')->getParam('category_id');
			if (!$id) {
				throw new Exception("Id not found", 1);
			}
			$category = Ccc::getModel('category')->load($id);
			$result = $category->delete();
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


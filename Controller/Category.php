<?php


class Controller_Category extends Controller_Core_Action
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
			$gridHtml = $layout->createBlock('Category_Grid')->toHtml();

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
			$category = Ccc::getModel('category');
			$addHtml = $layout->createBlock('category_Edit')->setData(['category'=>$category])->toHtml();

			echo json_encode(['html' => $addHtml, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
			$this->redirect('grid');
		}
	}

	public function editAction()
	{
		try {
			$categoryId = (int) Ccc::getModel('Core_Request')->getParam('category_id');
			if (!$categoryId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$category = Ccc::getModel('category')->load($categoryId);

			if (!$category) {
				throw new Exception("Invalid Request", 1);
			}

			$editHtml = $layout->createBlock('category_Edit')->setData(['category'=>$category])->toHtml();

			$this->getResponse()->jsonResponse(['html' => $editHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}

	}

	public function saveAction()
	{
		try {
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

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Category_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

			} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
	public function deleteAction()
	{
		try {
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
			
			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Category_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
} 


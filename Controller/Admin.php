<?php 

/**
 * 
 */
class Controller_Admin extends Controller_Core_Action
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
			$gridHtml = $layout->createBlock('admin_Grid')->toHtml();

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
			$admin = Ccc::getModel('admin');
			$addHtml = $layout->createBlock('admin_Edit')->setData(['admin'=>$admin])->toHtml();

			echo json_encode(['html' => $addHtml, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$adminId = (int) Ccc::getModel('Core_Request')->getParam('id');
			if (!$adminId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$admin = Ccc::getModel('admin')->load($adminId);

			if (!$admin) {
				throw new Exception("Invalid Request", 1);
			}

			$editHtml = $layout->createBlock('admin_Edit')->setData(['admin'=>$admin])->toHtml();

			$this->getResponse()->jsonResponse(['html' => $editHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			if (!$this->getRequest()->isPost()) {
				throw new Exception("Invalid request.", 1);
			}

			$postData = $this->getRequest()->getPost('admin');

			if (!$postData) {
				throw new Exception("Invalid data posted", 1);
				
			}

			$id = (int) $this->getRequest()->getParam('id');
			if($id){
				$admin = Ccc::getModel('Admin')->load($id);
				if (!$admin) {
					throw new Exception("Invalid id", 1);
					
				}
				 $admin->updated_at = date("Y-m-d h:i:sA");

			}
			else
			{
				$admin = Ccc::getModel('Admin');
				$admin->created_at = date("Y-m-d h:i:sA");
			}

			$admin->setData($postData);

			if (!$admin->save()) {
				throw new Exception("Unable to save", 1);
			};

			$this->getMessage()->addMessages("data save successfully.", Model_Core_Message::SUCCESS);

			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Admin_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);

		}
	}

	public function deleteAction()
	{
		try {
			$id =  Ccc::getModel('Core_Request')->getParam('id');
			if (!$id) {
				throw new Exception("Id not found", 1);
			}
			$admin = Ccc::getModel('Admin')->load($id);
			$result = $admin->delete();
			if(!$result)
			{
				throw new Exception("Deletion failed", 1);
			}
			$this->getMessage()->addMessages('Data deleted successfully');
			$layout = $this->getLayout();
			$gridHtml = $layout->createBlock('Admin_Grid')->toHtml();

			$this->getResponse()->jsonResponse(['html' => $gridHtml, 'element' => 'content-html']);

		} catch (Exception $e) {
			$this->getMessage()->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
}
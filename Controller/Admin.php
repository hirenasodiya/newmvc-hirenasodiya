<?php 

/**
 * 
 */
class Controller_Admin extends Controller_Core_Action
{
	
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Admin_Grid();
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
			$admin = Ccc::getModel('admin');
			$edit = $layout->createBlock('Admin_Edit')->setData(['admin'=>$admin]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function editAction()
	{
		try {
			$this->getMessage()->getSession()->start();
			$adminId = (int) Ccc::getModel('Core_Request')->getParam('id');
			if (!$adminId) {
				throw new Exception("Invalid ID", 1);
			}
			$layout = $this->getLayout();
			$admin = Ccc::getModel('admin')->load($adminId);

			if (!$admin) {
				throw new Exception("Invalid Request", 1);
			}

			$edit = $layout->createBlock('admin_Edit')->setData(['admin'=>$admin]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			$this->getMessage()->getSession()->start();
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

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);

		}
			$this->redirect('grid', null, null, true);
	}
}
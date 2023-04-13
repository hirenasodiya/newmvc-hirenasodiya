<?php


class Controller_Salesman extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Salesman_Grid();
			$layout->getChild('content')->addChild('grid', $grid);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$salesman = Ccc::getModel('salesman');
			$address = Ccc::getModel('salesman_Address');
			$edit = $layout->createBlock('salesman_Edit')->setData(['salesman'=>$salesman, 'address' => $address]);
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
			$salesmanId = (int) Ccc::getModel('Core_Request')->getParam('salesman_id');
			if (!$salesmanId) {
				throw new Exception("Invalid ID", 1);
			}

			$layout = $this->getLayout();
			$salesman = Ccc::getModel('salesman')->load($salesmanId);
			if (!$salesman) {
				throw new Exception("Data not found", 1);
			}
			$address = Ccc::getModel('salesman_Address')->load($salesmanId);
			if (!$address) {
				throw new Exception("Data not found", 1);
			}
			$edit = $layout->createBlock('salesman_Edit')->setData(['salesman'=>$salesman, 'address' => $address]);
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
			
			$salesmanPost = Ccc::getModel('Core_Request')->getPost('salesman');
			if (!$salesmanPost) {
				throw new Exception("Data not found.", 1);
			}

			$salesmanId = (int) Ccc::getModel('Core_Request')->getParam('salesman_id');
			if ($salesmanId) {
				$salesman = Ccc::getModel('Salesman')->load($salesmanId);
				if (!$salesman) {
					throw new Exception("Data not found.", 1);
				}
				$salesman->updated_at = date('Y-m-d h-i-sA');
			} else {
				$salesman = Ccc::getModel('Salesman');
				$salesman->created_at = date('Y-m-d h-i-sA');
			}

			$salesman->setData($salesmanPost);
			if (!$salesman->save()) {
				throw new Exception("Data not saved.", 1);
			}
			
			$addressPost = Ccc::getModel('Core_Request')->getPost('address');
			if (!$addressPost) {
				throw new Exception("Data not found.", 1);
			}

			$salesmanId = (int) Ccc::getModel('Core_Request')->getParam('salesman_id');
			if ($salesmanId) {
				$address = Ccc::getModel('Salesman_Address')->load($salesmanId);
				if (!$address) {
					throw new Exception("Data not found.", 1);
				}
				$address->address_id = $salesman->salesman_id;
			} else {
				$address = Ccc::getModel('Salesman_Address');
				$address->salesman_id = $salesman->salesman_id;
			}

			$address->setData($addressPost);

			if (!$address->save()) {
				throw new Exception("Data not saved.", 1);
			}

			$this->getMessage()->addMessages('Data saved successfully.');
			$this->redirect('grid', null, [], true);
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
			$this->redirect('grid', null, [], true);
	}

	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$salesmanId = Ccc::getModel('Core_Request')->getParam('salesman_id');
			if (!$salesmanId) {
				throw new Exception("Invalid id.", 1);
			}
			$salesman = Ccc::getModel('Salesman')->load($salesmanId);
			$result = $salesman->delete();
			if (!$result) {
				throw new Exception("Data not deleted", 1);
			}

			$address = Ccc::getModel('Salesman_Address')->load($salesmanId);
			$result = $address->delete();
			if (!$result) {
				throw new Exception("Address not deleted", 1);
			} else {
				$this->getMessage()->addMessages('Data deleted successfully.');
			}
		$this->redirect('grid', null, [], true);
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);  
		}
	}
}


?>
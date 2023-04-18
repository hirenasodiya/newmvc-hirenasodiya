<?php
/**
 * 
 */
class Controller_Eav_Attribute extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = $layout->createBlock('Core_Eav_Attribute_Grid');
			$layout->getChild('content')->addChild('grid',$grid);
			$layout->render();

		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$EavAttribute = Ccc::getModel('Core_Eav_Attribute');
			$edit = $layout->createBlock('Core_Eav_Attribute_Edit')->setData(['attribute'=>$EavAttribute]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);

		}
	}

	public function editAction()
	{
		try {
			$attributeId = (int) Ccc::getModel('Core_Request')->getParam('attribute_id');
			$layout = $this->getLayout();
			$attribute = Ccc::getModel('Core_Eav_attribute')->load($attributeId);
			// echo "<pre>";
			// print_r($attribute);
			// die();	

			$EavAttribute = Ccc::getModel('Core_Eav_Attribute');
			$edit = $layout->createBlock('Core_Eav_Attribute_Edit')->setData(['attribute'=>$attribute]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			if (!Ccc::getModel('Core_Request')->isPost()) {
				throw new Exception("Invalid request", 1);
			}

			$attributes = Ccc::getModel('Core_Request')->getPost();
			if (!$attributes) {
				throw new Exception("Invalid data", 1);
			}

			$attributeId = Ccc::getModel('Core_Request')->getParam('attribute_id');
			if ($attributeId) {
				$attribute = Ccc::getModel('Core_Eav_Attribute')->load($attributeId);
				if (!$attribute) {
					throw new Exception("Invalid attribute data", 1);
				}
			}
			else
			{
				$attribute = Ccc::getModel('Core_Eav_attribute');
			}
			$attribute->setData($attributes['attribute']);
			if (!$attribute->save()) {
				throw new Exception("attributesAttribute data not saved.", 1);
			} else {
				$attributeId = $attribute->attribute_id;
				if (array_key_exists('exist', $attributes['option'])) {
					$query = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = {$attributeId}";
					$attributeOptionModel = Ccc::getModel('Core_Eav_Attribute_Option');
					$attributeOption = $attributeOptionModel->fetchAll($query);
					if ($attributeOption) {
						foreach ($attributeOption->getData() as $row) {
							if (!array_key_exists($row->option_id, $attributes['exist']['name'])) {
								$row->setData(['option_id' => $row->option_id]);
								if (!$row->delete()) {
									throw new Exception("data not deleted.", 1);
								}
							}
						}
					}
				}
				if (array_key_exists('new', $attributes['option'])) {
					foreach ($attributes['option']['new'] as $optionData) {
						$option['name'] = $optionData;
						$option['attribute_id'] = $attributeId;
						$attributeOption = Ccc::getModel('Core_Eav_Attribute_Option');
						$attributeOption->setData($option);
						$attributeOption->save();
						unset($option);
					}
				}

			}
			$this->getView()->getMessage()->addMessages('data saved Successfully.');
		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
			$this->redirect('grid', null);
		
	}


	public function deleteAction()
	{
		try {
			Ccc::getModel('Core_Session')->start();
			$attributeId = Ccc::getModel('Core_Request')->getParam('attribute_id');
			if (!$attributeId) {
				throw new Exception("ID not found.", 1);
			}

			$attribute = Ccc::getModel('Core_Eav_Attribute'); 
			$result = $attribute->load($attributeId)->delete();
			if (!$result) {
				throw new Exception("Attribute data not deleted successfully.", 1);
			}
			$this->getView()->getMessage()->addMessages('Attribute data saved Successfully.');

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		$this->redirect('grid', null, [], true);
	}
}
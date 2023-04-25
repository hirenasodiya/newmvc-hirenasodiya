<?php
/**
 * 
 */
class Controller_Eav_Attribute extends Controller_Core_Action
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
			$grid = $layout->createBlock('Core_Eav_Attribute_Grid')->toHtml();
			echo json_encode(['html' => $grid, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->addMessages($e->getMessage(),Model_Core_Message::FAILURE);

		}
	}

	public function addAction()
	{
		try {
			$layout = $this->getLayout();
			$EavAttribute = Ccc::getModel('Core_Eav_Attribute');
			$edit = $layout->createBlock('Core_Eav_Attribute_Edit')->setData(['attribute'=>$EavAttribute])->toHtml();
			
			@header("Content-Type:application/json");
			echo json_encode(['html' => $edit, 'element' => 'content-html']);

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
			$EavAttribute = Ccc::getModel('Core_Eav_Attribute');
			$edit = $layout->createBlock('Core_Eav_Attribute_Edit')->setData(['attribute'=>$attribute])->toHtml();
			@header("Content-Type:application/json");
			echo json_encode(['html' => $edit, 'element' => 'content-html']);

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	public function saveAction()
	{
		try {
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
				if (array_key_exists('option',$attributes)) {
				if (array_key_exists('exist', $attributes['option'])) {
					$query = "SELECT * FROM `eav_attribute_option` WHERE `attribute_id` = {$attributeId}";
					$attributeOptionModel = Ccc::getModel('Core_Eav_Attribute_Option');
					$attributeOption = $attributeOptionModel->fetchAll($query);
					if ($attributeOption) {
						foreach ($attributeOption->getData() as $row) {
							if (!array_key_exists($row->option_id, $attributes['option']['exist'])) {
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

			}
			$this->getView()->getMessage()->addMessages('data saved successfully.');

			$layout = $this->getLayout();
			$grid = $layout->createBlock('Core_Eav_Attribute_Grid')->toHtml();
			
			echo json_encode(['html' => $grid, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
		
	}


	public function deleteAction()
	{
		try {
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

			$layout = $this->getLayout();
			$grid = $layout->createBlock('Core_Eav_Attribute_Grid')->toHtml();
			echo json_encode(['html' => $grid, 'element' => 'content-html']);
			@header("Content-Type:application/json");

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
}
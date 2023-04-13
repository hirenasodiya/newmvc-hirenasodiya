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
			$grid = new Block_Eav_Attribute_Grid();
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
			$EavAttribute = Ccc::getModel('Eav_Attribute');
			$edit = $layout->createBlock('Eav_Attribute_Edit')->setData(['attribute'=>$EavAttribute]);
			$layout->getChild('content')->addChild('edit',$edit);
			$layout->render();
		} catch (Exception $e) {
			Ccc::getModel('Core_View')->getMessage()->add($e->getMessage(),Model_Core_Message::FAILURE);
		}
	}
}
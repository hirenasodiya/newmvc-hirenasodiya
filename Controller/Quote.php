<?php

class Controller_Quote extends Controller_Core_Action
{
	public function newAction()
	{
		try {
			$layout = $this->getLayout();
			$order = $layout->createBlock('Order_New');
			// $order = $order->getCollection();
			$layout->getChild('content')->addChild('grid',$order);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
}

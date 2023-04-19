<?php

class Controller_Quote extends Controller_Core_Action
{
	public function quoteAction()
	{
		try {
			$layout = $this->getLayout();
			$quote = new Block_Order_Quote();
			// $Orders = $Quote->getOrders();
			$layout->getChild('content')->addChild('Quote', $quote);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}
}

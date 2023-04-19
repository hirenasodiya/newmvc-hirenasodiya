<?php

class Controller_Order extends Controller_Core_Action
{
	public function gridAction()
	{
		try {
			$layout = $this->getLayout();
			$grid = new Block_Order_Grid();
			// $Orders = $grid->getOrders();
			$layout->getChild('content')->addChild('grid', $grid);
			$layout->render();

		} catch (Exception $e) {
			Ccc::getModel('Core_Message')->addMessages($e->getMessage(), Model_Core_Message::FAILURE);
		}
	}

	
}
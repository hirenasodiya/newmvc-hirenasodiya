<?php

class Block_Paymentmethod_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Paymentmethod');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('payment_method_id',[
			'title' => 'Paymentmethod id',
		]);
		$this->addColumn('name',[
			'title' => 'Name',
		]);
		$this->addColumn('status',[
			'title' => 'Status',
		]);
		$this->addColumn('created_at',[
			'title' => 'Created_at',
		]);
		$this->addColumn('updated_at',[
			'title' => 'Updated_at',
		]);

		return parent::_prepareColumns();
	}

	protected function _prepareActions()
	{
		$this->addAction('edit',[
			'title' => 'Edit',
			'method' => 'getEditUrl',
			'primaryKey' => 'payment_method_id'
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'payment_method_id'
		]);
		
		return parent::_prepareActions();
	}

	protected function _preparebuttons()
	{
		$this->addButton('payment_method_id',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$query = "SELECT * FROM `payment_method`";
		$paymentMethods = Ccc::getModel('Paymentmethod')->fetchAll($query);
		return $paymentMethods;	
	}

}


?>
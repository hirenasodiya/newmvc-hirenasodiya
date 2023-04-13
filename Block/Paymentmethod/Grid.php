<?php

class Block_Paymentmethod_Grid extends Block_Core_Template
{
	protected $columns = [];
	protected $action = [];

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('paymentmethod/grid.phtml');
	}

	public function getColumns()
	{
		return $this->columns;
	}

	public function setColumns(array $columns)
	{
		$this->columns = $columns;
		return $this;
	}

	public function addColumn($key, $value)
	{
		$this->columns[$key] = $value;
		return $this;
	}

	public function removeColumn($key)
	{
		unset($this->columns[$key]);
		return $this;
	}

	public function getColumn($key)
	{
		if (array_key_exists($key, $this->columns)) {
			return $this->columns[$key];
		}
		return null;
	}

	public function prepareColumn()
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
		$this->addColumn('created_id',[
			'title' => 'Created_at',
		]);
		$this->addColumn('updated_id',[
			'title' => 'Updated_at',
		]);
	}

	public function getPaymentmethods()
	{
		$query = "SELECT * FROM `payment_method`";
		$paymentMethods = Ccc::getModel('Paymentmethod')->fetchAll($query);
		return $paymentMethods;	
	}

}


?>
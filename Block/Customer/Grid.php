<?php 

/**
 * 
 */
class Block_Customer_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage customer');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('customer_id',[
			'title' => 'customer Id',
		]);
		$this->addColumn('first_name',[
			'title' => 'First name',
		]);
		$this->addColumn('last_name',[
			'title' => 'Last name',
		]);
		$this->addColumn('email',[
			'title' => 'Email',
		]);
		$this->addColumn('gender',[
			'title' => 'gender',
		]);
		$this->addColumn('mobile',[
			'title' => 'Mobile',
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
			'primaryKey' => 'customer_id',
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'customer_id',
		]);
		
		return parent::_prepareActions();
	}

	protected function _preparebuttons()
	{
		$this->addButton('customer',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}


	public function getCollection()
	{
		$query = "SELECT count('customer_id') FROM `customer` ORDER BY `customer_id` DESC";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$this->getPager()->setTotalRecord($totalRecord)->calculate();

		$query = "SELECT * FROM `customer` ORDER BY `customer_id` DESC LIMIT {$this->getPager()->getStartLimit()},{$this->getPager()->getRecordPerPage()}";
		$customers = Ccc::getModel('customer')->fetchAll($query);
		return $customers;	
	}
}
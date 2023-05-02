<?php 

/**
 * 
 */
class Block_Vendor_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Vendor');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('vendor_id',[
			'title' => 'vendor Id',
		]);
		$this->addColumn('first_name',[
			'title' => 'First name',
		]);
		$this->addColumn('last_name',[
			'title' => 'vendor id',
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
			'primaryKey' => 'vendor_id' 
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'vendor_id' 
		]);
		
		return parent::_prepareActions();
	}

	protected function _preparebuttons()
	{
		$this->addButton('vendor',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}
	
	public function getCollection()
	{
		$query = "SELECT count('vendor_id') FROM `vendor` ORDER BY `vendor_id` DESC";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$this->getPager()->setTotalRecord($totalRecord)->calculate();

		$query = "SELECT * FROM `vendor` ORDER BY `vendor_id` DESC LIMIT {$this->getPager()->getStartLimit()},{$this->getPager()->getRecordPerPage()}";
		$vendors = Ccc::getModel('vendor')->fetchAll($query);
		return $vendors;	
	}
}
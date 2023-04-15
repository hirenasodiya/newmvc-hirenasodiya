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
			'method' => 'getEditUrl' 
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl'
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

	public function getEditUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['vendor_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['vendor_id' => $row->getId()], true);
	}
	
	public function getCollection()
	{
		$sql = "SELECT * FROM `Vendor`";
		$vendor = Ccc::getModel('Vendor')->fetchAll($sql);
		return $vendor;
	}
}
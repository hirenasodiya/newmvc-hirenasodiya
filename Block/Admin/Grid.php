<?php 
/**
 * 
 */
class Block_Admin_Grid extends Block_Core_Grid
{
	
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage admin');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('admin_id',[
			'title' => 'admin id',
		]);
		$this->addColumn('email',[
			'title' => 'Email',
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
			'primaryKey' => 'id' 
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'id' 
		]);
		
		return parent::_prepareActions();
	}

	protected function _preparebuttons()
	{
		$this->addButton('admin',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `admin`";
		$admins = Ccc::getModel('Admin')->fetchAll($sql);
		return $admins;
	}

	
}
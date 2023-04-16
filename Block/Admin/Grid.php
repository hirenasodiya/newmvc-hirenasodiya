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
		$this->addButton('admin',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getEditUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['admin_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['admin_id' => $row->getId()], true);
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `admin`";
		$admins = Ccc::getModel('Admin')->fetchAll($sql);
		return $admins;
	}

	
}
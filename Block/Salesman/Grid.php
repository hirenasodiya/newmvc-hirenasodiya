<?php 

/**
 * 
 */
class Block_Salesman_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage salesman');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('salesman_id',[
			'title' => 'salesman Id',
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
		$this->addColumn('company',[
			'title' => 'Company',
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
		$this->addAction(null,[
			'title' => 'Prices',
			'method' => 'getPriceUrl'
		]);
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
		$this->addButton('salesman',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getPriceUrl($row, $key)
	{
		return  $this->getUrl($key, 'salesman_price' , ['salesman_id' => $row->getId()], true);
	}

	public function getEditUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['salesman_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['salesman_id' => $row->getId()], true);
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `salesman`";
		$salesman = Ccc::getModel('Salesman')->fetchAll($sql);
		return $salesman;
	}
}
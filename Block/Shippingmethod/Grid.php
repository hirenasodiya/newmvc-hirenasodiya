<?php 
/**
 * 
 */
class Block_Shippingmethod_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage shippingmethod');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('shipping_method_id',[
			'title' => 'shippingmethod id',
		]);
		$this->addColumn('name',[
			'title' => 'Name',
		]);
		$this->addColumn('amount',[
			'title' => 'Amount',
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
		$this->addButton('shipping_method_id',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getEditUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['shipping_method_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['shipping_method_id' => $row->getId()], true);
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `shipping_method`";
		$shippingMethod = Ccc::getModel('Shippingmethod')->fetchAll($sql);
		return $shippingMethod;
	}
}
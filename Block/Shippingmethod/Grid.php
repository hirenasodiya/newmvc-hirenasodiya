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
			'method' => 'getEditUrl',
			'primaryKey' => 'shipping_method_id'
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'shipping_method_id'
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

	public function getCollection()
	{
		$query = "SELECT count('shipping_method_id') FROM `shipping_method`";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);

		$currentPage = Ccc::getModel('Core_Request')->getParam('p');
		$pager = $this->getPager();
		$pager->calculate($totalRecord, $currentPage);
		$this->setPager($pager);

		$query = "SELECT * FROM `shipping_method` LIMIT $pager->startLimit, $pager->recordPerPage";
		$shippingmethods = Ccc::getModel('shippingmethod')->fetchAll($query);
		return $shippingmethods;	
	}
}
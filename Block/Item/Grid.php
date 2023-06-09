<?php

class Block_Item_Grid extends Block_Core_Grid
{

	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Item');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('entity_id',[
			'title' => 'product Id',
		]);
		$this->addColumn('SKU',[
			'title' => 'SKU',
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
			'primaryKey' => 'entity_id'
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'entity_id'
		]);
		
		return parent::_prepareActions();
	}

	protected function _preparebuttons()
	{
		$this->addButton('product',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$query = "SELECT * FROM `item` WHERE 1";
		$items = Ccc::getModel('item')->fetchAll($query);
		return $items;	
	}

}


?>
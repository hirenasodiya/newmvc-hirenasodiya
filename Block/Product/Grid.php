<?php

class Block_Product_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
        $this->prePareColumns();
        $this->prePareActions();
        $this->prePareButtons();
        $this->setTitle('Manage Product');
	}

	protected function prepareColumns()
	{
		$this->addColumn('product_id',[
			'title' => 'product Id',
		]);
		$this->addColumn('name',[
			'title' => 'name',
		]);
		$this->addColumn('SKU',[
			'title' => 'SKU',
		]);
		$this->addColumn('cost',[
			'title' => 'cost',
		]);
		$this->addColumn('price',[
			'title' => 'Price',
		]);
		$this->addColumn('quantity',[
			'title' => 'Quantity',
		]);
		$this->addColumn('description',[
			'title' => 'description',
		]);
		$this->addColumn('status',[
			'title' => 'Status',
		]);
		$this->addColumn('color',[
			'title' => 'Color',
		]);
		$this->addColumn('material',[
			'title' => 'Material',
		]);
		$this->addColumn('created_at',[
			'title' => 'Created_at',
		]);
		$this->addColumn('updated_at',[
			'title' => 'Updated_at',
		]);
		$this->addColumn('base',[
			'title' => 'Base Id',
		]);
		$this->addColumn('thumbnail',[
			'title' => 'Thumbnail Id',
		]);
		$this->addColumn('small',[
			'title' => 'Small Id',
		]);

		return parent::_prepareColumns();
	}

	protected function prepareActions()
	{
		$this->addAction(null,[
			'title' => 'Media',
			'method' => 'getMediaUrl', 
			'primaryKey' => 'product_id'
		]);
		$this->addAction('edit',[
			'title' => 'Edit',
			'method' => 'getEditUrl',
			'primaryKey' => 'product_id'
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'product_id'
		]);

		return parent::_prepareActions();
	}

	protected function preparebuttons()
	{
		$this->addButton('product',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getMediaUrl($row, $key)
	{
		return  $this->getUrl($key, 'product_media' , ['product_id' => $row->getId()]);
	}


	public function getCollection()
	{
		$query = "SELECT count('product_id') FROM `product` ORDER BY `product_id` DESC";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$this->getPager()->setTotalRecord($totalRecord)->calculate();

		$query = "SELECT * FROM `product` ORDER BY `product_id` DESC LIMIT {$this->getPager()->getStartLimit()},{$this->getPager()->getRecordPerPage()}";
		$products = Ccc::getModel('Product')->fetchAll($query);
		return $products;	
	}

}


?>
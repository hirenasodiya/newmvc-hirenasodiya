<?php

class Block_Product_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Product');
	}

	protected function _prepareColumns()
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

	protected function _prepareActions()
	{
		$this->addAction(null,[
			'title' => 'Media',
			'method' => 'getMediaUrl' 
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
		$this->addButton('product',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getMediaUrl($row, $key)
	{
		return  $this->getUrl($key, 'product_media' , ['product_id' => $row->getId()], true);
	}

	public function getEditUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['product_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['product_id' => $row->getId()], true);
	}

	public function getCollection()
	{
		$query = "SELECT * FROM `product` WHERE 1";
		$products = Ccc::getModel('Product')->fetchAll($query);
		return $products;	
	}

}


?>
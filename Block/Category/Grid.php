<?php 
/**
 * 
 */
class Block_Category_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Category');
	}

	public function _prepareColumns()
	{
		$this->addColumn('category_id',[
			'title' => 'Category Id'
		]);
		$this->addColumn('path',[
			'title' => 'Name'
		]);
		$this->addColumn('status',[
			'title' => 'Status'
		]);
		$this->addColumn('description',[
			'title' => 'Description'
		]);
		$this->addColumn('created_at',[
			'title' => 'Created_at'
		]);
		$this->addColumn('updated_at',[
			'title' => 'Updated_at'
		]);

		return parent::_prepareColumns();
	}

	public function _prepareActions()
	{
		$this->addAction('edit',[
			'title' => 'edit',
			'method' => 'getEditUrl',
			'primaryKey' => 'category_id' 

		]);
		$this->addAction('delete',[
			'title' => 'delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'category_id' 
		]);

		return parent::_prepareActions();
	}

	public function _prepareButtons()
	{
		$this->addButton('category',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getCollection()
	{
		$query = "SELECT count('category_id') FROM `category` WHERE `parent_id` > 1";
		$totalRecord = Ccc::getModel('Core_Adapter')->fetchOne($query);
		$this->getPager()->setTotalRecord($totalRecord)->calculate();

		$query = "SELECT * FROM `category` WHERE `parent_id` > 0 ORDER BY `category_id` DESC LIMIT {$this->getPager()->getStartLimit()},{$this->getPager()->getRecordPerPage()}";
		$categories = Ccc::getModel('category')->fetchAll($query);
		return $categories;	
	}
}
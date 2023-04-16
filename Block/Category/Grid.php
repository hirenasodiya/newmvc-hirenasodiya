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
		$this->addColumn('name',[
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
			'method' => 'getEditUrl' 

		]);
		$this->addAction('delete',[
			'title' => 'delete',
			'method' => 'getDeleteUrl'
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
	
	public function getEditUrl($row, $key)
	{
		return $this->getUrl($key, null, ['category_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return $this->getUrl($key, null, ['category_id' => $row->getId()], true);
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `category`";
		$category = Ccc::getModel('Category')->fetchAll($sql);
		return $category;
	}
}
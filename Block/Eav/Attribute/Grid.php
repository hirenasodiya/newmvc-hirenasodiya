<?php 

/**
 * 
 */
class Block_Eav_Attribute_Grid extends Block_Core_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setTitle('Manage Eav Attribute');
	}

	protected function _prepareColumns()
	{
		$this->addColumn('attribute_id',[
			'title' => 'attribute_id',
		]);
		$this->addColumn('entity_type_id',[
			'title' => 'entity_type_id',
		]);
		$this->addColumn('code',[
			'title' => 'code',
		]);
		$this->addColumn('backend_type',[
			'title' => 'backend_type',
		]);
		$this->addColumn('name',[
			'title' => 'name',
		]);
		$this->addColumn('status',[
			'title' => 'status',
		]);
		$this->addColumn('backend_model',[
			'title' => 'backend_model',
		]);
		$this->addColumn('input_type',[
			'title' => 'input_type',
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
		$this->addButton('attribute',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}

	public function getEditUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['attribute_id' => $row->getId()], true);
	}

	public function getDeleteUrl($row, $key)
	{
		return  $this->getUrl($key, null , ['attribute_id' => $row->getId()], true);
	}

	public function getCollection()
	{
		$sql = "SELECT * FROM `eav_attribute`";
		$attributes = Ccc::getModel('Eav_Attribute')->fetchAll($sql);
		return $attributes;
	}
}
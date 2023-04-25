<?php 

/**
 * 
 */
class Block_Core_Eav_Attribute_Grid extends Block_Core_Grid
{
	
	function __construct()
	{
		parent::__construct();
		$this->prePareColumns();
        $this->prePareActions();
        $this->prePareButtons();
        $this->setTitle('Manage Eav');
	}

	protected function prepareColumns()
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
			'title' => 'Status',
		]);

		return parent::_prepareColumns();
	}

	protected function prepareActions()
	{
		$this->addAction('edit',[
			'title' => 'Edit',
			'method' => 'getEditUrl',
			'primaryKey' => 'attribute_id'
		]);
		$this->addAction('delete',[
			'title' => 'Delete',
			'method' => 'getDeleteUrl',
			'primaryKey' => 'attribute_id'
		]);

		
		return parent::_prepareActions();
	}

	protected function preparebuttons()
	{
		$this->addButton('eav_attribute',[
			'title' => 'Add New',
			'url' => $this->getUrl('add')
		]);
		return parent::_prepareButtons();
	}


	public function getCollection()
	{
		$sql = "SELECT * FROM `eav_attribute` ";
		$attributes = Ccc::getModel('Core_Eav_Attribute')->fetchAll($sql);
		return $attributes;
	}
}
<?php

class Block_Core_Grid extends Block_Core_Template
{
	protected $_columns = [];
	protected $_actions = [];
	protected $_buttons = [];
	protected $_title = null;
	protected $pager = null;
	
	public function setPager($pager)
	{
		$this->pager = $pager;
		return $this;
	}

	public function getPager()
	{
		if ($this->pager) {
			return $this->pager;
		}

		$pager = new Model_Core_Pager();
		$this->setPager($pager);
		return $pager;
	}
	
	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/grid.phtml');
		$this->_prepareColumns();
		$this->_prepareActions();
		$this->_prepareButtons();
		$this->setTitle('Manage Grid');
	}

	public function getColumns()
	{
		return $this->_columns;
	}

	public function setColumns(array $columns)
	{
		$this->_columns = $columns;
		return $this;
	}

	public function addColumn($key, $value)
	{
		$this->_columns[$key] = $value;
		return $this;
	}

	public function removeColumn($key)
	{
		unset($this->_columns[$key]);
		return $this;
	}

	public function getColumn($key)
	{
		if (array_key_exists($key, $this->_columns)) {
			return $this->_columns[$key];
		}
		return null;
	}

	protected function _prepareColumns()
	{
		return $this;
	}

	public function getActions()
	{
		return $this->_actions;
	}

	public function setActions(array $actions)
	{
		$this->_actions = $actions;
		return $this;
	}

	public function addAction($key, $value)
	{
		$this->_actions[$key] = $value;
		return $this;
	}

	public function removeAction($key)
	{
		unset($this->_actions[$key]);
		return $this;
	}

	public function getAction($key)
	{
		if (array_key_exists($key, $this->_actions)) {
			return $this->_actions[$key];
		}
		return null;
	}

	protected function _prepareActions()
	{
		return $this;
	}

	


	public function getColumnValue($row, $key)
	{
		if ($key == 'status') {
			return $row->getStatusText();
		}
		return $row->$key;
	}

	public function getButtons()
	{
		return $this->_buttons;
	}

	public function setButtons(array $buttons)
	{
		$this->_buttons = $buttons;
		return $this;
	}

	public function addButton($key, $value)
	{
		$this->_buttons[$key] = $value;
		return $this;
	}

	public function removebutton($key)
	{
		unset($this->_buttons[$key]);
		return $this;
	}

	public function getButton($key)
	{
		if (array_key_exists($key, $this->_buttons)) {
			return $this->_buttons[$key];
		}
		return null;
	}

	public function getEditUrl($row, $key, $primaryKey)
	{
		return $this->getUrl($key,'',[ $primaryKey =>$row->getId()]);
	}

	public function getDeleteUrl($row, $key, $primaryKey)
	{
		return $this->getUrl($key,'',[ $primaryKey =>$row->getId()]);
	}

	protected function _preparebuttons()
	{
		return $this;
	}

	public function setTitle($title)
	{
		$this->_title = $title;
		return $this; 
	}
    
    public function getTitle()
	{
		return $this->_title;
	}

}


?>
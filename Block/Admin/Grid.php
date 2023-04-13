<?php 
/**
 * 
 */
class Block_Admin_Grid extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('admin/grid.phtml');
	}

	public function getAdmins()
	{
		$sql = "SELECT * FROM `admin`";
		$admins = Ccc::getModel('Admin')->fetchAll($sql);
		return $admins;
	}

	
}
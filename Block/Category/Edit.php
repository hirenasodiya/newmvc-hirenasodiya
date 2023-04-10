<?php
				
/**
 * 
 */
class Block_Category_Edit extends Block_Core_Template
{
	
	function __construct()
	{
		parent::__construct();
		$this->setTemplate('category/edit.phtml');
	}

	public function getCategory()
	{
		$categoryId = Ccc::getModel('Core_Request')->getParam('category_id');
		if (!$categoryId) {
			$category = Ccc::getModel('Category');
		}else{
			$category = Ccc::getModel('Category')->load($categoryId);
		}
		return $category;
	}
}

<?php 

class Block_Core_Upload extends Block_Core_Template
{
	public function __construct()
	{
		parent::__construct();
        $this->setTemplate('core/upload.phtml');
	}
}


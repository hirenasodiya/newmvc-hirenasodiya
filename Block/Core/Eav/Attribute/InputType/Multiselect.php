<?php 

/**
 * 
 */
class Block_Core_Eav_Attribute_InputType_Multiselect extends Block_Core_Template
{
    protected $_attribute = null;
    protected $_row = null;
    
	function __construct()
    {
        parent::__construct();
        $this->setTemplate('core/eav/attribute/inputtype/multiselect.phtml');
    }

    public function setRow($row)
    {
        $this->_row = $row;
        return $this;
    }

    public function getRow()
    {
        return $this->_row;
    }


    public function setAttribute($attribute)
    {
        $this->_attribute = $attribute;
        return $this;
    }

    public function getAttribute()
    {
        return $this->_attribute;
    }
}
<?php 

/**
 * 
 */
class Block_Core_Eav_Attribute_InputType extends Block_Core_Template
{
	protected $_attribute = null;
	protected $_row = null;

	public function __construct()
	{
		parent::__construct();
		$this->setTemplate('core/eav/attribute/inputtype.phtml');
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

	public function setRow($row)
	{
		$this->_row = $row;
		return $this;
	}

	public function getRow()
	{
		return $this->_row;
	}

	public function getInputTypeField()
	{
		$attribute = $this->getAttribute();
		if ($attribute->input_type == 'text') {
			return $this->getLayout()->createBlock('Core_Eav_Attribute_InputType_text')->setAttribute($this->getAttribute());
		}
		elseif($attribute->input_type == 'textarea') {
			return $this->getLayout()->createBlock('Core_Eav_Attribute_InputType_textarea')->setAttribute($this->getAttribute());
		}
		elseif($attribute->input_type == 'select') {
			return $this->getLayout()->createBlock('Core_Eav_Attribute_InputType_select')->setAttribute($this->getAttribute());
		}
		elseif($attribute->input_type == 'multiselect') {
			return $this->getLayout()->createBlock('Core_Eav_Attribute_InputType_multiselect')->setAttribute($this->getAttribute());
		}
		else{
			echo "invalid inputtype";
		}
	}
	
}
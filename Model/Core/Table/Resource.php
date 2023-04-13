<?php

class Model_Core_Table_Resource 
{
	// protected $data = [];
	protected $resourceName = null;
	protected $primaryKey = null;
	protected $adapter = null;

	function __construct()
	{
		
	} 

	protected function setAdapter($adapter)
	{
		$this->adapter = $adapter;
		return $this;
	}

	public function getAdapter()
	{
		if ($this->adapter) {
			return $this->adapter;
		}

		$adapter = new Model_Core_Adapter();
		$this->setAdapter($adapter);
		return $adapter;
	}

	// set get resourcename
	public function setResourceName($resourceName)
	{
		$this->resourceName = $resourceName;
		return $this;
	}

	public function getResourceName()
	{
		return $this->resourceName;
	}

	// set get primarykey
	public function setPrimaryKey($primaryKey)
	{
		$this->primaryKey = $primaryKey;
		return $this;
	}

	public function getPrimaryKey()
	{
		return $this->primaryKey;
	}

	public function fetchAll($query)
	{
		return $this->getAdapter()->fetchAll($query);
	}

	public function fetchRow($query)
	{
		return $this->getAdapter()->fetchRow($query);
	}

	public function insert($data)
	{
		$keys = array_keys($data);
		$values = array_values($data);

		$keyString = '`'.implode('`,`', $keys).'`';
		$valueString = "'".implode("','", $values)."'";

		$sql = "INSERT INTO `{$this->getResourceName()}` ({$keyString}) VALUES ({$valueString})";

		return $this->getAdapter()->insert($sql);
	}

	public function update($data, $conditions)
	{

		foreach($data as $key => $value){
			$keys[] = "`$key`='$value'";
		} 
		$testString = implode(',', $keys);

		foreach($conditions as $key => $value){
			$conditionArray[] = "`$key`='$value'";
		}

		$primaryKeyString = implode('AND', $conditionArray);
		$sql = "UPDATE `{$this->getResourceName()}` SET {$testString} WHERE  {$primaryKeyString}";

		return $this->getAdapter()->update($sql);
	}

	public function delete($conditions)
	{
		foreach($conditions as $key => $value){
			$conditionArray[] = "`$key`='$value'";
		}

		$conditionString = implode('AND', $conditionArray);
		$sql = "DELETE FROM `{$this->getResourceName()}` WHERE {$conditionString}";

		return $this->getAdapter()->delete($sql);
	}

	public function load($value, $column = null)
	{
		$column = (!$column) ? $this->getPrimaryKey() : $column;
		$query = "SELECT * FROM `{$this->resourceName}` WHERE `{$column}` = $value";
		$row = $this->getAdapter()->fetchRow($query);
		return $row;	
	}
}


?>
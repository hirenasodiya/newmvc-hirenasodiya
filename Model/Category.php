<?php

class Model_Category extends Model_Core_Table
{
	protected $resourceClass = 'Model_Category_Resource';
    protected $collectionClass = 'Model_Category_Collection';

    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_ACTIVE_LBL = 'active';
    const STATUS_INACTIVE_LBL = 'inactive';
    const STATUS_DEFAULT = 2;

    public function getStatus()
    {
        if ($this->status) {
            return $this->status;
        }

        return self::STATUS_DEFAULT;
    }
    
    public function getStatusText()
    {
        $statuses = $this->getResource()->getStatusOptions();
        if (array_key_exists($this->status, $statuses))
        {
            return $statuses[$this->status];
        }

        return $statuses[self::STATUS_DEFAULT];
    }

    public function getParentCategories()
	{
		$category = Ccc::getModel('Category');
		$query = "SELECT `category_id`,`path` FROM `{$category->getResource()->getResourceName()}`";
		$categories = $this->getResource()->getAdapter()->fetchPairs($query);
		return $categories;
	}

	protected function preparePathCategories()
	{
		$category = Ccc::getModel('Category');
		$query = "SELECT `category_id`,`name` FROM `{$category->getResource()->getResourceName()}`s
		ORDER BY `path` ASC";
		$categories = $category->getResource()->getAdapter()->fetchPairs($query);

		$sql = "SELECT `category_id`,`path` FROM `{$category->getResource()->getResourceName()}` 
		ORDER BY `path` ASC";
		$pathCategories = $category->getResource()->getAdapter()->fetchPairs($sql);

		foreach ($pathCategories as $categoryId => $path) {
			$str = explode("=",$path);
			$final = [];
			foreach ($str as $key => $categoryId) {
				$final[$key] = $categories[$categoryId];
			}
			unset($final[0]);
			$categoriesName[$categoryId] = implode(" > ", $final);
		}
		return $categoriesName;
	}


	public function getPathCategories($categoryId)
	{
		if ($categoryId == 1) {
			return 'Root';
		}
		return $this->preparePathCategories()[$categoryId];
	}


	public function updatePath()
	{

		if (!$this->getId()) {
			return false;
		}

		$oldPath = $this->path;

		$parent = Ccc::getModel('Category')->load($this->parent_id);
		if (!$parent) {
			$this->path = $this->getId();
		}
		else{
			$this->path = $parent->path.'='.$this->getId();
		}

		$this->save();
		
		$query = "UPDATE `category`
		SET `path` = REPLACE(`path`, '{$oldPath}=', '{$this->path}=')
		WHERE `path` LIKE '{$oldPath}=%' ORDER BY `path` ASC ";
		$this->getResource()->getAdapter()->update($query);

		return $this;
	}
}

?>
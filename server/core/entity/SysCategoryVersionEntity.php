<?php
/*************
* Třída SysCategoryVersionEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CategoryVersionEntity.php");
class SysCategoryVersionEntity extends CategoryVersionEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_syscategory_version";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_syscategory_version";
		$this->metadata["page_id"] = array("type" => "int(11)","default" => "NOT NULL","reference" => "SysCategory");
		$this->metadata["category_id"] = array("type" => "int(11)","default" => "NULL","reference" => "SysCategory");
	}
	#endregion

	#region Property
	// int(11)
	protected $page_id;

	protected $page_idOriginal;
	protected $pageSysCategoryEntity;

	// int(11)
	protected $category_id = NULL;
	protected $category_idOriginal = NULL;

	protected $categorySysCategoryEntity;

	#endregion

	#region Method
	// Setter page_id
	protected function setPage_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->page_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->pageSysCategoryEntity = new SysCategoryEntity($value,false);
		} else {
			$this->pageSysCategoryEntity = null;
		}
	}
	// Getter page_id
	public function getPage_id()
	{
		return $this->page_id;
	}
	// Getter page_idOriginal
	public function getPage_idOriginal()
	{
		return $this->page_idOriginal;
	}
	// Setter category_id
	protected function setCategory_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->category_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->categorySysCategoryEntity = new SysCategoryEntity($value,false);
		} else {
			$this->categorySysCategoryEntity = null;
		}
	}
	// Getter category_id
	public function getCategory_id()
	{
		return $this->category_id;
	}
	// Getter category_idOriginal
	public function getCategory_idOriginal()
	{
		return $this->category_idOriginal;
	}
	#endregion

}

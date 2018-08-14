<?php
/*************
* Třída CategoryAssociationEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class CategoryAssociationEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_category_association";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_category_association";
		$this->metadata["page_type_id"] = array("type" => "int(11)");
		$this->metadata["page_id"] = array("type" => "int(11)");
		$this->metadata["category_id"] = array("type" => "int(11)");
		$this->metadata["order"] = array("type" => "int(11)","default" => "0");
	}
	#endregion

	#region Property
	// int(11)
	protected $page_type_id;

	protected $page_type_idOriginal;
	// int(11)
	protected $page_id;

	protected $page_idOriginal;
	// int(11)
	protected $category_id;

	protected $category_idOriginal;
	// int(11)
	protected $order = 0;
	protected $orderOriginal = 0;

	#endregion

	#region Method
	// Setter page_type_id
	protected function setPage_type_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->page_type_id = $value; }
	}
	// Getter page_type_id
	public function getPage_type_id()
	{
		return $this->page_type_id;
	}
	// Getter page_type_idOriginal
	public function getPage_type_idOriginal()
	{
		return $this->page_type_idOriginal;
	}
	// Setter page_id
	protected function setPage_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->page_id = $value; }
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
		if (isInt($value) || is_null($value)) { $this->category_id = $value; }
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
	// Setter order
	protected function setOrder($value)
	{
		if (isInt($value) || is_null($value)) { $this->order = $value; }
	}
	// Getter order
	public function getOrder()
	{
		return $this->order;
	}
	// Getter orderOriginal
	public function getOrderOriginal()
	{
		return $this->orderOriginal;
	}
	#endregion

}

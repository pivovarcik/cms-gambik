<?php
/*************
* Třída CiselnikEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
abstract class CiselnikEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["name"] = array("type" => "varchar(50)");
		$this->metadata["description"] = array("type" => "longtext");
		$this->metadata["order"] = array("type" => "int");
		$this->metadata["parent"] = array("type" => "int","default" => "NULL");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $name;

	protected $nameOriginal;
	// longtext
	protected $description;

	protected $descriptionOriginal;
	// int
	protected $order;

	protected $orderOriginal;
	// int
	protected $parent = NULL;
	protected $parentOriginal = NULL;

	#endregion

	#region Method
	// Setter name
	protected function setName($value)
	{
		$this->name = $value;
	}
	// Getter name
	public function getName()
	{
		return $this->name;
	}
	// Getter nameOriginal
	public function getNameOriginal()
	{
		return $this->nameOriginal;
	}
	// Setter description
	protected function setDescription($value)
	{
		$this->description = $value;
	}
	// Getter description
	public function getDescription()
	{
		return $this->description;
	}
	// Getter descriptionOriginal
	public function getDescriptionOriginal()
	{
		return $this->descriptionOriginal;
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
	// Setter parent
	protected function setParent($value)
	{
		if (isInt($value) || is_null($value)) { $this->parent = $value; }
	}
	// Getter parent
	public function getParent()
	{
		return $this->parent;
	}
	// Getter parentOriginal
	public function getParentOriginal()
	{
		return $this->parentOriginal;
	}
	#endregion

}

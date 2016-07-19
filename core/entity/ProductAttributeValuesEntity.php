<?php
/*************
* Třída ProductAttributeValuesEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ProductAttributeValuesEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_attribute_values";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_attribute_values";
		$this->metadata["name"] = array("type" => "varchar(50)");
		$this->metadata["attribute_id"] = array("type" => "int");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $name;

	protected $nameOriginal;
	// int
	protected $attribute_id;

	protected $attribute_idOriginal;
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
	// Setter attribute_id
	protected function setAttribute_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->attribute_id = $value; }
	}
	// Getter attribute_id
	public function getAttribute_id()
	{
		return $this->attribute_id;
	}
	// Getter attribute_idOriginal
	public function getAttribute_idOriginal()
	{
		return $this->attribute_idOriginal;
	}
	#endregion

}

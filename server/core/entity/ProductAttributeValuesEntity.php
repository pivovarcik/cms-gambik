<?php
/*************
* Třída ProductAttributeValuesEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
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
		$this->metadata["attribute_code"] = array("type" => "varchar(25)");
		$this->metadata["attribute_id"] = array("type" => "int");
	}
	#endregion

	#region Property
	// varchar(50)
	protected $name;

	protected $nameOriginal;
	// varchar(25)
	protected $attribute_code;

	protected $attribute_codeOriginal;
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
	// Setter attribute_code
	protected function setAttribute_code($value)
	{
		$this->attribute_code = $value;
	}
	// Getter attribute_code
	public function getAttribute_code()
	{
		return $this->attribute_code;
	}
	// Getter attribute_codeOriginal
	public function getAttribute_codeOriginal()
	{
		return $this->attribute_codeOriginal;
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

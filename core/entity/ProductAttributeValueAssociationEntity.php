<?php
/*************
* Třída ProductAttributeValueAssociationEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ProductAttributeValueAssociationEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_attribute_value_association";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_attribute_value_association";
		$this->metadata["product_id"] = array("type" => "int","default" => "NOT NULL","reference" => "Product");
		$this->metadata["attribute_id"] = array("type" => "int","default" => "NOT NULL","reference" => "ProductAttributeValues");
		$this->metadata["order"] = array("type" => "int");
		$this->metadata["cost_difference"] = array("type" => "double");
	}
	#endregion

	#region Property
	// int
	protected $product_id;

	protected $product_idOriginal;
	protected $productProductEntity;

	// int
	protected $attribute_id;

	protected $attribute_idOriginal;
	protected $attributeProductAttributeValuesEntity;

	// int
	protected $order;

	protected $orderOriginal;
	// double
	protected $cost_difference;

	protected $cost_differenceOriginal;
	#endregion

	#region Method
	// Setter product_id
	protected function setProduct_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->product_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->productProductEntity = new ProductEntity($value,false);
		} else {
			$this->productProductEntity = null;
		}
	}
	// Getter product_id
	public function getProduct_id()
	{
		return $this->product_id;
	}
	// Getter product_idOriginal
	public function getProduct_idOriginal()
	{
		return $this->product_idOriginal;
	}
	// Setter attribute_id
	protected function setAttribute_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->attribute_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->attributeProductAttributeValuesEntity = new ProductAttributeValuesEntity($value,false);
		} else {
			$this->attributeProductAttributeValuesEntity = null;
		}
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
	// Setter cost_difference
	protected function setCost_difference($value)
	{
		$this->cost_difference = $value;
	}
	// Getter cost_difference
	public function getCost_difference()
	{
		return $this->cost_difference;
	}
	// Getter cost_differenceOriginal
	public function getCost_differenceOriginal()
	{
		return $this->cost_differenceOriginal;
	}
	#endregion

}

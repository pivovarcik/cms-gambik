<?php
/*************
* Třída ProductVariantyValueAssociationEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductVariantyValueAssociationEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_varianty_value_association";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_varianty_value_association";
		$this->metadata["varianty_id"] = array("type" => "int","default" => "NOT NULL","reference" => "ProductVarianty");
		$this->metadata["attribute_id"] = array("type" => "int","default" => "NOT NULL","reference" => "ProductAttributeValues");
		$this->metadata["order"] = array("type" => "int");
	}
	#endregion

	#region Property
	// int
	protected $varianty_id;

	protected $varianty_idOriginal;
	protected $variantyProductVariantyEntity;

	// int
	protected $attribute_id;

	protected $attribute_idOriginal;
	protected $attributeProductAttributeValuesEntity;

	// int
	protected $order;

	protected $orderOriginal;
	#endregion

	#region Method
	// Setter varianty_id
	protected function setVarianty_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->varianty_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->variantyProductVariantyEntity = new ProductVariantyEntity($value,false);
		} else {
			$this->variantyProductVariantyEntity = null;
		}
	}
	// Getter varianty_id
	public function getVarianty_id()
	{
		return $this->varianty_id;
	}
	// Getter varianty_idOriginal
	public function getVarianty_idOriginal()
	{
		return $this->varianty_idOriginal;
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
	#endregion

}

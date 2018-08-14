<?php
/*************
* Třída ProductGroupAssocEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once(PATH_ROOT2 . 'core/entity/' . "Entity.php");
class ProductGroupAssocEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_group_assoc";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_group_assoc";
		$this->metadata["product_id"] = array("type" => "int(11)","reference" => "Product");
		$this->metadata["group_id"] = array("type" => "int(11)","reference" => "ProductCategory");
	}
	#endregion

	#region Property
	// int(11)
	protected $product_id;

	protected $product_idOriginal;
	protected $productProductEntity;

	// int(11)
	protected $group_id;

	protected $group_idOriginal;
	protected $groupProductCategoryEntity;

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
	// Setter group_id
	protected function setGroup_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->group_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->groupProductCategoryEntity = new ProductCategoryEntity($value,false);
		} else {
			$this->groupProductCategoryEntity = null;
		}
	}
	// Getter group_id
	public function getGroup_id()
	{
		return $this->group_id;
	}
	// Getter group_idOriginal
	public function getGroup_idOriginal()
	{
		return $this->group_idOriginal;
	}
	#endregion

}

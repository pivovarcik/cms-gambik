<?php
/*************
* Třída ProductStavEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ProductStavEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_stavy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_stavy";
		$this->metadata["product_id"] = array("type" => "int","default" => "NOT NULL","reference" => "Product");
		$this->metadata["varianty_assoc_id"] = array("type" => "int","reference" => "ProductVariantyValueAssociation");
		$this->metadata["qty"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["qty_min"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["qty_max"] = array("type" => "decimal(10,2)","default" => "NULL");
		$this->metadata["mj_id"] = array("type" => "int","default" => "NULL","reference" => "Mj");
	}
	#endregion

	#region Property
	// int
	protected $product_id;

	protected $product_idOriginal;
	protected $productProductEntity;

	// int
	protected $varianty_assoc_id;

	protected $varianty_assoc_idOriginal;
	protected $varianty_assocProductVariantyValueAssociationEntity;

	// decimal(10,2)
	protected $qty = NULL;
	protected $qtyOriginal = NULL;

	// decimal(10,2)
	protected $qty_min = NULL;
	protected $qty_minOriginal = NULL;

	// decimal(10,2)
	protected $qty_max = NULL;
	protected $qty_maxOriginal = NULL;

	// int
	protected $mj_id = NULL;
	protected $mj_idOriginal = NULL;

	protected $mjMjEntity;

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
	// Setter varianty_assoc_id
	protected function setVarianty_assoc_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->varianty_assoc_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->varianty_assocProductVariantyValueAssociationEntity = new ProductVariantyValueAssociationEntity($value,false);
		} else {
			$this->varianty_assocProductVariantyValueAssociationEntity = null;
		}
	}
	// Getter varianty_assoc_id
	public function getVarianty_assoc_id()
	{
		return $this->varianty_assoc_id;
	}
	// Getter varianty_assoc_idOriginal
	public function getVarianty_assoc_idOriginal()
	{
		return $this->varianty_assoc_idOriginal;
	}
	// Setter qty
	protected function setQty($value)
	{
		$this->qty = strToNumeric($value);
	}
	// Getter qty
	public function getQty()
	{
		return $this->qty;
	}
	// Getter qtyOriginal
	public function getQtyOriginal()
	{
		return $this->qtyOriginal;
	}
	// Setter qty_min
	protected function setQty_min($value)
	{
		$this->qty_min = strToNumeric($value);
	}
	// Getter qty_min
	public function getQty_min()
	{
		return $this->qty_min;
	}
	// Getter qty_minOriginal
	public function getQty_minOriginal()
	{
		return $this->qty_minOriginal;
	}
	// Setter qty_max
	protected function setQty_max($value)
	{
		$this->qty_max = strToNumeric($value);
	}
	// Getter qty_max
	public function getQty_max()
	{
		return $this->qty_max;
	}
	// Getter qty_maxOriginal
	public function getQty_maxOriginal()
	{
		return $this->qty_maxOriginal;
	}
	// Setter mj_id
	protected function setMj_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->mj_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->mjMjEntity = new MjEntity($value,false);
		} else {
			$this->mjMjEntity = null;
		}
	}
	// Getter mj_id
	public function getMj_id()
	{
		return $this->mj_id;
	}
	// Getter mj_idOriginal
	public function getMj_idOriginal()
	{
		return $this->mj_idOriginal;
	}
	#endregion

}

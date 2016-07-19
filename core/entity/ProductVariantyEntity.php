<?php
/*************
* Třída ProductVariantyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ProductVariantyEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_varianty";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_varianty";
		$this->metadata["product_id"] = array("type" => "int","reference" => "Product");
		$this->metadata["dostupnost_id"] = array("type" => "int","default" => "NULL","reference" => "ProductDostupnost");
		$this->metadata["name"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["code"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["order"] = array("type" => "int");
		$this->metadata["qty"] = array("type" => "decimal(12,2)");
		$this->metadata["price"] = array("type" => "decimal(12,2)");
		$this->metadata["price_sdani"] = array("type" => "decimal(12,2)");
		$this->metadata["dph_id"] = array("type" => "int","default" => "NULL","reference" => "Dph");
	}
	#endregion

	#region Property
	// int
	protected $product_id;

	protected $product_idOriginal;
	protected $productProductEntity;

	// int
	protected $dostupnost_id = NULL;
	protected $dostupnost_idOriginal = NULL;

	protected $dostupnostProductDostupnostEntity;

	// varchar(255)
	protected $name = NULL;
	protected $nameOriginal = NULL;

	// varchar(255)
	protected $code = NULL;
	protected $codeOriginal = NULL;

	// int
	protected $order;

	protected $orderOriginal;
	// decimal(12,2)
	protected $qty;

	protected $qtyOriginal;
	// decimal(12,2)
	protected $price;

	protected $priceOriginal;
	// decimal(12,2)
	protected $price_sdani;

	protected $price_sdaniOriginal;
	// int
	protected $dph_id = NULL;
	protected $dph_idOriginal = NULL;

	protected $dphDphEntity;

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
	// Setter dostupnost_id
	protected function setDostupnost_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->dostupnost_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->dostupnostProductDostupnostEntity = new ProductDostupnostEntity($value,false);
		} else {
			$this->dostupnostProductDostupnostEntity = null;
		}
	}
	// Getter dostupnost_id
	public function getDostupnost_id()
	{
		return $this->dostupnost_id;
	}
	// Getter dostupnost_idOriginal
	public function getDostupnost_idOriginal()
	{
		return $this->dostupnost_idOriginal;
	}
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
	// Setter code
	protected function setCode($value)
	{
		$this->code = $value;
	}
	// Getter code
	public function getCode()
	{
		return $this->code;
	}
	// Getter codeOriginal
	public function getCodeOriginal()
	{
		return $this->codeOriginal;
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
	// Setter price
	protected function setPrice($value)
	{
		$this->price = strToNumeric($value);
	}
	// Getter price
	public function getPrice()
	{
		return $this->price;
	}
	// Getter priceOriginal
	public function getPriceOriginal()
	{
		return $this->priceOriginal;
	}
	// Setter price_sdani
	protected function setPrice_sdani($value)
	{
		$this->price_sdani = strToNumeric($value);
	}
	// Getter price_sdani
	public function getPrice_sdani()
	{
		return $this->price_sdani;
	}
	// Getter price_sdaniOriginal
	public function getPrice_sdaniOriginal()
	{
		return $this->price_sdaniOriginal;
	}
	// Setter dph_id
	protected function setDph_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->dph_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->dphDphEntity = new DphEntity($value,false);
		} else {
			$this->dphDphEntity = null;
		}
	}
	// Getter dph_id
	public function getDph_id()
	{
		return $this->dph_id;
	}
	// Getter dph_idOriginal
	public function getDph_idOriginal()
	{
		return $this->dph_idOriginal;
	}
	#endregion

}

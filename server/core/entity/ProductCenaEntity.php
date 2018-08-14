<?php
/*************
* Třída ProductCenaEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductCenaEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_ceny";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_ceny";
		$this->metadata["platnost_od"] = array("type" => "datetime");
		$this->metadata["platnost_do"] = array("type" => "datetime");
		$this->metadata["typ_slevy"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["sleva"] = array("type" => "numeric(12,2)");
		$this->metadata["cenik_cena"] = array("type" => "numeric(12,2)");
		$this->metadata["cenik_id"] = array("type" => "int","default" => "NOT NULL","reference" => "ProductCenik");
		$this->metadata["product_id"] = array("type" => "int","default" => "NOT NULL","reference" => "Product");
	}
	#endregion

	#region Property
	// datetime
	protected $platnost_od;

	protected $platnost_odOriginal;
	// datetime
	protected $platnost_do;

	protected $platnost_doOriginal;
	// varchar(1)
	protected $typ_slevy = NULL;
	protected $typ_slevyOriginal = NULL;

	// numeric(12,2)
	protected $sleva;

	protected $slevaOriginal;
	// numeric(12,2)
	protected $cenik_cena;

	protected $cenik_cenaOriginal;
	// int
	protected $cenik_id;

	protected $cenik_idOriginal;
	protected $cenikProductCenikEntity;

	// int
	protected $product_id;

	protected $product_idOriginal;
	protected $productProductEntity;

	#endregion

	#region Method
	// Setter platnost_od
	protected function setPlatnost_od($value)
	{
		$this->platnost_od = strToDatetime($value);
	}
	// Getter platnost_od
	public function getPlatnost_od()
	{
		return $this->platnost_od;
	}
	// Getter platnost_odOriginal
	public function getPlatnost_odOriginal()
	{
		return $this->platnost_odOriginal;
	}
	// Setter platnost_do
	protected function setPlatnost_do($value)
	{
		$this->platnost_do = strToDatetime($value);
	}
	// Getter platnost_do
	public function getPlatnost_do()
	{
		return $this->platnost_do;
	}
	// Getter platnost_doOriginal
	public function getPlatnost_doOriginal()
	{
		return $this->platnost_doOriginal;
	}
	// Setter typ_slevy
	protected function setTyp_slevy($value)
	{
		$this->typ_slevy = $value;
	}
	// Getter typ_slevy
	public function getTyp_slevy()
	{
		return $this->typ_slevy;
	}
	// Getter typ_slevyOriginal
	public function getTyp_slevyOriginal()
	{
		return $this->typ_slevyOriginal;
	}
	// Setter sleva
	protected function setSleva($value)
	{
		$this->sleva = strToNumeric($value);
	}
	// Getter sleva
	public function getSleva()
	{
		return $this->sleva;
	}
	// Getter slevaOriginal
	public function getSlevaOriginal()
	{
		return $this->slevaOriginal;
	}
	// Setter cenik_cena
	protected function setCenik_cena($value)
	{
		$this->cenik_cena = strToNumeric($value);
	}
	// Getter cenik_cena
	public function getCenik_cena()
	{
		return $this->cenik_cena;
	}
	// Getter cenik_cenaOriginal
	public function getCenik_cenaOriginal()
	{
		return $this->cenik_cenaOriginal;
	}
	// Setter cenik_id
	protected function setCenik_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->cenik_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->cenikProductCenikEntity = new ProductCenikEntity($value,false);
		} else {
			$this->cenikProductCenikEntity = null;
		}
	}
	// Getter cenik_id
	public function getCenik_id()
	{
		return $this->cenik_id;
	}
	// Getter cenik_idOriginal
	public function getCenik_idOriginal()
	{
		return $this->cenik_idOriginal;
	}
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
	#endregion

}

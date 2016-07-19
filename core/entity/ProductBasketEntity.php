<?php
/*************
* Třída ProductBasketEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class ProductBasketEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_basket";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_basket";
		$this->metadata["mnozstvi"] = array("type" => "float");
		$this->metadata["price"] = array("type" => "decimal(10,2)","default" => "null");
		$this->metadata["price_sdani"] = array("type" => "decimal(10,2)","default" => "null");
		$this->metadata["product_id"] = array("type" => "int","default" => "null","reference" => "Product");
		$this->metadata["tandem_id"] = array("type" => "int","default" => "null","reference" => "Product");
		$this->metadata["ip_adresa"] = array("type" => "varchar(30)","index" => "1");
		$this->metadata["basket_id"] = array("type" => "varchar(50)","default" => "not null","index" => "1");
		$this->metadata["user_id"] = array("type" => "int","default" => "null","reference" => "User");
		$this->metadata["varianty_id"] = array("type" => "int","default" => "null","reference" => "ProductVarianty");
		$this->metadata["typ_slevy"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["sleva"] = array("type" => "numeric(12,2)");
	}
	#endregion

	#region Property
	// float
	protected $mnozstvi;

	protected $mnozstviOriginal;
	// decimal(10,2)
	protected $price = null;
	protected $priceOriginal = null;

	// decimal(10,2)
	protected $price_sdani = null;
	protected $price_sdaniOriginal = null;

	// int
	protected $product_id = null;
	protected $product_idOriginal = null;

	protected $productProductEntity;

	// int
	protected $tandem_id = null;
	protected $tandem_idOriginal = null;

	protected $tandemProductEntity;

	// varchar(30)
	protected $ip_adresa;

	protected $ip_adresaOriginal;
	// varchar(50)
	protected $basket_id;

	protected $basket_idOriginal;
	// int
	protected $user_id = null;
	protected $user_idOriginal = null;

	protected $userUserEntity;

	// int
	protected $varianty_id = null;
	protected $varianty_idOriginal = null;

	protected $variantyProductVariantyEntity;

	// varchar(1)
	protected $typ_slevy = NULL;
	protected $typ_slevyOriginal = NULL;

	// numeric(12,2)
	protected $sleva;

	protected $slevaOriginal;
	#endregion

	#region Method
	// Setter mnozstvi
	protected function setMnozstvi($value)
	{
		$this->mnozstvi = strToNumeric($value);
	}
	// Getter mnozstvi
	public function getMnozstvi()
	{
		return $this->mnozstvi;
	}
	// Getter mnozstviOriginal
	public function getMnozstviOriginal()
	{
		return $this->mnozstviOriginal;
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
	// Setter tandem_id
	protected function setTandem_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->tandem_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->tandemProductEntity = new ProductEntity($value,false);
		} else {
			$this->tandemProductEntity = null;
		}
	}
	// Getter tandem_id
	public function getTandem_id()
	{
		return $this->tandem_id;
	}
	// Getter tandem_idOriginal
	public function getTandem_idOriginal()
	{
		return $this->tandem_idOriginal;
	}
	// Setter ip_adresa
	protected function setIp_adresa($value)
	{
		$this->ip_adresa = $value;
	}
	// Getter ip_adresa
	public function getIp_adresa()
	{
		return $this->ip_adresa;
	}
	// Getter ip_adresaOriginal
	public function getIp_adresaOriginal()
	{
		return $this->ip_adresaOriginal;
	}
	// Setter basket_id
	protected function setBasket_id($value)
	{
		$this->basket_id = $value;
	}
	// Getter basket_id
	public function getBasket_id()
	{
		return $this->basket_id;
	}
	// Getter basket_idOriginal
	public function getBasket_idOriginal()
	{
		return $this->basket_idOriginal;
	}
	// Setter user_id
	protected function setUser_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->user_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->userUserEntity = new UserEntity($value,false);
		} else {
			$this->userUserEntity = null;
		}
	}
	// Getter user_id
	public function getUser_id()
	{
		return $this->user_id;
	}
	// Getter user_idOriginal
	public function getUser_idOriginal()
	{
		return $this->user_idOriginal;
	}
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
		$this->sleva = $value;
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
	#endregion

}

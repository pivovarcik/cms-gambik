<?php
/*************
* Třída ProductPohybEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ProductPohybEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_pohyb";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_pohyb";
		$this->metadata["mnozstvi"] = array("type" => "float");
		$this->metadata["price"] = array("type" => "decimal(10,2)","default" => "null");
		$this->metadata["price_sdani"] = array("type" => "decimal(10,2)","default" => "null");
		$this->metadata["celkem"] = array("type" => "decimal(10,2)","default" => "null");
		$this->metadata["celkem_sdani"] = array("type" => "decimal(10,2)","default" => "null");
		$this->metadata["product_id"] = array("type" => "int","default" => "null","reference" => "Product");
		$this->metadata["doklad_id"] = array("type" => "int","default" => "null");
		$this->metadata["tax_id"] = array("type" => "int","default" => "null");
		$this->metadata["radek_id"] = array("type" => "int","default" => "null");
		$this->metadata["ip_adresa"] = array("type" => "varchar(30)","index" => "1");
		$this->metadata["user_id"] = array("type" => "int","default" => "null","reference" => "User");
		$this->metadata["varianty_id"] = array("type" => "int","default" => "null","reference" => "ProductVarianty");
		$this->metadata["typ_slevy"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["description"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["datum"] = array("type" => "datetime","default" => "NULL");
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

	// decimal(10,2)
	protected $celkem = null;
	protected $celkemOriginal = null;

	// decimal(10,2)
	protected $celkem_sdani = null;
	protected $celkem_sdaniOriginal = null;

	// int
	protected $product_id = null;
	protected $product_idOriginal = null;

	protected $productProductEntity;

	// int
	protected $doklad_id = null;
	protected $doklad_idOriginal = null;

	// int
	protected $tax_id = null;
	protected $tax_idOriginal = null;

	// int
	protected $radek_id = null;
	protected $radek_idOriginal = null;

	// varchar(30)
	protected $ip_adresa;

	protected $ip_adresaOriginal;
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

	// varchar(255)
	protected $description = NULL;
	protected $descriptionOriginal = NULL;

	// datetime
	protected $datum = NULL;
	protected $datumOriginal = NULL;

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
	// Setter celkem
	protected function setCelkem($value)
	{
		$this->celkem = strToNumeric($value);
	}
	// Getter celkem
	public function getCelkem()
	{
		return $this->celkem;
	}
	// Getter celkemOriginal
	public function getCelkemOriginal()
	{
		return $this->celkemOriginal;
	}
	// Setter celkem_sdani
	protected function setCelkem_sdani($value)
	{
		$this->celkem_sdani = strToNumeric($value);
	}
	// Getter celkem_sdani
	public function getCelkem_sdani()
	{
		return $this->celkem_sdani;
	}
	// Getter celkem_sdaniOriginal
	public function getCelkem_sdaniOriginal()
	{
		return $this->celkem_sdaniOriginal;
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
	// Setter doklad_id
	protected function setDoklad_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->doklad_id = $value; }
	}
	// Getter doklad_id
	public function getDoklad_id()
	{
		return $this->doklad_id;
	}
	// Getter doklad_idOriginal
	public function getDoklad_idOriginal()
	{
		return $this->doklad_idOriginal;
	}
	// Setter tax_id
	protected function setTax_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->tax_id = $value; }
	}
	// Getter tax_id
	public function getTax_id()
	{
		return $this->tax_id;
	}
	// Getter tax_idOriginal
	public function getTax_idOriginal()
	{
		return $this->tax_idOriginal;
	}
	// Setter radek_id
	protected function setRadek_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->radek_id = $value; }
	}
	// Getter radek_id
	public function getRadek_id()
	{
		return $this->radek_id;
	}
	// Getter radek_idOriginal
	public function getRadek_idOriginal()
	{
		return $this->radek_idOriginal;
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
	// Setter datum
	protected function setDatum($value)
	{
		$this->datum = strToDatetime($value);
	}
	// Getter datum
	public function getDatum()
	{
		return $this->datum;
	}
	// Getter datumOriginal
	public function getDatumOriginal()
	{
		return $this->datumOriginal;
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
	#endregion

}

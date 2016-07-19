<?php
/*************
* Třída RadekDokladuEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("RadekEntity.php");
abstract class RadekDokladuEntity extends RadekEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		parent::__construct($entity, $lazyLoad);
		$this->metadata["qty"] = array("type" => "decimal(7,2)");
		$this->metadata["price"] = array("type" => "decimal(12,2)");
		$this->metadata["product_id"] = array("type" => "int");
		$this->metadata["product_code"] = array("type" => "varchar(25)");
		$this->metadata["product_name"] = array("type" => "varchar(150)");
		$this->metadata["product_description"] = array("type" => "varchar(255)","default" => "NULL");
		$this->metadata["mj_id"] = array("type" => "int");
		$this->metadata["tax_id"] = array("type" => "int");
		$this->metadata["varianty_id"] = array("type" => "int","default" => "NULL");
		$this->metadata["typ_slevy"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["sleva"] = array("type" => "numeric(12,2)");
		$this->metadata["celkem"] = array("type" => "numeric(12,2)","stereotyp" => "vypoctova","default" => "NULL");
		$this->metadata["price_sdani"] = array("type" => "decimal(12,2)");
		$this->metadata["celkem_sdani"] = array("type" => "numeric(12,2)","stereotyp" => "vypoctova","default" => "NULL");
	}
	#endregion

	#region Property
	// decimal(7,2)
	protected $qty;

	protected $qtyOriginal;
	// decimal(12,2)
	protected $price;

	protected $priceOriginal;
	// int
	protected $product_id;

	protected $product_idOriginal;
	// varchar(25)
	protected $product_code;

	protected $product_codeOriginal;
	// varchar(150)
	protected $product_name;

	protected $product_nameOriginal;
	// varchar(255)
	protected $product_description = NULL;
	protected $product_descriptionOriginal = NULL;

	// int
	protected $mj_id;

	protected $mj_idOriginal;
	// int
	protected $tax_id;

	protected $tax_idOriginal;
	// int
	protected $varianty_id = NULL;
	protected $varianty_idOriginal = NULL;

	// varchar(1)
	protected $typ_slevy = NULL;
	protected $typ_slevyOriginal = NULL;

	// numeric(12,2)
	protected $sleva;

	protected $slevaOriginal;
	// numeric(12,2)
	protected $celkem;

	protected $celkemOriginal;
	// decimal(12,2)
	protected $price_sdani;

	protected $price_sdaniOriginal;
	// numeric(12,2)
	protected $celkem_sdani;

	protected $celkem_sdaniOriginal;
	#endregion

	#region Method
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
	// Setter product_id
	protected function setProduct_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->product_id = $value; }
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
	// Setter product_code
	protected function setProduct_code($value)
	{
		$this->product_code = $value;
	}
	// Getter product_code
	public function getProduct_code()
	{
		return $this->product_code;
	}
	// Getter product_codeOriginal
	public function getProduct_codeOriginal()
	{
		return $this->product_codeOriginal;
	}
	// Setter product_name
	protected function setProduct_name($value)
	{
		$this->product_name = $value;
	}
	// Getter product_name
	public function getProduct_name()
	{
		return $this->product_name;
	}
	// Getter product_nameOriginal
	public function getProduct_nameOriginal()
	{
		return $this->product_nameOriginal;
	}
	// Setter product_description
	protected function setProduct_description($value)
	{
		$this->product_description = $value;
	}
	// Getter product_description
	public function getProduct_description()
	{
		return $this->product_description;
	}
	// Getter product_descriptionOriginal
	public function getProduct_descriptionOriginal()
	{
		return $this->product_descriptionOriginal;
	}
	// Setter mj_id
	protected function setMj_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->mj_id = $value; }
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
	// Setter varianty_id
	protected function setVarianty_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->varianty_id = $value; }
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
	// Getter celkem
	public function getCelkem()
	{
		return vypocetCelkoveCenyRadkuDokladu($this);
	}
	// Getter celkemOriginal
	public function getCelkemOriginal()
	{
		return vypocetCelkoveCenyRadkuDokladu($this);
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
	// Getter celkem_sdani
	public function getCelkem_sdani()
	{
		return vypocetCelkoveCenyRadkuDokladuSDani($this);
	}
	// Getter celkem_sdaniOriginal
	public function getCelkem_sdaniOriginal()
	{
		return vypocetCelkoveCenyRadkuDokladuSDani($this);
	}
	#endregion

}

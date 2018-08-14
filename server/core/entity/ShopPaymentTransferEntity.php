<?php
/*************
* Třída ShopPaymentTransferEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class ShopPaymentTransferEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_platby_dopravy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_platby_dopravy";
		$this->metadata["doprava_id"] = array("type" => "int(11)","reference" => "ShopTransfer");
		$this->metadata["platba_id"] = array("type" => "int(11)","reference" => "ShopPayment");
		$this->metadata["price"] = array("type" => "decimal(10,2)","default" => "0");
		$this->metadata["price_value"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["price_mj"] = array("type" => "decimal(12,2)");
		$this->metadata["price_mj_value"] = array("type" => "varchar(50)");
		$this->metadata["price_m3"] = array("type" => "decimal(12,2)");
		$this->metadata["price_m3_value"] = array("type" => "varchar(50)");
		$this->metadata["price_kg"] = array("type" => "decimal(12,2)");
		$this->metadata["price_kg_value"] = array("type" => "varchar(50)");
	}
	#endregion

	#region Property
	// int(11)
	protected $doprava_id;

	protected $doprava_idOriginal;
	protected $dopravaShopTransferEntity;

	// int(11)
	protected $platba_id;

	protected $platba_idOriginal;
	protected $platbaShopPaymentEntity;

	// decimal(10,2)
	protected $price = 0;
	protected $priceOriginal = 0;

	// varchar(50)
	protected $price_value = NULL;
	protected $price_valueOriginal = NULL;

	// decimal(12,2)
	protected $price_mj;

	protected $price_mjOriginal;
	// varchar(50)
	protected $price_mj_value;

	protected $price_mj_valueOriginal;
	// decimal(12,2)
	protected $price_m3;

	protected $price_m3Original;
	// varchar(50)
	protected $price_m3_value;

	protected $price_m3_valueOriginal;
	// decimal(12,2)
	protected $price_kg;

	protected $price_kgOriginal;
	// varchar(50)
	protected $price_kg_value;

	protected $price_kg_valueOriginal;
	#endregion

	#region Method
	// Setter doprava_id
	protected function setDoprava_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->doprava_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->dopravaShopTransferEntity = new ShopTransferEntity($value,false);
		} else {
			$this->dopravaShopTransferEntity = null;
		}
	}
	// Getter doprava_id
	public function getDoprava_id()
	{
		return $this->doprava_id;
	}
	// Getter doprava_idOriginal
	public function getDoprava_idOriginal()
	{
		return $this->doprava_idOriginal;
	}
	// Setter platba_id
	protected function setPlatba_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->platba_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->platbaShopPaymentEntity = new ShopPaymentEntity($value,false);
		} else {
			$this->platbaShopPaymentEntity = null;
		}
	}
	// Getter platba_id
	public function getPlatba_id()
	{
		return $this->platba_id;
	}
	// Getter platba_idOriginal
	public function getPlatba_idOriginal()
	{
		return $this->platba_idOriginal;
	}
	// Setter price
	protected function setPrice($value)
	{
		if (is_null($value)) { return; }
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
	// Setter price_value
	protected function setPrice_value($value)
	{
		$this->price_value = $value;
	}
	// Getter price_value
	public function getPrice_value()
	{
		return $this->price_value;
	}
	// Getter price_valueOriginal
	public function getPrice_valueOriginal()
	{
		return $this->price_valueOriginal;
	}
	// Setter price_mj
	protected function setPrice_mj($value)
	{
		$this->price_mj = strToNumeric($value);
	}
	// Getter price_mj
	public function getPrice_mj()
	{
		return $this->price_mj;
	}
	// Getter price_mjOriginal
	public function getPrice_mjOriginal()
	{
		return $this->price_mjOriginal;
	}
	// Setter price_mj_value
	protected function setPrice_mj_value($value)
	{
		$this->price_mj_value = $value;
	}
	// Getter price_mj_value
	public function getPrice_mj_value()
	{
		return $this->price_mj_value;
	}
	// Getter price_mj_valueOriginal
	public function getPrice_mj_valueOriginal()
	{
		return $this->price_mj_valueOriginal;
	}
	// Setter price_m3
	protected function setPrice_m3($value)
	{
		$this->price_m3 = strToNumeric($value);
	}
	// Getter price_m3
	public function getPrice_m3()
	{
		return $this->price_m3;
	}
	// Getter price_m3Original
	public function getPrice_m3Original()
	{
		return $this->price_m3Original;
	}
	// Setter price_m3_value
	protected function setPrice_m3_value($value)
	{
		$this->price_m3_value = $value;
	}
	// Getter price_m3_value
	public function getPrice_m3_value()
	{
		return $this->price_m3_value;
	}
	// Getter price_m3_valueOriginal
	public function getPrice_m3_valueOriginal()
	{
		return $this->price_m3_valueOriginal;
	}
	// Setter price_kg
	protected function setPrice_kg($value)
	{
		$this->price_kg = strToNumeric($value);
	}
	// Getter price_kg
	public function getPrice_kg()
	{
		return $this->price_kg;
	}
	// Getter price_kgOriginal
	public function getPrice_kgOriginal()
	{
		return $this->price_kgOriginal;
	}
	// Setter price_kg_value
	protected function setPrice_kg_value($value)
	{
		$this->price_kg_value = $value;
	}
	// Getter price_kg_value
	public function getPrice_kg_value()
	{
		return $this->price_kg_value;
	}
	// Getter price_kg_valueOriginal
	public function getPrice_kg_valueOriginal()
	{
		return $this->price_kg_valueOriginal;
	}
	#endregion

}

<?php
/*************
* Třída ShopPaymentTransferEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
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
	#endregion

}

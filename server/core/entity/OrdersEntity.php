<?php
/*************
* Třída OrdersEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("DokladEntity.php");
class OrdersEntity extends DokladEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_orders";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_orders";
		$this->metadata["order_date"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["heureka"] = array("type" => "int(11)","default" => "0");
		$this->metadata["heurekaTimeStamp"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["odeslano_stav"] = array("type" => "int(11)","default" => "0");
		$this->metadata["odeslanoTimeStamp"] = array("type" => "datetime","default" => "NULL");
		$this->metadata["date_reserve"] = array("type" => "varchar(25)","default" => "NULL");
		$this->metadata["barcode"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["faktura_id"] = array("type" => "int(11)","default" => "NULL","reference" => "Faktura");
	}
	#endregion

	#region Property
	// datetime
	protected $order_date = NULL;
	protected $order_dateOriginal = NULL;

	// int(11)
	protected $heureka = 0;
	protected $heurekaOriginal = 0;

	// datetime
	protected $heurekaTimeStamp = NULL;
	protected $heurekaTimeStampOriginal = NULL;

	// int(11)
	protected $odeslano_stav = 0;
	protected $odeslano_stavOriginal = 0;

	// datetime
	protected $odeslanoTimeStamp = NULL;
	protected $odeslanoTimeStampOriginal = NULL;

	// varchar(25)
	protected $date_reserve = NULL;
	protected $date_reserveOriginal = NULL;

	// varchar(50)
	protected $barcode = NULL;
	protected $barcodeOriginal = NULL;

	// int(11)
	protected $faktura_id = NULL;
	protected $faktura_idOriginal = NULL;

	protected $fakturaFakturaEntity;

	#endregion

	#region Method
	// Setter order_date
	protected function setOrder_date($value)
	{
		$this->order_date = strToDatetime($value);
	}
	// Getter order_date
	public function getOrder_date()
	{
		return $this->order_date;
	}
	// Getter order_dateOriginal
	public function getOrder_dateOriginal()
	{
		return $this->order_dateOriginal;
	}
	// Setter heureka
	protected function setHeureka($value)
	{
		if (isInt($value) || is_null($value)) { $this->heureka = $value; }
	}
	// Getter heureka
	public function getHeureka()
	{
		return $this->heureka;
	}
	// Getter heurekaOriginal
	public function getHeurekaOriginal()
	{
		return $this->heurekaOriginal;
	}
	// Setter heurekaTimeStamp
	protected function setHeurekaTimeStamp($value)
	{
		$this->heurekaTimeStamp = strToDatetime($value);
	}
	// Getter heurekaTimeStamp
	public function getHeurekaTimeStamp()
	{
		return $this->heurekaTimeStamp;
	}
	// Getter heurekaTimeStampOriginal
	public function getHeurekaTimeStampOriginal()
	{
		return $this->heurekaTimeStampOriginal;
	}
	// Setter odeslano_stav
	protected function setOdeslano_stav($value)
	{
		if (isInt($value) || is_null($value)) { $this->odeslano_stav = $value; }
	}
	// Getter odeslano_stav
	public function getOdeslano_stav()
	{
		return $this->odeslano_stav;
	}
	// Getter odeslano_stavOriginal
	public function getOdeslano_stavOriginal()
	{
		return $this->odeslano_stavOriginal;
	}
	// Setter odeslanoTimeStamp
	protected function setOdeslanoTimeStamp($value)
	{
		$this->odeslanoTimeStamp = strToDatetime($value);
	}
	// Getter odeslanoTimeStamp
	public function getOdeslanoTimeStamp()
	{
		return $this->odeslanoTimeStamp;
	}
	// Getter odeslanoTimeStampOriginal
	public function getOdeslanoTimeStampOriginal()
	{
		return $this->odeslanoTimeStampOriginal;
	}
	// Setter date_reserve
	protected function setDate_reserve($value)
	{
		$this->date_reserve = $value;
	}
	// Getter date_reserve
	public function getDate_reserve()
	{
		return $this->date_reserve;
	}
	// Getter date_reserveOriginal
	public function getDate_reserveOriginal()
	{
		return $this->date_reserveOriginal;
	}
	// Setter barcode
	protected function setBarcode($value)
	{
		$this->barcode = $value;
	}
	// Getter barcode
	public function getBarcode()
	{
		return $this->barcode;
	}
	// Getter barcodeOriginal
	public function getBarcodeOriginal()
	{
		return $this->barcodeOriginal;
	}
	// Setter faktura_id
	protected function setFaktura_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->faktura_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->fakturaFakturaEntity = new FakturaEntity($value,false);
		} else {
			$this->fakturaFakturaEntity = null;
		}
	}
	// Getter faktura_id
	public function getFaktura_id()
	{
		return $this->faktura_id;
	}
	// Getter faktura_idOriginal
	public function getFaktura_idOriginal()
	{
		return $this->faktura_idOriginal;
	}
	#endregion

}

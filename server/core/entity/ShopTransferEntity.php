<?php
/*************
* Třída ShopTransferEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class ShopTransferEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_zpusob_dopravy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_zpusob_dopravy";
		$this->metadata["price"] = array("type" => "decimal(12,2)");
		$this->metadata["price_value"] = array("type" => "varchar(50)");
		$this->metadata["osobni_odber"] = array("type" => "tinyint","default" => "0");
		$this->metadata["aktivni"] = array("type" => "tinyint","default" => "1");
		$this->metadata["address1"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["odberne_misto"] = array("type" => "varchar(150)","default" => "NULL");
		$this->metadata["city"] = array("type" => "varchar(50)","default" => "NULL");
		$this->metadata["zip_code"] = array("type" => "varchar(10)","default" => "NULL");
		$this->metadata["kod_dopravce"] = array("type" => "varchar(10)","default" => "NULL");
		$this->metadata["vypocet_id"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// decimal(12,2)
	protected $price;

	protected $priceOriginal;
	// varchar(50)
	protected $price_value;

	protected $price_valueOriginal;
	// tinyint
	protected $osobni_odber = 0;
	protected $osobni_odberOriginal = 0;

	// tinyint
	protected $aktivni = 1;
	protected $aktivniOriginal = 1;

	// varchar(50)
	protected $address1 = NULL;
	protected $address1Original = NULL;

	// varchar(150)
	protected $odberne_misto = NULL;
	protected $odberne_mistoOriginal = NULL;

	// varchar(50)
	protected $city = NULL;
	protected $cityOriginal = NULL;

	// varchar(10)
	protected $zip_code = NULL;
	protected $zip_codeOriginal = NULL;

	// varchar(10)
	protected $kod_dopravce = NULL;
	protected $kod_dopravceOriginal = NULL;

	// int
	protected $vypocet_id = 0;
	protected $vypocet_idOriginal = 0;

	#endregion

	#region Method
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
	// Setter osobni_odber
	protected function setOsobni_odber($value)
	{
		$this->osobni_odber = $value;
	}
	// Getter osobni_odber
	public function getOsobni_odber()
	{
		return $this->osobni_odber;
	}
	// Getter osobni_odberOriginal
	public function getOsobni_odberOriginal()
	{
		return $this->osobni_odberOriginal;
	}
	// Setter aktivni
	protected function setAktivni($value)
	{
		$this->aktivni = $value;
	}
	// Getter aktivni
	public function getAktivni()
	{
		return $this->aktivni;
	}
	// Getter aktivniOriginal
	public function getAktivniOriginal()
	{
		return $this->aktivniOriginal;
	}
	// Setter address1
	protected function setAddress1($value)
	{
		$this->address1 = $value;
	}
	// Getter address1
	public function getAddress1()
	{
		return $this->address1;
	}
	// Getter address1Original
	public function getAddress1Original()
	{
		return $this->address1Original;
	}
	// Setter odberne_misto
	protected function setOdberne_misto($value)
	{
		$this->odberne_misto = $value;
	}
	// Getter odberne_misto
	public function getOdberne_misto()
	{
		return $this->odberne_misto;
	}
	// Getter odberne_mistoOriginal
	public function getOdberne_mistoOriginal()
	{
		return $this->odberne_mistoOriginal;
	}
	// Setter city
	protected function setCity($value)
	{
		$this->city = $value;
	}
	// Getter city
	public function getCity()
	{
		return $this->city;
	}
	// Getter cityOriginal
	public function getCityOriginal()
	{
		return $this->cityOriginal;
	}
	// Setter zip_code
	protected function setZip_code($value)
	{
		$this->zip_code = $value;
	}
	// Getter zip_code
	public function getZip_code()
	{
		return $this->zip_code;
	}
	// Getter zip_codeOriginal
	public function getZip_codeOriginal()
	{
		return $this->zip_codeOriginal;
	}
	// Setter kod_dopravce
	protected function setKod_dopravce($value)
	{
		$this->kod_dopravce = $value;
	}
	// Getter kod_dopravce
	public function getKod_dopravce()
	{
		return $this->kod_dopravce;
	}
	// Getter kod_dopravceOriginal
	public function getKod_dopravceOriginal()
	{
		return $this->kod_dopravceOriginal;
	}
	// Setter vypocet_id
	protected function setVypocet_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->vypocet_id = $value; }
	}
	// Getter vypocet_id
	public function getVypocet_id()
	{
		return $this->vypocet_id;
	}
	// Getter vypocet_idOriginal
	public function getVypocet_idOriginal()
	{
		return $this->vypocet_idOriginal;
	}
	#endregion

}

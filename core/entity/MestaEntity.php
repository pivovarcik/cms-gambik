<?php
/*************
* Třída MestaEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("Entity.php");
class MestaEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_mesta";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_mesta";
		$this->metadata["obec"] = array("type" => "varchar(100)");
		$this->metadata["okres_id"] = array("type" => "int","reference" => "Okresy");
		$this->metadata["typ_id"] = array("type" => "int");
		$this->metadata["latitude"] = array("type" => "decimal(10,7)");
		$this->metadata["longitude"] = array("type" => "decimal(10,7)");
	}
	#endregion

	#region Property
	// varchar(100)
	protected $obec;

	protected $obecOriginal;
	// int
	protected $okres_id;

	protected $okres_idOriginal;
	protected $okresOkresyEntity;

	// int
	protected $typ_id;

	protected $typ_idOriginal;
	// decimal(10,7)
	protected $latitude;

	protected $latitudeOriginal;
	// decimal(10,7)
	protected $longitude;

	protected $longitudeOriginal;
	#endregion

	#region Method
	// Setter obec
	protected function setObec($value)
	{
		$this->obec = $value;
	}
	// Getter obec
	public function getObec()
	{
		return $this->obec;
	}
	// Getter obecOriginal
	public function getObecOriginal()
	{
		return $this->obecOriginal;
	}
	// Setter okres_id
	protected function setOkres_id($value)
	{
		if (isCeleKladneCislo($value) || is_null($value)) {
			$this->okres_id = $value;
		}
		if (isCeleKladneCislo($value) && $this->lazyLoad) {
			$this->okresOkresyEntity = new OkresyEntity($value,false);
		} else {
			$this->okresOkresyEntity = null;
		}
	}
	// Getter okres_id
	public function getOkres_id()
	{
		return $this->okres_id;
	}
	// Getter okres_idOriginal
	public function getOkres_idOriginal()
	{
		return $this->okres_idOriginal;
	}
	// Setter typ_id
	protected function setTyp_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->typ_id = $value; }
	}
	// Getter typ_id
	public function getTyp_id()
	{
		return $this->typ_id;
	}
	// Getter typ_idOriginal
	public function getTyp_idOriginal()
	{
		return $this->typ_idOriginal;
	}
	// Setter latitude
	protected function setLatitude($value)
	{
		$this->latitude = strToNumeric($value);
	}
	// Getter latitude
	public function getLatitude()
	{
		return $this->latitude;
	}
	// Getter latitudeOriginal
	public function getLatitudeOriginal()
	{
		return $this->latitudeOriginal;
	}
	// Setter longitude
	protected function setLongitude($value)
	{
		$this->longitude = strToNumeric($value);
	}
	// Getter longitude
	public function getLongitude()
	{
		return $this->longitude;
	}
	// Getter longitudeOriginal
	public function getLongitudeOriginal()
	{
		return $this->longitudeOriginal;
	}
	#endregion

}

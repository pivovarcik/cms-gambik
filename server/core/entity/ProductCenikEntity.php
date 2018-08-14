<?php
/*************
* Třída ProductCenikEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class ProductCenikEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_cenik";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_cenik";
		$this->metadata["platnost_od"] = array("type" => "datetime");
		$this->metadata["platnost_do"] = array("type" => "datetime");
		$this->metadata["typ_slevy"] = array("type" => "varchar(1)","default" => "NULL");
		$this->metadata["sleva"] = array("type" => "numeric(12,2)");
		$this->metadata["priorita"] = array("type" => "int","default" => "0");
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
	// int
	protected $priorita = 0;
	protected $prioritaOriginal = 0;

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
	// Setter priorita
	protected function setPriorita($value)
	{
		if (isInt($value) || is_null($value)) { $this->priorita = $value; }
	}
	// Getter priorita
	public function getPriorita()
	{
		return $this->priorita;
	}
	// Getter prioritaOriginal
	public function getPrioritaOriginal()
	{
		return $this->prioritaOriginal;
	}
	#endregion

}

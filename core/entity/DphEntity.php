<?php
/*************
* Třída DphEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class DphEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_dph";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_dph";
		$this->metadata["value"] = array("type" => "decimal(10,2)");
		$this->metadata["platnost_od"] = array("type" => "datetime","default" => "null");
		$this->metadata["platnost_do"] = array("type" => "datetime","default" => "null");
	}
	#endregion

	#region Property
	// decimal(10,2)
	protected $value;

	protected $valueOriginal;
	// datetime
	protected $platnost_od = null;
	protected $platnost_odOriginal = null;

	// datetime
	protected $platnost_do = null;
	protected $platnost_doOriginal = null;

	#endregion

	#region Method
	// Setter value
	protected function setValue($value)
	{
		$this->value = strToNumeric($value);
	}
	// Getter value
	public function getValue()
	{
		return $this->value;
	}
	// Getter valueOriginal
	public function getValueOriginal()
	{
		return $this->valueOriginal;
	}
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
	#endregion

}

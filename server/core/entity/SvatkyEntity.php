<?php
/*************
* Třída SvatkyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class SvatkyEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_svatky";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_svatky";
		$this->metadata["dd"] = array("type" => "int");
		$this->metadata["mm"] = array("type" => "int");
		$this->metadata["svatek"] = array("type" => "varchar(50)");
		$this->metadata["volno"] = array("type" => "tinyint(1)");
	}
	#endregion

	#region Property
	// int
	protected $dd;

	protected $ddOriginal;
	// int
	protected $mm;

	protected $mmOriginal;
	// varchar(50)
	protected $svatek;

	protected $svatekOriginal;
	// tinyint(1)
	protected $volno;

	protected $volnoOriginal;
	#endregion

	#region Method
	// Setter dd
	protected function setDd($value)
	{
		if (isInt($value) || is_null($value)) { $this->dd = $value; }
	}
	// Getter dd
	public function getDd()
	{
		return $this->dd;
	}
	// Getter ddOriginal
	public function getDdOriginal()
	{
		return $this->ddOriginal;
	}
	// Setter mm
	protected function setMm($value)
	{
		if (isInt($value) || is_null($value)) { $this->mm = $value; }
	}
	// Getter mm
	public function getMm()
	{
		return $this->mm;
	}
	// Getter mmOriginal
	public function getMmOriginal()
	{
		return $this->mmOriginal;
	}
	// Setter svatek
	protected function setSvatek($value)
	{
		$this->svatek = $value;
	}
	// Getter svatek
	public function getSvatek()
	{
		return $this->svatek;
	}
	// Getter svatekOriginal
	public function getSvatekOriginal()
	{
		return $this->svatekOriginal;
	}
	// Setter volno
	protected function setVolno($value)
	{
		$this->volno = $value;
	}
	// Getter volno
	public function getVolno()
	{
		return $this->volno;
	}
	// Getter volnoOriginal
	public function getVolnoOriginal()
	{
		return $this->volnoOriginal;
	}
	#endregion

}

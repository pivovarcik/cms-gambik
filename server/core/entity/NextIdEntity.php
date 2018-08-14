<?php
/*************
* Třída NextIdEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class NextIdEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_nextid";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_nextid";
		$this->metadata["tabulka"] = array("type" => "varchar(25)");
		$this->metadata["polozka"] = array("type" => "varchar(25)");
		$this->metadata["rada"] = array("type" => "varchar(15)");
		$this->metadata["delka"] = array("type" => "int");
		$this->metadata["nazev"] = array("type" => "varchar(50)");
		$this->metadata["posledni"] = array("type" => "int");
		$this->metadata["nejvyssi"] = array("type" => "int");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $tabulka;

	protected $tabulkaOriginal;
	// varchar(25)
	protected $polozka;

	protected $polozkaOriginal;
	// varchar(15)
	protected $rada;

	protected $radaOriginal;
	// int
	protected $delka;

	protected $delkaOriginal;
	// varchar(50)
	protected $nazev;

	protected $nazevOriginal;
	// int
	protected $posledni;

	protected $posledniOriginal;
	// int
	protected $nejvyssi;

	protected $nejvyssiOriginal;
	#endregion

	#region Method
	// Setter tabulka
	protected function setTabulka($value)
	{
		$this->tabulka = $value;
	}
	// Getter tabulka
	public function getTabulka()
	{
		return $this->tabulka;
	}
	// Getter tabulkaOriginal
	public function getTabulkaOriginal()
	{
		return $this->tabulkaOriginal;
	}
	// Setter polozka
	protected function setPolozka($value)
	{
		$this->polozka = $value;
	}
	// Getter polozka
	public function getPolozka()
	{
		return $this->polozka;
	}
	// Getter polozkaOriginal
	public function getPolozkaOriginal()
	{
		return $this->polozkaOriginal;
	}
	// Setter rada
	protected function setRada($value)
	{
		$this->rada = $value;
	}
	// Getter rada
	public function getRada()
	{
		return $this->rada;
	}
	// Getter radaOriginal
	public function getRadaOriginal()
	{
		return $this->radaOriginal;
	}
	// Setter delka
	protected function setDelka($value)
	{
		if (isInt($value) || is_null($value)) { $this->delka = $value; }
	}
	// Getter delka
	public function getDelka()
	{
		return $this->delka;
	}
	// Getter delkaOriginal
	public function getDelkaOriginal()
	{
		return $this->delkaOriginal;
	}
	// Setter nazev
	protected function setNazev($value)
	{
		$this->nazev = $value;
	}
	// Getter nazev
	public function getNazev()
	{
		return $this->nazev;
	}
	// Getter nazevOriginal
	public function getNazevOriginal()
	{
		return $this->nazevOriginal;
	}
	// Setter posledni
	protected function setPosledni($value)
	{
		if (isInt($value) || is_null($value)) { $this->posledni = $value; }
	}
	// Getter posledni
	public function getPosledni()
	{
		return $this->posledni;
	}
	// Getter posledniOriginal
	public function getPosledniOriginal()
	{
		return $this->posledniOriginal;
	}
	// Setter nejvyssi
	protected function setNejvyssi($value)
	{
		if (isInt($value) || is_null($value)) { $this->nejvyssi = $value; }
	}
	// Getter nejvyssi
	public function getNejvyssi()
	{
		return $this->nejvyssi;
	}
	// Getter nejvyssiOriginal
	public function getNejvyssiOriginal()
	{
		return $this->nejvyssiOriginal;
	}
	#endregion

}

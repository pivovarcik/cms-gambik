<?php
/*************
* Třída KurzEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class KurzEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_kurzy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_kurzy";
		$this->metadata["kod"] = array("type" => "varchar(10)");
		$this->metadata["kurz"] = array("type" => "float");
		$this->metadata["datum"] = array("type" => "date");
		$this->metadata["mnozstvi"] = array("type" => "int");
	}
	#endregion

	#region Property
	// varchar(10)
	protected $kod;

	protected $kodOriginal;
	// float
	protected $kurz;

	protected $kurzOriginal;
	// date
	protected $datum;

	protected $datumOriginal;
	// int
	protected $mnozstvi;

	protected $mnozstviOriginal;
	#endregion

	#region Method
	// Setter kod
	protected function setKod($value)
	{
		$this->kod = $value;
	}
	// Getter kod
	public function getKod()
	{
		return $this->kod;
	}
	// Getter kodOriginal
	public function getKodOriginal()
	{
		return $this->kodOriginal;
	}
	// Setter kurz
	protected function setKurz($value)
	{
		$this->kurz = strToNumeric($value);
	}
	// Getter kurz
	public function getKurz()
	{
		return $this->kurz;
	}
	// Getter kurzOriginal
	public function getKurzOriginal()
	{
		return $this->kurzOriginal;
	}
	// Setter datum
	protected function setDatum($value)
	{
		$this->datum = strToDatetime($value);
	}
	// Getter datum
	public function getDatum()
	{
		return $this->datum;
	}
	// Getter datumOriginal
	public function getDatumOriginal()
	{
		return $this->datumOriginal;
	}
	// Setter mnozstvi
	protected function setMnozstvi($value)
	{
		if (isInt($value) || is_null($value)) { $this->mnozstvi = $value; }
	}
	// Getter mnozstvi
	public function getMnozstvi()
	{
		return $this->mnozstvi;
	}
	// Getter mnozstviOriginal
	public function getMnozstviOriginal()
	{
		return $this->mnozstviOriginal;
	}
	#endregion

}

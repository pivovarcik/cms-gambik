<?php
/*************
* Třída ShopPaymentEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class ShopPaymentEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_zpusob_platby";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_zpusob_platby";
		$this->metadata["brana"] = array("type" => "varchar(25)");
		$this->metadata["aktivni"] = array("type" => "tinyint","default" => "1");
	}
	#endregion

	#region Property
	// varchar(25)
	protected $brana;

	protected $branaOriginal;
	// tinyint
	protected $aktivni = 1;
	protected $aktivniOriginal = 1;

	#endregion

	#region Method
	// Setter brana
	protected function setBrana($value)
	{
		$this->brana = $value;
	}
	// Getter brana
	public function getBrana()
	{
		return $this->brana;
	}
	// Getter branaOriginal
	public function getBranaOriginal()
	{
		return $this->branaOriginal;
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
	#endregion

}

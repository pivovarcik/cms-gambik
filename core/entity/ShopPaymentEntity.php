<?php
/*************
* Třída ShopPaymentEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
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
	}
	#endregion

	#region Property
	// varchar(25)
	protected $brana;

	protected $branaOriginal;
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
	#endregion

}

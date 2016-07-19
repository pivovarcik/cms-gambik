<?php
/*************
* Třída ProductDostupnostEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class ProductDostupnostEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_product_dostupnost";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_product_dostupnost";
		$this->metadata["hodiny"] = array("type" => "int","default" => "0");
	}
	#endregion

	#region Property
	// int
	protected $hodiny = 0;
	protected $hodinyOriginal = 0;

	#endregion

	#region Method
	// Setter hodiny
	protected function setHodiny($value)
	{
		if (isInt($value) || is_null($value)) { $this->hodiny = $value; }
	}
	// Getter hodiny
	public function getHodiny()
	{
		return $this->hodiny;
	}
	// Getter hodinyOriginal
	public function getHodinyOriginal()
	{
		return $this->hodinyOriginal;
	}
	#endregion

}

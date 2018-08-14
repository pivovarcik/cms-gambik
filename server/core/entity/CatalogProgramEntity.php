<?php
/*************
* Třída CatalogProgramEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class CatalogProgramEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog_program";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog_program";
		$this->metadata["hodnota"] = array("type" => "varchar(100)");
		$this->metadata["order"] = array("type" => "int(11)","default" => "0");
	}
	#endregion

	#region Property
	// varchar(100)
	protected $hodnota;

	protected $hodnotaOriginal;
	// int(11)
	protected $order = 0;
	protected $orderOriginal = 0;

	#endregion

	#region Method
	// Setter hodnota
	protected function setHodnota($value)
	{
		$this->hodnota = $value;
	}
	// Getter hodnota
	public function getHodnota()
	{
		return $this->hodnota;
	}
	// Getter hodnotaOriginal
	public function getHodnotaOriginal()
	{
		return $this->hodnotaOriginal;
	}
	// Setter order
	protected function setOrder($value)
	{
		if (isInt($value) || is_null($value)) { $this->order = $value; }
	}
	// Getter order
	public function getOrder()
	{
		return $this->order;
	}
	// Getter orderOriginal
	public function getOrderOriginal()
	{
		return $this->orderOriginal;
	}
	#endregion

}

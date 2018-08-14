<?php
/*************
* Třída CatalogVybaveniAssocEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class CatalogVybaveniAssocEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog_vybaveni_assoc";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog_vybaveni_assoc";
		$this->metadata["catalog_id"] = array("type" => "int(11)");
		$this->metadata["vybaveni_id"] = array("type" => "int(11)");
	}
	#endregion

	#region Property
	// int(11)
	protected $catalog_id;

	protected $catalog_idOriginal;
	// int(11)
	protected $vybaveni_id;

	protected $vybaveni_idOriginal;
	#endregion

	#region Method
	// Setter catalog_id
	protected function setCatalog_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->catalog_id = $value; }
	}
	// Getter catalog_id
	public function getCatalog_id()
	{
		return $this->catalog_id;
	}
	// Getter catalog_idOriginal
	public function getCatalog_idOriginal()
	{
		return $this->catalog_idOriginal;
	}
	// Setter vybaveni_id
	protected function setVybaveni_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->vybaveni_id = $value; }
	}
	// Getter vybaveni_id
	public function getVybaveni_id()
	{
		return $this->vybaveni_id;
	}
	// Getter vybaveni_idOriginal
	public function getVybaveni_idOriginal()
	{
		return $this->vybaveni_idOriginal;
	}
	#endregion

}

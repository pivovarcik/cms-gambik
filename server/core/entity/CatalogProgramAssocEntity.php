<?php
/*************
* Třída CatalogProgramAssocEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("Entity.php");
class CatalogProgramAssocEntity extends Entity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_catalog_program_assoc";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_catalog_program_assoc";
		$this->metadata["catalog_id"] = array("type" => "int(11)");
		$this->metadata["program_id"] = array("type" => "int(11)");
	}
	#endregion

	#region Property
	// int(11)
	protected $catalog_id;

	protected $catalog_idOriginal;
	// int(11)
	protected $program_id;

	protected $program_idOriginal;
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
	// Setter program_id
	protected function setProgram_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->program_id = $value; }
	}
	// Getter program_id
	public function getProgram_id()
	{
		return $this->program_id;
	}
	// Getter program_idOriginal
	public function getProgram_idOriginal()
	{
		return $this->program_idOriginal;
	}
	#endregion

}

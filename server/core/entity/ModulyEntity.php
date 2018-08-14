<?php
/*************
* Třída ModulyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class ModulyEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_moduly";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_moduly";
		$this->metadata["status"] = array("type" => "int");
	}
	#endregion

	#region Property
	// int
	protected $status;

	protected $statusOriginal;
	#endregion

	#region Method
	// Setter status
	protected function setStatus($value)
	{
		if (isInt($value) || is_null($value)) { $this->status = $value; }
	}
	// Getter status
	public function getStatus()
	{
		return $this->status;
	}
	// Getter statusOriginal
	public function getStatusOriginal()
	{
		return $this->statusOriginal;
	}
	#endregion

}

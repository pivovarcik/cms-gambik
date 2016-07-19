<?php
/*************
* Třída OkresyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class OkresyEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_okresy";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_okresy";
		$this->metadata["kraj_id"] = array("type" => "int");
	}
	#endregion

	#region Property
	// int
	protected $kraj_id;

	protected $kraj_idOriginal;
	#endregion

	#region Method
	// Setter kraj_id
	protected function setKraj_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->kraj_id = $value; }
	}
	// Getter kraj_id
	public function getKraj_id()
	{
		return $this->kraj_id;
	}
	// Getter kraj_idOriginal
	public function getKraj_idOriginal()
	{
		return $this->kraj_idOriginal;
	}
	#endregion

}

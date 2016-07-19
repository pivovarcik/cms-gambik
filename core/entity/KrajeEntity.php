<?php
/*************
* Třída KrajeEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("CiselnikEntity.php");
class KrajeEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_kraje";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_kraje";
		$this->metadata["stat_id"] = array("type" => "int");
	}
	#endregion

	#region Property
	// int
	protected $stat_id;

	protected $stat_idOriginal;
	#endregion

	#region Method
	// Setter stat_id
	protected function setStat_id($value)
	{
		if (isInt($value) || is_null($value)) { $this->stat_id = $value; }
	}
	// Getter stat_id
	public function getStat_id()
	{
		return $this->stat_id;
	}
	// Getter stat_idOriginal
	public function getStat_idOriginal()
	{
		return $this->stat_idOriginal;
	}
	#endregion

}

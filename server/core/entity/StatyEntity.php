<?php
/*************
* Třída StatyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("CiselnikEntity.php");
class StatyEntity extends CiselnikEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_staty";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_staty";
		$this->metadata["kod"] = array("type" => "varchar(3)");
	}
	#endregion

	#region Property
	// varchar(3)
	protected $kod;

	protected $kodOriginal;
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
	#endregion

}

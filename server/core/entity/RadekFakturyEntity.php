<?php
/*************
* Třída RadekFakturyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("RadekDokladuEntity.php");
class RadekFakturyEntity extends RadekDokladuEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_faktura_detail";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_faktura_detail";
		$this->metadata["doklad_id"]["reference"] = "Faktura";
	}
	#endregion

	#region Property
	#endregion

	#region Method
	// Setter doklad_id
	protected function setDoklad_id($value)
	{
		$this->doklad_id = $value;
	}
	// Getter doklad_id
	public function getDoklad_id()
	{
		return $this->doklad_id;
	}
	// Getter doklad_idOriginal
	public function getDoklad_idOriginal()
	{
		return $this->doklad_idOriginal;
	}
	#endregion

}

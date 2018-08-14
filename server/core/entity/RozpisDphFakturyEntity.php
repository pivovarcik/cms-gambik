<?php
/*************
* Třída RozpisDphFakturyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("RozpisDphDokladuEntity.php");
class RozpisDphFakturyEntity extends RozpisDphDokladuEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_rozpis_dph_faktury";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_rozpis_dph_faktury";
	}
	#endregion

	#region Property
	#endregion

	#region Method
	#endregion

}

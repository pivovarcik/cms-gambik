<?php
/*************
* Třída RadekObjednavkyEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2016-04-13 20:41:38 
*************/
require_once("RadekDokladuEntity.php");
class RadekObjednavkyEntity extends RadekDokladuEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_order_details";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_order_details";
	}
	#endregion

	#region Property
	#endregion

	#region Method
	#endregion

}

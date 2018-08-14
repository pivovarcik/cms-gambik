<?php
/*************
* Třída ShopSettingsEntity 
* Vygenerováno automaticky ze šablony, neupravovat - veškeré změny budou při dalším generování přepsány! 
* Date 2018-07-29 00:23:37 
*************/
require_once("SettingsEntity.php");
class ShopSettingsEntity extends SettingsEntity {
	#region constructor
	function __construct($entity = null, $lazyLoad = true)
	{
		$this->_name = "mm_shop_settings";
		if (isInt($entity)) {
			$entity = $this->getEntityById($entity);
		}
		parent::__construct($entity, $lazyLoad);
		$this->_name = "mm_shop_settings";
	}
	#endregion

	#region Property
	#endregion

	#region Method
	#endregion

}

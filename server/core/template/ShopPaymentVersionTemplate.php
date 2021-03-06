<?php


define("T_SHOP_ZPUSOB_PLATBY_VERSION",DB_PREFIX . "shop_zpusob_platby_version");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class ShopPaymentVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_ZPUSOB_PLATBY_VERSION;

		$this->_attributtes["name"] = array("type" => "varchar(50)");
		$this->_attributtes["description"] = array("type" => "longtext");

	//	$this->_attributtes["price_value"] = array("type" => "varchar(50)");
		$this->_attributtes["price"] = array("type" => "decimal(12,2)");

		$this->_attributtes["lang_id"] = array("type" => "int(11)");
		$this->_attributtes["page_id"] = array("type" => "int(11)");
	}
}

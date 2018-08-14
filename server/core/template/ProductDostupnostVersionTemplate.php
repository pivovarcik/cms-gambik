<?php


define("T_PRODUCT_DOSTUPNOST_VERSION",DB_PREFIX . "product_dostupnost_version");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class ProductDostupnostVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_DOSTUPNOST_VERSION;

		$this->_attributtes["name"] = array("type" => "longtext");
		$this->_attributtes["lang_id"] = array("type" => "int(11)");
		$this->_attributtes["dostupnost_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference"=>"ProductDostupnost");
	}
}

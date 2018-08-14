<?php


define("T_SHOP_PRODUCT_ATTRIBUTES_VERSION",DB_PREFIX . "product_attributes_version");

/**
 * Entita Data
 *
 */

require_once("Template.php");
class ProductAttributesVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_ATTRIBUTES_VERSION;

		$this->_attributtes["name"] = array("type" => "varchar(255)");
		$this->_attributtes["description"] = array("type" => "longtext");
		$this->_attributtes["lang_id"] = array("type" => "int(11)");
		$this->_attributtes["attrib_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference"=>"ProductAttributes");
	}
}

<?php
define("T_SHOP_PRODUCT_ATTRIBUTE_VALUES",DB_PREFIX . "product_attribute_values");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ProductAttributeValuesTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_ATTRIBUTE_VALUES;

		$this->_attributtes["name"] = array("type" => "varchar(50)");
		$this->_attributtes["attribute_id"] = array("type" => "int");

	}
}

<?php
define("T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC",DB_PREFIX . "product_attribute_value_association");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ProductAttributeValueAssociationTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_ATTRIBUTE_VALUE_ASSOC;

		$this->_attributtes["product_id"] = array("type" => "int", "reference" => "Product", "default" => "NOT NULL");
		$this->_attributtes["attribute_id"] = array("type" => "int", "reference" => "ProductAttributeValues", "default" => "NOT NULL");
		$this->_attributtes["order"] = array("type" => "int");
		$this->_attributtes["cost_difference"] = array("type" => "double");
	}
}

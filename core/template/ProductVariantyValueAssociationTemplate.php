<?php
define("T_SHOP_PRODUCT_VARIANTY_VALUE_ASSOC",DB_PREFIX . "product_varianty_value_association");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ProductVariantyValueAssociationTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_VARIANTY_VALUE_ASSOC;

		$this->_attributtes["varianty_id"] = array("type" => "int", "reference" => "ProductVarianty", "default" => "NOT NULL");
		$this->_attributtes["attribute_id"] = array("type" => "int", "reference" => "ProductAttributeValues", "default" => "NOT NULL");
		$this->_attributtes["order"] = array("type" => "int");
	}
}
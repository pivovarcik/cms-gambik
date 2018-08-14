<?php
/**
 * Řeší stavy produktů
 * */

define("T_SHOP_PRODUCT_STAVY",DB_PREFIX . "product_stavy");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductStavTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_STAVY;
		$this->parent = "Entity";

		$this->_attributtes["product_id"] = array("type" => "int", "default" => "NOT NULL","reference" => "Product");
		$this->_attributtes["varianty_id"] = array("type" => "int", "reference" => "ProductVarianty");
		//$this->_attributtes["varianty_assoc_id"] = array("type" => "int", "reference" => "ProductVariantyValueAssociation");
		$this->_attributtes["qty"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["qty_min"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["qty_max"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");
	}
}

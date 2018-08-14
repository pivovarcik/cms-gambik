<?php
define("T_SHOP_PRODUCT_VARIANTY",DB_PREFIX . "product_varianty");

/**
 * Entita Guestbook
 *
 */

require_once("Template.php");
class ProductVariantyTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_VARIANTY;

		$this->_attributtes["product_id"] = array("type" => "int", "reference" => "Product", "default" => "NOT NULL");

		$this->_attributtes["dostupnost_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductDostupnost");

		$this->_attributtes["name"] = array("type" => "varchar(255)","default" => "NULL");
		$this->_attributtes["code"] = array("type" => "varchar(255)","default" => "NULL");
		$this->_attributtes["order"] = array("type" => "int");

		$this->_attributtes["qty"] = array("type" => "decimal(12,2)");
		$this->_attributtes["stav_qty"] = array("type" => "decimal(12,2)");
		$this->_attributtes["stav_qty_min"] = array("type" => "decimal(12,2)");
		$this->_attributtes["stav_qty_max"] = array("type" => "decimal(12,2)");
		$this->_attributtes["price"] = array("type" => "decimal(12,2)");
		$this->_attributtes["price_sdani"] = array("type" => "decimal(12,2)");

		$this->_attributtes["dph_id"] = array("type" => "int", "default" => "NULL","reference" => "Dph");
	}
}
<?php


define("T_SHOP_TEMP_CART",DB_PREFIX . "shop_basket");

/**
 * Entita Foto
 *
 */

require_once("Template.php");
class ProductBasketTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_TEMP_CART;
		$this->_attributtes["mnozstvi"] = array("type" => "float");
		$this->_attributtes["price"] = array("type" => "decimal(10,2)", "default"=>"null");
		$this->_attributtes["price_sdani"] = array("type" => "decimal(10,2)", "default"=>"null");
		$this->_attributtes["product_id"] = array("type" => "int", "default"=>"null", "reference" => "Product");
		$this->_attributtes["tandem_id"] = array("type" => "int", "default"=>"null", "reference" => "Product");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(30)", "index" => true);
		$this->_attributtes["basket_id"] = array("type" => "varchar(50)", "default"=>"not null", "index" => true);
		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"null", "reference" => "User");

		$this->_attributtes["varianty_id"] = array("type" => "int", "default"=>"null", "reference" => "ProductVarianty");


		$this->_attributtes["typ_slevy"] = array("type" => "varchar(1)", "default" => "NULL");
		$this->_attributtes["sleva"] = array("type" => "numeric(12,2)");

	}
}

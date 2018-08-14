<?php

define("T_PRODUCT_POHYB",DB_PREFIX . "product_pohyb");

require_once("Template.php");
class ProductPohybTemplate extends Template { 

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_POHYB;
		$this->_attributtes["mnozstvi"] = array("type" => "float");
		$this->_attributtes["price"] = array("type" => "decimal(10,2)", "default"=>"null");
		$this->_attributtes["price_sdani"] = array("type" => "decimal(10,2)", "default"=>"null");
    
		$this->_attributtes["celkem"] = array("type" => "decimal(10,2)", "default"=>"null");
		$this->_attributtes["celkem_sdani"] = array("type" => "decimal(10,2)", "default"=>"null");    
		$this->_attributtes["product_id"] = array("type" => "int", "default"=>"null", "reference" => "Product");
		$this->_attributtes["doklad_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["tax_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["radek_id"] = array("type" => "int", "default"=>"null");
		$this->_attributtes["ip_adresa"] = array("type" => "varchar(30)", "index" => true);

		$this->_attributtes["user_id"] = array("type" => "int", "default"=>"null", "reference" => "User");

		$this->_attributtes["varianty_id"] = array("type" => "int", "default"=>"null", "reference" => "ProductVarianty");

		$this->_attributtes["typ_slevy"] = array("type" => "varchar(1)", "default" => "NULL");
		$this->_attributtes["description"] = array("type" => "varchar(255)", "default" => "NULL");
		$this->_attributtes["datum"] = array("type" => "datetime", "default" => "NULL");
		$this->_attributtes["sleva"] = array("type" => "numeric(12,2)");

	}
}

<?php


define("T_SHOP_PRODUCT_VERSION",DB_PREFIX . "products_version");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductVersionTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT_VERSION;
		$this->parent = "PageVersionEntity";

		$this->_attributtes["page_id"]["reference"] = "Product";

		$this->_attributtes["hl_mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");
		$this->_attributtes["mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");
//		$this->_attributtes["category_id"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["skupina_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCategory");
		$this->_attributtes["vyrobce_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductVyrobce");

		$this->_attributtes["prodcena"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["prodcena_sdph"] = array("type" => "decimal(10,2)", "default" => "0");





		$this->_attributtes["bezna_cena"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["sleva"] = array("type" => "decimal(4,2)", "default" => "NULL");
		$this->_attributtes["druh_slevy"] = array("type" => "varchar(1)", "default" => "NULL");
		$this->_attributtes["netto"] = array("type" => "decimal(8,2)", "default" => "NULL");

		$this->_attributtes["cislo1"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo2"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo3"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo4"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo5"] = array("type" => "decimal(10,2)", "default" => "NULL");

		$this->_attributtes["cislo6"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo7"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo8"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo9"] = array("type" => "decimal(10,2)", "default" => "NULL");
		$this->_attributtes["cislo10"] = array("type" => "decimal(10,2)", "default" => "NULL");


		$this->_attributtes["polozka1"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka2"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka3"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka4"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka5"] = array("type" => "varchar(100)", "default" => "NULL");


		$this->_attributtes["polozka6"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka7"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka8"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka9"] = array("type" => "varchar(100)", "default" => "NULL");
		$this->_attributtes["polozka10"] = array("type" => "varchar(100)", "default" => "NULL");




		$this->_attributtes["dostupnost"] = array("type" => "varchar(100)", "default" => "NULL");

		$this->_attributtes["ppc_zbozicz"] = array("type" => "decimal(10,2)", "default" => "NULL");

	}
}

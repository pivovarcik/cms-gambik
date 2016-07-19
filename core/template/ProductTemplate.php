<?php


define("T_SHOP_PRODUCT",DB_PREFIX . "products");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SHOP_PRODUCT;
		$this->parent = "PageEntity";

		$this->_attributtes["cislo"] = array("type" => "varchar(30)", "default" => "NULL", "index" => true);
		$this->_attributtes["cis_skladu"] = array("type" => "varchar(5)", "default" => "NULL");
		$this->_attributtes["typ_sort"] = array("type" => "varchar(1)", "default" => "NULL");

		$this->_attributtes["hl_mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");
		$this->_attributtes["mj_id"] = array("type" => "int", "default" => "NULL","reference" => "Mj");

		$this->_attributtes["dph_id"] = array("type" => "int", "default" => "NULL","reference" => "Dph");
//		$this->_attributtes["category_id"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["skupina_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCategory");
		$this->_attributtes["vyrobce_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductVyrobce");
	//	$this->_attributtes["foto_id"] = array("type" => "int", "default" => "NULL");
		$this->_attributtes["aktivni"] = array("type" => "int", "default" => "0", "index" => true);


		$this->_attributtes["min_prodcena"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["min_prodcena_sdph"] = array("type" => "decimal(10,2)", "default" => "0");


		$this->_attributtes["max_prodcena"] = array("type" => "decimal(10,2)", "default" => "0");
		$this->_attributtes["max_prodcena_sdph"] = array("type" => "decimal(10,2)", "default" => "0");

		$this->_attributtes["nakupni_cena"] = array("type" => "decimal(10,2)", "default" => "0");


		// příznak bazarové položky, defaultně je položka nová
		$this->_attributtes["bazar"] = array("type" => "int", "default" => "0", "index" => true);

		// obsahuje varianty
		$this->_attributtes["isVarianty"] = array("type" => "int", "default" => "0", "index" => true);

		$this->_attributtes["qty"] = array("type" => "decimal(10,2)", "default" => "NULL");

		$this->_attributtes["code01"] = array("type" => "varchar(150)", "default" => "NULL", "index" => true);
		$this->_attributtes["code02"] = array("type" => "varchar(150)", "default" => "NULL", "index" => true);
		$this->_attributtes["code03"] = array("type" => "varchar(150)", "default" => "NULL", "index" => true);

		// neexportovat do porovnávačů
		$this->_attributtes["neexportovat"] = array("type" => "int", "default" => "0");

		$this->_attributtes["dostupnost_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductDostupnost");


		$this->_attributtes["zaruka_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductZaruka");
	// ceník se defnuje přes kod, jeden produkt může mít více cen pro více kodu.
	//	$this->_attributtes["cenik_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCenik");



	}
}

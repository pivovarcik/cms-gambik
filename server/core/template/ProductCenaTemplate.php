<?php


define("T_PRODUCT_CENA",DB_PREFIX . "product_ceny");

/**
 * Entita Language
 *
 */

require_once("Template.php");
class ProductCenaTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_PRODUCT_CENA;
	//	$this->parent = "CiselnikEntity";


		$this->_attributtes["platnost_od"] = array("type" => "datetime");
		$this->_attributtes["platnost_do"] = array("type" => "datetime");
		$this->_attributtes["typ_slevy"] = array("type" => "varchar(1)", "default" => "NULL");
		$this->_attributtes["sleva"] = array("type" => "numeric(12,2)");
	//	$this->_attributtes["priorita"] = array("type" => "int", "default" => 0);

		$this->_attributtes["cenik_cena"] = array("type" => "numeric(12,2)");
		$this->_attributtes["cenik_id"] = array("type" => "int", "reference" => "ProductCenik", "default" => "NOT NULL");
		$this->_attributtes["product_id"] = array("type" => "int", "reference" => "Product","default" => "NOT NULL");
	}
}

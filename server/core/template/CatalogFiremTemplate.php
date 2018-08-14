<?php
define("T_CATALOG_FIREM",DB_PREFIX . "catalog_firem");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CatalogFiremTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_FIREM;
		$this->parent = "CatalogEntity";

	//	$this->_attributtes["showPosted"] = array("type" => "tinyint(1)", "default" => "0");
	//	$this->_attributtes["vlastnik_id"] = array("type" => "int");
	//	$this->_attributtes["counter"] = array("type" => "int", "default" => "0");
		$this->_attributtes["mesto_id"] = array("type" => "int", "default" => "0");
		$this->_attributtes["vip"] = array("type" => "int", "default" => "0");

		$this->_attributtes["cenik_id"] = array("type" => "int", "default" => "NULL","reference" => "ProductCenik");

	}
}

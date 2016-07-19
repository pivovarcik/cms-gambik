<?php
define("T_CATALOG_VYBAVENI",DB_PREFIX . "catalog_vybaveni");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CatalogVybaveniTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_VYBAVENI;
		$this->_attributtes["hodnota"] = array("type" => "varchar(100)");
		$this->_attributtes["order"] = array("type" => "int(11)", "default" => "0");
	}
}

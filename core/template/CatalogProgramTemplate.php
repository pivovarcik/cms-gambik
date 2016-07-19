<?php
define("T_CATALOG_PROGRAM",DB_PREFIX . "catalog_program");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CatalogProgramTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_PROGRAM;
		$this->_attributtes["hodnota"] = array("type" => "varchar(100)");
		$this->_attributtes["order"] = array("type" => "int(11)", "default" => "0");
	}
}

<?php
define("T_CATALOG_PROGRAM_ASSOC",DB_PREFIX . "catalog_program_assoc");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CatalogProgramAssocTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_PROGRAM_ASSOC;
		$this->_attributtes["catalog_id"] = array("type" => "int(11)");
		$this->_attributtes["program_id"] = array("type" => "int(11)");
	}
}

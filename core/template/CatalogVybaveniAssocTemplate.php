<?php
define("T_CATALOG_VYBAVENI_ASSOC",DB_PREFIX . "catalog_vybaveni_assoc");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CatalogVybaveniAssocTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_VYBAVENI_ASSOC;
		$this->_attributtes["catalog_id"] = array("type" => "int(11)");
		$this->_attributtes["vybaveni_id"] = array("type" => "int(11)");
	}
}

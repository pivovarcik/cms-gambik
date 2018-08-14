<?php


define("T_CATALOG_GROUP",DB_PREFIX . "catalog_group");

/**
 * Entita CatalogGroup
 *
 */

require_once("Template.php");
class CatalogGroupTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_GROUP;
		$this->parent = "CiselnikEntity";
	}
}

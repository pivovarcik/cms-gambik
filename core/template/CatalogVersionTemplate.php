<?php
define("T_CATALOG_VERSION",DB_PREFIX . "catalog_version");

/**
 * Verzování obsahu kategorie
 *
 */
require_once("Template.php");
class CatalogVersionTemplate extends Template {
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG_VERSION;
		$this->parent = "PageVersionEntity";

		$this->_attributtes["foto_id"] = array("type" => "int", "default" => "null", "reference" => "Foto");
	//	$this->_attributtes["vip"] = array("type" => "int", "default" => "0");
		$this->_attributtes["status_id"] = array("type" => "int", "default" => "0");
		$this->_attributtes["poradi"] = array("type" => "int", "default" => "0");
		$this->_attributtes["interni_poznamka"] = array("type" => "longtext", "default" => "null");
		$this->_attributtes["email"] = array("type" => "varchar(150)", "default" => "null");

	}
	/**
	 * Constructor
	 */

	//$this->_name = 'mm_articles_version';
}

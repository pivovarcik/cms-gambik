<?php
define("T_CATALOG",DB_PREFIX . "catalog");

/**
 * Entita pro Kategorie
 *
 */
require_once("Template.php");
class CatalogTemplate extends Template {

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATALOG;
		$this->parent = "PageEntity";
		$this->_attributtes["showPosted"] = array("type" => "tinyint(1)", "default" => "0");
		$this->_attributtes["vlastnik_id"] = array("type" => "int", "reference" => "User");
		$this->_attributtes["user_edit_id"] = array("type" => "int", "reference" => "User");
		$this->_attributtes["counter"] = array("type" => "int", "default" => "0");
		$this->_attributtes["foto_id"] = array("type" => "int", "default" => "null", "reference" => "Foto");
		$this->_attributtes["logo_id"] = array("type" => "int", "default" => "null", "reference" => "Foto");
		$this->_attributtes["catalog_group_id"] = array("type" => "int", "default" => "null", "reference" => "CatalogGroup");
	}
}

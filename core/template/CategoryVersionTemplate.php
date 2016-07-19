<?php
define("T_CATEGORY_VERSION",DB_PREFIX . "category_version");

/**
 * Verzování obsahu kategorie
 *
 */
require_once("Template.php");
class CategoryVersionTemplate extends Template {
	function __construct()
	{
		parent::__construct();
		$this->_name = T_CATEGORY_VERSION;
		$this->parent = "PageVersionEntity";

		$this->_attributtes["page_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "Category");
	}

}

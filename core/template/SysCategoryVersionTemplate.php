<?php
define("T_SYSCATEGORY_VERSION",DB_PREFIX . "syscategory_version");

/**
 * Verzování obsahu kategorie
 *
 */
require_once("Template.php");
class SysCategoryVersionTemplate extends Template {
	function __construct()
	{
		parent::__construct();
		$this->_name = T_SYSCATEGORY_VERSION;
		$this->parent = "CategoryVersionEntity";
		$this->_attributtes["page_id"] = array("type" => "int(11)", "default" => "NOT NULL", "reference" => "SysCategory");
		$this->_attributtes["category_id"] = array("type" => "int(11)", "default" => "NULL", "reference" => "SysCategory");

		//$this->_attributtes["page_id"] = array();
		//unset($this->_attributtes["page_id"]);
	}

}
